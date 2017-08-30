<?php

namespace App;


trait Strict
{
	/**
	 * @param  string
	 * @throws \LogicException
	 */
	public function & __get($name)
	{
		throw new \LogicException("Reading undeclared member " . get_class($this) . "::$$name.");
	}


	/**
	 * @param  string
	 * @param  mixed
	 * @throws \LogicException
	 */
	public function __set($name, $value)
	{
		throw new \LogicException("Setting undeclared member " . get_class($this) . "::$$name.");
	}
}
