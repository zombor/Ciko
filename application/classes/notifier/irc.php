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
	 * @return bool
	 */
	public function execute(Model_Ciko_Project $project)
	{
		// Notification was sucessful
		return TRUE;
	}
}