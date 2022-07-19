<?php

if (!defined('ABSPATH')) exit;

$type = 'slider';

if (is_admin()) {
	add_action('init', 'remove_editor_init', 100);
}
function remove_editor_init()
{
	remove_post_type_support('slider', 'editor');
}

$args = [
	'label' 				=> 'Slider',
	'public' 				=> true,
	'publicly_queryable' 	=> true,
	'show_ui'            	=> true,
	'show_in_menu'       	=> true,
	'menu_position' 		=> 25,
	'has_archive' 			=> true,
	'supports' 				=> array('title', 'editor', 'custom-fields'),
	// 'hierarchical' => true,
	// 'taxonomies' => array('category', 'post_tag'),
];

$metas = [
	[
		'title'      => 'Slider',
		'post_types' => $type,

		'fields' => [
			[
				'name' => 'Image par slide',
				'id'   => 'imagesPerSlide',
				'type' => 'number',
			
				'min'  => 1,
				'max' => 5,
				'step' => 1,
				'std' => 1
			],
			[
				'id' => 'slides', // ID group
				'type' => 'group', // Data of “Group”
				'clone' => true,
				'sort_clone' => true,
				'fields' => [
					[
						'name'  => 'Image',
						'id'    => 'image',
						'type'  => 'single_image',
					],
					[
						'name' => 'Nom de l\'image',
						'id' => 'title',
						'type' => 'text'
					],
					[
						'name' => 'URL',
						'id' => 'url',
						'type' => 'text'
					],
				]
			],
		]
	]
];

$cpt = new CustomPostTypeHelper($type, $args, $metas);

/**
 * Use Model class to create sliders with 1 to 5 images for the sidebar.
 * ARGUMENTS :
 * - $id
 * - $context = ''
 */
class SliderModel extends Model
{
	public function __construct($id, $context = '')
	{
		parent::__construct($id, $context);

		$single = ['slides', 'imagesPerSlide'];

		foreach ($single as $meta) {
			$this->$meta = get_post_meta($id, $meta, true);
			// var_dump($meta);
		}

		$this->prepareSlides();
	}

	private function prepareSlides()
	{
		$slides = [];
		foreach ($this->slides as $slide) {
			$slide['image'] = $this->getImageById($slide['image']);
			$slides[] = $slide;
		}
		$this->slides = $slides;
	}
}
