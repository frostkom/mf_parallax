<?php
/**
 * The Footer for our theme.
 */

 if(!isset($obj_theme_core))
{
	$obj_theme_core = new mf_theme_core();
}

				echo "</div>
			</div>";

			if(is_active_sidebar('widget_footer'))
			{
				$obj_theme_core->get_params();

				echo "<footer".(isset($obj_theme_core->options['footer_full_width']) && $obj_theme_core->options['footer_full_width'] == 2 ? " class='full_width'" : "").">
					<div>";

						dynamic_sidebar('widget_footer');

					echo "</div>
				</footer>";
			}

		echo "</div>";

		wp_footer();

	echo "</body>
</html>";