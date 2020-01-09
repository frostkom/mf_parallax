<?php

include_once("include/classes.php");

$obj_parallax = new mf_parallax();

if(is_admin())
{
	add_action('rwmb_meta_boxes', array($obj_parallax, 'rwmb_meta_boxes'));
}

else
{
	add_action('wp_head', array($obj_parallax, 'wp_head'), 0);
}

add_filter('filter_is_file_used', array($obj_parallax, 'filter_is_file_used'));

add_action('after_setup_theme', array($obj_parallax, 'after_setup_theme'));
add_action('widgets_init', array($obj_parallax, 'widgets_init'));