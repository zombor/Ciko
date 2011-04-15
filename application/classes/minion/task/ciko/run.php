<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Runs a project
 *
 * Available config options: 
 *
 * --project=ciko
 *  
 *  Specify the project to run. It must be defined in config/ciko.php
 *
 *  This is a required config option
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2010 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
class Minion_Task_Ciko_Run extends Minion_Task
{
	/**
	 * An array of config options that this task can accept
	 */
	protected $_config = array('project');

	/**
	 * Executes a job
	 *
	 * @return Something
	 */
	public function execute(array $config)
	{
		if (empty($config['project']))
		{
			return Minion_CLI::write('Please specify a project.', 'red');
		}

		$project = Kohana::config('ciko.'.$config['project']);
		if (NULL === $project)
		{
			return Minion_CLI::write('That project doesn\'t exist!', 'red');
		}

		// Here we need to clone the git repository, and run the runner,
		// capturing the output. Pretty simple

		Git::$git_path = trim(`which git`);
		$git = new Git('/tmp/'.url::title($project->name()));
		$git->clone_remote($project->repository(), '-b '.$project->branch().' --recursive', TRUE);

		return Minion_CLI::write(
			'Job successfully ran for project '.$config['project'], 'green'
		);
	}
}