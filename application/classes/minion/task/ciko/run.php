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

		$project = Kohana::config('ciko.projects.'.$config['project']);
		if (NULL === $project)
		{
			return Minion_CLI::write('That project doesn\'t exist!', 'red');
		}

		try
		{
			// Clone the source
			$git = new Git(
				Kohana::config('ciko.clone_path').url::title($project->name())
			);
			Minion_CLI::write(
				$git->clone_remote(
					$project->repository(), '-b '.$project->branch().
					' --recursive',
					TRUE
				),
				'yellow'
			);

			$runner = Runner::factory(
				$project->runner(),
				Kohana::config('ciko.clone_path').url::title($project->name())
			);

			$status = $runner->execute();

			// Run reporters if status was success
			if ($status)
			{
				$output = array(
					'stdout' => $runner->stdout(),
					'reporters' => array(),
				);

				foreach ($project->reporters() as $reporter)
				{
					$output['reporters'][$reporter->name()] =
						$reporter->analyze();
				}

				$project->write(
					json_encode($output), $runner->stderr(), $status
				);
			}
			else
			{
				$project->write(
					json_encode($runner->stdout()), $runner->stderr(), $status
				);
			}

			// Run notifiers
			foreach ($project->notifiers() as $notifier)
			{
				$notifier->execute($project, $status);
			}

			if ($status)
			{
				return Minion_CLI::write(
					'Job successfully ran for project '.$config['project'].':'
						.PHP_EOL.$runner->stdout(),
					'green');
			}
			else
			{
				return Minion_CLI::write(
					'There was an error executing the runner ('.$status.'):'
						.PHP_EOL.$runner->stderr().')',
					'red');
			}
		}
		catch (Exception $e)
		{
			// Write out the error
			$project->write('', json_encode($e->getMessage()), $e->getCode());
			exit(1);
		}
	}
}