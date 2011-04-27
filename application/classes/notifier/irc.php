<?php
/**
 * Notifier for IRC
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2010 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
class Notifier_IRC implements Notifier
{
	/**
	 * Notifies IRC
	 * 
	 * @param Model_Ciko_Project $project the project to notify with
	 * @param bool               $status  if the job ran successfully
	 *
	 * @return bool
	 */
	public function execute(Model_Ciko_Project $project, $status)
	{
		// Notification was sucessful
		return TRUE;
	}
}