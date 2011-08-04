<?php
/**
 * Interface for post runners
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2011 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
abstract class Post_Runner
{
	/**
	 * Returns a name for this reporter
	 *
	 * @return string
	 */
	public function name()
	{
		return $this->_name;
	}

	/**
	 * Runs a post runner command
	 * 
	 * @param Model_Ciko_Project $project the project to notify with
	 * @param bool               $status  if the job ran successfully
	 *
	 * @return bool
	 */
	public function execute(Model_Ciko_Project $project, $status);
}