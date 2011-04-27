<?php
/**
 * Interface for notifiers
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2011 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
interface Notifier
{
	/**
	 * Runs a notification
	 * 
	 * @param Model_Ciko_Project $project the project to notify with
	 * @param bool               $status  if the job ran successfully
	 *
	 * @return bool
	 */
	public function execute(Model_Ciko_Project $project, $status);
}