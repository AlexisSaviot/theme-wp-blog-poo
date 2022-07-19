<?php
if (!defined('ABSPATH')) exit;

/**
 * Take data from model, adapts them to the view
 */
class Controller
{	
	public $taxonomy;
	
	protected function __construct($post_type, $model)
	{
		global $core_theme;
		$this->post_type = $post_type;
		$this->model = $model;
		$lang = explode('-', $core_theme->lang);
		$this->lang = $lang[0];

		$this->general_args = [
			'post_type' => $this->post_type,
			'post_status' => 'publish',
			'posts_per_page' => -1
		];
	}

	protected function get($id)
	{
		return new $this->model($id, 'single');
	}

	protected function all($other_args = [], $use_default_query = false)
	{
		$args = $this->general_args;

		if (!empty($other_args)) {
			foreach ($other_args as $key => $value) {
				$args[$key] = $value;
			}
		}

		return $this->posts($args, $use_default_query);
	}

	protected function posts($args, $use_default_query = false)
	{
		$results = [];

		foreach ($this->getQueryPosts($args, $use_default_query) as $post) {
			$results[] = new $this->model($post->ID);
		}

		return $results;
	}

	protected function query($args)
	{
		return $this->getQueryResults($args);
	}

	private function getQueryPosts($args, $use_default_query = false)
	{
		if ($use_default_query) {
			global $wp_query;
			$this->setDefaultQueryArgs($wp_query, $args);
			$results = $wp_query->get_posts();
		} else {
			$wp_query = new WP_Query($args);
			$results = $wp_query->posts;
		}
		$this->taxonomy = $wp_query->get_queried_object();
		wp_reset_query();
		
		return $results;
	}

	private function setDefaultQueryArgs($query, $args)
	{
		add_action( 'pre_get_posts', function ($query) use ($args) 
		{	
			if(! is_admin() && $query->is_main_query()){
				foreach($args as $label => $value) {
					$query->set($label, $value);
				}
			}
		});
		do_action('pre_get_posts', $query);
	}

	private function getQueryResults($args)
	{
		$wp_query = new WP_Query($args);
		$results = $wp_query;
		wp_reset_query();

		return $results;
	}

	public function getImage($id, $size = 'full')
	{
		$image = wp_get_attachment_image_src($id, $size);
		return $image[0];
	}

	public function getAttachment($id)
	{
		return wp_get_attachment_url($id);
	}
}
