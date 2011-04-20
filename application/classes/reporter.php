<?php
/**
 * Interface for reporters
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2011 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
abstract class Reporter
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
	 * Method interface for analyzing reports
	 *
	 * @return bool
	 */
	abstract public function analyze();

	/**
	 * Method interface for rendering results as HTML
	 *
	 * @return string
	 */
	abstract public function render_html();
}