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
		<title>";

			wp_title('|', true, 'right');

			echo get_bloginfo('name');

			$site_description = get_bloginfo('description', 'display');

			if($site_description != '' && (is_home() || is_front_page()))
			{
				echo " | ".$site_description;
			}

			if($paged >= 2 || $page >= 2)
			{
				echo " | ".sprintf( __('Page %s', 'lang_parallax'), max($paged, $page));
			}

		echo "</title>";

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