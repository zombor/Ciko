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

	// Reporters to run
	protected $_reporters = array();

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
	 * Gets/sets the reporters for this object
	 *
	 * @return $this or array
	 */
	public function reporters($reporters = NULL)
	{
		if ($reporters)
		{
			$this->_reporters = $reporters;
			return $this;
		}

		return $this->_reporters;
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

		db::insert(
			'projects',
			array('project', 'result', 'stdout', 'stderr')
		)->values(
			array(url::title($this->name()), $status, $stdout, $stderr)
		)->execute();
	}
}