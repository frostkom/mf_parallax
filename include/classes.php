<?php

class widget_parallax_logo extends WP_Widget
{
	function widget_parallax_logo()
	{
		$widget_ops = array(
			'classname' => 'parallax',
			'description' => __("Display logo", 'lang_parallax')
		);

		$control_ops = array('id_base' => 'parallax-logo-widget');

		$this->__construct('parallax-logo-widget', __("Theme Logo", 'lang_parallax'), $widget_ops, $control_ops);
	}

	function widget($args, $instance)
	{
		extract($args);

		echo $before_widget
			.get_logo_parallax()
		.$after_widget;
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		//$instance[''] = strip_tags($new_instance['']);

		return $instance;
	}

	function form($instance)
	{
		$defaults = array(
			//'' => "",
		);
		$instance = wp_parse_args((array)$instance, $defaults);

		echo "<p>".__("No need for settings here, we'll take care of the rest", 'lang_parallax')."</p>";
	}
}

class widget_parallax_menu extends WP_Widget
{
	function widget_parallax_menu()
	{
		$widget_ops = array(
			'classname' => 'parallax',
			'description' => __("Display menu", 'lang_parallax')
		);

		$control_ops = array('id_base' => 'parallax-menu-widget');

		$this->__construct('parallax-menu-widget', __("Theme Menu", 'lang_parallax'), $widget_ops, $control_ops);
	}

	function widget($args, $instance)
	{
		extract($args);

		echo $before_widget
			.get_menu_parallax()
		.$after_widget;
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		//$instance[''] = strip_tags($new_instance['']);

		return $instance;
	}

	function form($instance)
	{
		$defaults = array(
			//'' => "",
		);
		$instance = wp_parse_args((array)$instance, $defaults);

		echo "<p>".__("No need for settings here, we'll take care of the rest", 'lang_parallax')."</p>";
	}
}