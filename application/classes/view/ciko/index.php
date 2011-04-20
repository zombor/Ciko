<?php
/**
 * View file for the index
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2010 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
class View_Ciko_Index extends Kostache_Layout
{
	/**
	 * Var method to list all projects
	 *
	 * @return array
	 */
	public function projects()
	{
		$projects = array();

		foreach (Model_Ciko_Project::all() as $name => $project)
		{
			$history = array();
			foreach ($project->runs() as $run)
			{
				try
				{
					$stdout = json_decode($run->stdout);
					$history[] = array(
						'rowid' => $run->rowid,
						'result' => $run->result,
						'stdout' => $stdout->stdout,
						'stderr' => json_decode($run->stderr),
					);
				}
				catch (Exception $e)
				{
					// There was an error decoding the json, ignore for now
				}
			}

			$projects[] = array(
				'name' => $project->name(),
				'uri' => Route::get('default')->uri(
					array(
						'controller' => 'ciko',
						'action' => 'project',
						'id' => url::title($project->name()),
					)
				),
				'has_ran' => $project->has_run(),
				'status' => $project->latest_status(),
				'total_runs' => $project->total_num_runs(),
				'run_uri' => Route::get('default')->uri(
					array(
						'controller' => 'ciko',
						'action' => 'run',
						'id' => url::title($project->name()),
					)
				),
				'history' => $history,
			);
		}

		return $projects;
	}
}