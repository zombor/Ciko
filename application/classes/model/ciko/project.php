<?php

class Model_Ciko_Project extends Model
{
	// The project name
	protected $_name;

	// The repository to build
	protected $_repository;

	// The branch to build
	protected $_branch;

	// The runner command to execute
	protected $_runner;

	// The post runner commands to execute
	protected $_post_runners = array();

	// Reporters to run
	protected $_reporters = array();

	// Notifiers to run
	protected $_notifiers = array();

	/**
	 * Constructor that sets the project name
	 *
	 * @return null
	 */
	public function __construct($name)
	{
		$this->name($name);
	}

	/**
	 * Factory method
	 *
	 * @return Model_Ciko_Project
	 */
	public static function factory($name)
	{
		return new Model_Ciko_Project($name);
	}

	/**
	 * Gets/sets the name of this project
	 *
	 * @return $this or string
	 */
	public function name($name = NULL)
	{
		if ($name)
		{
			$this->_name = $name;
			return $this;
		}

		return $this->_name;
	}

	/**
	 * Returns a safe name for this project, removes spaces, etc (url::title())
	 *
	 * @return string
	 */
	public function safe_name()
	{
		return url::title($this->name());
	}

	/**
	 * Gets/sets the repository for this project
	 *
	 * @return $this or string
	 */
	public function repository($repo = NULL)
	{
		if ($repo)
		{
			$this->_repository = $repo;
			return $this;
		}

		return $this->_repository;
	}

	/**
	 * Gets/sets the branch for this project
	 *
	 * @return $this or string
	 */
	public function branch($branch = NULL)
	{
		if ($branch)
		{
			$this->_branch = $branch;
			return $this;
		}

		return $this->_branch;
	}

	/**
	 * Gets/sets the runner command for this project
	 *
	 * @todo   Should this return a Runner instance?
	 * @return $this or string
	 */
	public function runner($command = NULL)
	{
		if ($command)
		{
			$this->_runner = $command;
			return $this;
		}

		return $this->_runner;
	}

	/**
	 * Gets/sets the post runner command for this project
	 *
	 * @return $this or string
	 */
	public function post_runner(array $post_runners = NULL)
	{
		if ($post_runners)
		{
			foreach ($post_runners as $key => $post_runner)
			{
				if ( ! $post_runner instanceof Post_Runner)
				{
					throw new Kohana_Exception(
						'Invalid post runner :post_runner', array(
							':post_runner' => $key
						)
					);
				}
			}

			$this->_post_runners = $post_runners;
			return $this;
		}

		return $this->_post_runners;
	}

	/**
	 * Gets/sets the reporters for this object
	 *
	 * @return $this or array
	 */
	public function reporters(array $reporters = NULL)
	{
		if ($reporters)
		{
			foreach ($reporters as $key => $reporter)
			{
				if ( ! $reporter instanceof Reporter)
				{
					throw new Kohana_Exception(
						'Invalid reporter :reporter', array(':reporter' => $key)
					);
				}
			}

			$this->_reporters = $reporters;
			return $this;
		}

		return $this->_reporters;
	}

	/**
	 * Gets/sets the reporters for this object
	 *
	 * @return $this or array
	 */
	public function notifiers(array $notifiers = NULL)
	{
		if ($notifiers)
		{
			foreach ($notifiers as $key => $notifier)
			{
				if ( ! $notifier instanceof Notifier)
				{
					throw new Kohana_Exception(
						'Invalid notifier :notifier', array(':notifier' => $key)
					);
				}
			}
			$this->_notifiers = $notifiers;
			return $this;
		}

		return $this->_notifiers;
	}

	/**
	 * Writes a runner job output to the database
	 *
	 * @return null
	 */
	public function write($stdout, $stderr, $status)
	{
		Minion_CLI::write(
			'Saving output to database...',
			'blue'
		);

		Minion_CLI::write(
			$stdout,
			'green'
		);

		Minion_CLI::write(
			$stderr,
			'red'
		);

		db::insert(
			'projects',
			array('project', 'result', 'stdout', 'stderr')
		)->values(
			array(url::title($this->name()), $status, $stdout, $stderr)
		)->execute();

	}

	/**
	 * Returns an array of all projects
	 *
	 * @return array
	 */
	public static function all()
	{
		return Kohana::config('ciko.projects');
	}

	/**
	 * Returns if this project has had it's runner ran yet
	 *
	 * @return bool
	 */
	public function has_run()
	{
		return (bool) count(
			db::select('rowid')
				->from('projects')
				->where('project', '=', url::title($this->name()))
				->as_object()
				->execute()
		);
	}

	/**
	 * Returns all runs this project has ran
	 *
	 * @return array
	 */
	public function runs()
	{
		return db::select('rowid, *')
			->from('projects')
			->where('project', '=', url::title($this->name()))
			->order_by('rowid', 'desc')
			->as_object()
			->execute();
	}

	/**
	 * Gets the latest run from a runner job
	 *
	 * @return stdObject
	 */
	public function last_run()
	{
		return db::select('rowid, *')
			->from('projects')
			->where('project', '=', url::title($this->name()))
			->limit(1)->order_by('rowid', 'desc')
			->as_object()
			->execute()
			->current();
	}

	/**
	 * Return the status of the last runner job
	 *
	 * @return bool
	 */
	public function latest_status()
	{
		if ( ! $this->has_run())
		{
			return FALSE;
		}

		return (bool) db::select('result')
			->from('projects')
			->where('project', '=', url::title($this->name()))
			->limit(1)->order_by('rowid', 'desc')
			->as_object()
			->execute()
			->current()
			->result;
	}

	/**
	 * Total number of runs a project has had
	 *
	 * @return int
	 */
	public function total_num_runs()
	{
		return (int) db::select('count(*) as count')
			->from('projects')
			->where('project', '=', url::title($this->name()))
			->as_object()
			->execute()->current()->count;
	}
}