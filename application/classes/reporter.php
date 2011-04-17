<?php
/**
 * Interface for reporters
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2011 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
interface Reporter
{
	/**
	 * Method interface for analyzing reports
	 *
	 * @return null
	 */
	public function analyze();
}