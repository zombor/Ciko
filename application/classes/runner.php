<?php
/**
 * Interface for reporters
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2011 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
class Runner
{
	// Inputs
	protected $_command = NULL;
	protected $_cwd = NULL;
	protected $_env = NULL;

	// Outputs
	protected $_status = NULL;
	protected $_stdout = NULL;
	protected $_stderr = NULL;

	/**
	 * Creates a new instance of Runner
	 * 
	 * @param string|array $command the command to execute
	 * @param string       $cwd     the current working directory to execute
	 *                              the runner in
	 * @param array        $env     an array of env variables to execute the
	 *                              runner with
	 *
	 * @return Runner
	 */
	public static function factory($command, $cwd, $env = NULL)
	{
		return new Runner($command, $cwd, $env);
	}

	/**
	 * Constructor
	 * 
	 * @param string|array $command the command to execute
	 * @param string       $cwd     the current working directory to execute
	 *                              the runner in
	 * @param array        $env     an array of env variables to execute the
	 *                              runner with
	 *
	 * @return void
	 */
	public function __construct($command, $cwd, $env = NULL)
	{
		$this->_command = $command;
		$this->_cwd = $cwd;
		$this->_env = $env;
	}

	/**
	 * Run the specified command
	 *
	 * @return bool
	 */
	public function execute()
	{
		$descriptorspec = array(
			1 => array('pipe', 'w'),
			2 => array('pipe', 'w'),
		);

		$pipes = array();

		if (is_array($this->_command))
		{
			$this->_command = implode(' && ', $this->_command);
		}

		$resource = proc_open(
			$this->_command,
			$descriptorspec,
			$pipes,
			$this->_cwd,
			$this->_env
		);

		// Capture the runner output
		$this->_stdout = stream_get_contents($pipes[1]);
		$this->_stderr = stream_get_contents($pipes[2]);

		foreach ($pipes as $pipe)
		{
			fclose($pipe);
		}

		$status = trim(proc_close($resource));

		// Invert the return from proc_close
		$this->_status = ! $status ? TRUE : FALSE;

		return $this->_status;
	}

	/**
	 * Gets the command status
	 *
	 * @return string
	 */
	public function status()
	{
		return $this->_status;
	}

	/**
	 * Gets the contents of STDOUT
	 *
	 * @return string
	 */
	public function stdout()
	{
		return $this->_stdout;
	}

	/**
	 * Gets the contents of STDERR
	 *
	 * @return string
	 */
	public function stderr()
	{
		return $this->_stderr;
	}
}