<?php
/**
 * Created by PhpStorm.
 * User: Well
 * Date: 11/08/2017
 * Time: 00:29
 */

namespace Well\Repository\Generators;

class Generator
{
	protected $config;

	public function __construct()
	{
		$this->getConfig();
	}

	public function getNamespace()
	{
		$namespace = $this->config->generator->root_namespace;

		if (substr($namespace, -1) == '\\') $namespace = substr($namespace, 0, strlen($namespace) - 1);

		return $namespace;
	}

	public function getBasePath()
	{
		return $this->config->generator->base_path;
	}

	public function getConfigPath($type)
	{
		return str_replace('\\', '/', $this->getBasePath() . '/' . $this->config->generator->paths->$type . '/');
	}

	public function getConfig()
	{
		$config = config('repository');

		$this->config = json_decode(json_encode($config));
	}
}