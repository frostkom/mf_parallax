<?php

class widget_parallax_logo extends WP_Widget
{
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'parallax',
			'description' => __("Display logo", 'lang_parallax')
		);

		$control_ops = array('id_base' => 'parallax-logo-widget');

		parent::__construct('parallax-logo-widget', __("Logo", 'lang_parallax'), $widget_ops, $control_ops);
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
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'parallax',
			'description' => __("Display menu", 'lang_parallax')
		);

		$control_ops = array('id_base' => 'parallax-menu-widget');

		parent::__construct('parallax-menu-widget', __("Menu", 'lang_parallax'), $widget_ops, $control_ops);
	}

	function widget($args, $instance)
	{
		extract($args);

		echo $before_widget
			.get_menu_parallax(array('type' => $instance['theme_menu_type'], 'where' => $id))
		.$after_widget;
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['theme_menu_type'] = strip_tags($new_instance['theme_menu_type']);

		return $instance;
	}

	function form($instance)
	{
		$defaults = array(
			'theme_menu_type' => "",
		);
		$instance = wp_parse_args((array)$instance, $defaults);

		echo "<div class='mf_form'>"
			.show_select(array('data' => get_menu_type_for_select(), 'name' => $this->get_field_name('theme_menu_type'), 'text' => __("Menu Type", 'lang_theme'), 'value' => $instance['theme_menu_type']))
		."</div>";
	}
}