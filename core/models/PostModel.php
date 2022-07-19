<?php

if (!defined('ABSPATH')) exit;

$type = 'post';

$metas = [
	[
		'title'      => 'Slider',
		'post_types' => $type,

		'fields' => [
			[
				'name'        => 'Select a slider',
				'id'          => 'slider',
				'type'        => 'post',
				'post_type'   => 'slider',
				'field_type'  => 'select_advanced',
			]
		]
	]
];

$cpt = new CustomPostTypeHelper($type, [], $metas, true);

/**
 * Allow to select a slider on a post
 */
class PostModel extends Model
{
	public function __construct($id, $context = "")
	{
		parent::__construct($id, $context);

		if($context == 'single') {
			$this->slider = get_post_meta($id, 'slider', true);
			
			if($this->slider) {
				$this->slider = new SliderModel($this->slider);
			}
		}
	}
}
