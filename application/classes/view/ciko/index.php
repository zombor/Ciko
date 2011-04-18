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
			$projects[] = array(
				'name' => $project->name(),
				'uri' => Route::get('default')->uri(
					array(
						'controller' => 'ciko',
						'action' => 'project',
						'id' => url::title($project->name())
					)
				),
				'has_ran' => $project->has_run(),
				'status' => $project->latest_status(),
			);
		}

		return $projects;
	}
}