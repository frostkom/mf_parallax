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
						.get_menu_parallax(array('where' => 'header'));
					}

					echo "<div class='clear'></div>
				</div>
			</header>";

			if(is_active_sidebar('widget_slide'))
			{
				echo "<mf-slide-nav>
					<div>
						<i class='fa fa-close'></i>";

						dynamic_sidebar('widget_slide');

					echo "</div>
				</mf-slide-nav>";
			}

			if(is_active_sidebar('widget_pre_content'))
			{
				list($options_params, $options) = get_params();

				echo "<div id='mf-pre-content'".(isset($options['pre_content_full_width']) && $options['pre_content_full_width'] == 2 ? " class='full_width'" : "").">
					<div>";

						dynamic_sidebar('widget_pre_content');

					echo "</div>
				</div>";
			}

			echo "<mf-content>
				<div>";