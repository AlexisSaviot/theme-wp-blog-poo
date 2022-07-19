<?php


if (!defined('ABSPATH')) exit;

/**
 * Connect to the db / recovers the differents elements needed for the current post type
 */
class Model
{
	protected function __construct($id, $context = "")
	{
		$this->ID = $id;
		$post = $this->getPost($this->ID);
		$this->type = $post->post_type;
		$this->title = $post->post_title;
		$this->slug = $post->post_name;
		$this->permalink = $this->getLink();
		$this->thumb = $this->getImage();
		$this->date = $this->getDate();
		$this->category = $this->getCategory();

		if ($context == "single") {
			if (!empty($post->post_content)) $this->content = apply_filters('the_content', $post->post_content);
		} else {
			$this->excerpt = $this->getExcerpt($post);
		}
	}

	private function getPost($id)
	{
		global $wpdb;

		$_post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d LIMIT 1", $id));
		if (!$_post) return false;

		return new WP_Post($_post);
	}

	private function getImage($size = 'full')
	{
		$img = wp_get_attachment_image_src(get_post_thumbnail_id($this->ID), $size);
		return $img ? $img[0] : null;
	}

	private function getExcerpt($post)
	{
		$post_excerpt = "";

		if (empty($post->post_excerpt)) {
			if (!empty($post->post_content)) $post_excerpt = wp_trim_words(strip_shortcodes($post->post_content), 60);
		} else {
			$post_excerpt = $post->post_excerpt;
		}

		return $post_excerpt;
	}

	private function getDate($format = 'd M Y')
	{
		return get_the_date($format, $this->ID);
	}

	private function getLink()
	{
		return get_permalink($this->ID);
	}

	protected function getMetaImage($meta_name, $size = 'full')
	{
		$photoID = get_post_meta($this->ID, $meta_name, true);
		return $this->getImageById($photoID, $size);
	}

	protected function getImageById($id, $size = 'full')
	{
		$img = wp_get_attachment_image_src($id, $size);
		if (empty($img)) return false;
		$image = $img[0];
		return $image;
	}

	/**
	 * Adds given metas to global meta array before initialization.
	 * @param  array $metas Metas to add
	 */
	public static function initMetas(array $metas)
	{
		global $core_metas;

		foreach ($metas as $meta) {
			$core_metas->add($meta);
		}
	}

	private function getCategory()
	{
		return get_the_category_list('', '', $this->ID);
	}
}
