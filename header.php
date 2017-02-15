<?php
/**
 * The Header for our theme.
 */

echo "<!DOCTYPE html>
<html lang='".get_bloginfo('language')."'>
	<head>
		<meta charset='".get_bloginfo('charset')."'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<title>".get_wp_title()."</title>";

		wp_head();

	echo "</head>
	<body class='".implode(" ", get_body_class())."'>
		<div id='wrapper'>
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