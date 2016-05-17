<?php
/**
 * The Header for our theme.
 */

global $page, $paged;

echo "<!DOCTYPE html>
<html lang='".get_bloginfo('language')."'>
	<head>
		<meta charset='".get_bloginfo('charset')."'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<title>".get_wp_title()."</title>";

		enqueue_theme_fonts();

		wp_enqueue_style('style', replace_stylesheet_url());

		wp_head();

	echo "</head>
	<body class='".implode(" ", get_body_class())."'>
		<header>
			<div>";

				if(is_active_sidebar('widget_header'))
				{
					dynamic_sidebar('widget_header');
				}

				else
				{
					list($options_params, $options) = get_params();

					echo get_logo_parallax($options)
					.get_menu_parallax();
				}

				echo "<div class='clear'></div>
			</div>
		</header>";

		if(is_active_sidebar('widget_pre_content'))
		{
			echo "<mf-pre-content>
				<div>";

					dynamic_sidebar('widget_pre_content');

				echo "</div>
			</mf-pre-content>";
		}

		echo "<mf-content>
			<div>";