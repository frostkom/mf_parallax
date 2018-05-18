<?php

include_once("include/classes.php");
include_once("include/functions.php");

if(is_admin())
{
	add_action('rwmb_meta_boxes', 'meta_boxes_parallax');
}

else
{
	add_action('wp_head', 'head_parallax', 0);
}

add_action('after_setup_theme', 'setup_parallax');
add_action('widgets_init', 'widgets_parallax');