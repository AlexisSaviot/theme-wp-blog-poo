<?php

/**
 * Allow to use the SliderModel on the widget area and defined the rendering
 */
class SliderWidget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct('slider_widget', 'Slider Widget');
	}

	public function widget($args, $instance)
	{
		echo $args['before_widget'];
		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}
		global $core_theme;
		$slider_controller = new SliderController;
		$slider = $slider_controller->getSlider(132);
		$attributes = ['app-slider' => json_encode($slider)];
		// var_dump($attributes);
		echo $core_theme->loadAngularApp('slider', $attributes, true);
		echo $args['after_widget'];
	}

	public function form($instance)
	{
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'text_domain');
?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'text_domain'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
<?php
	}

	public function update($new_instance, $old_instance)
	{
		$instance = [];
		$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';

		return $instance;
	}
}
