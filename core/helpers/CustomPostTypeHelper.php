<?php

/**
 * Call a new CustomPostTypeHelper to create a new custom post type.
 * ARGUMENTS : 
 * - $name : the name of the custom post type
 * - $args : an array of options for the register_post_type
 * - $metas : an array which contains the metas for MetaBox
 */
class CustomPostTypeHelper
{
	private $name = '';
	private $args = [];
	private $metas = [];

	public function __construct($name, $args, $metas, $is_registered = false)
	{
		$this->name = $name;
		$this->args = $args;
		$this->metas = $metas;

		if (!$is_registered) {
			add_action('init', array($this, 'createPost'));
		}
		if (is_admin()) Model::initMetas($this->metas);
	}

	public function createPost()
	{
		register_post_type($this->name, $this->args);
	}
}
