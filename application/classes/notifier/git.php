<?php
/**
 * Notifier for Git repositories
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2010 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
class Notifier_Git implements Notifier
{
	/**
	 * Tags the repository with the current build
	 * 
	 * @param Model_Ciko_Project $project the project to notify with
	 * @param bool               $status  if the job ran successfully
	 *
	 * @return bool
	 */
	public function execute(Model_Ciko_Project $project, $status)
	{
		// Only notify on a successful build
		if ($status)
		{
			$git = new Git(
				Kohana::config('ciko.clone_path').url::title($project->name())
			);

			$git->execute(
				'tag -a -m "Ciko Build #'.
					$project->last_run()->rowid.
					'" ciko-#'.$project->last_run()->rowid
			);

			$git->execute('push --tags');

			// Notification was sucessful
			return TRUE;
		}

		return FALSE;
	}
}