<?php
/**
 * The Footer for our theme.
 */

			echo "</div>
		</mf-content>";

		if(is_active_sidebar('widget_footer'))
		{
			echo "<footer>
				<div>";

					dynamic_sidebar('widget_footer');

				echo "</div>
			</footer>";
		}

		list($options_params, $options) = get_params();

		$template_url = get_bloginfo('template_url');

		mf_enqueue_script('script_nav', $template_url."/include/jquery.nav.js");
		mf_enqueue_script('script_parallax', $template_url."/include/script.js", array('override_bg' => isset($options['header_override_bg_with_page_bg']) && $options['header_override_bg_with_page_bg'] == 2));

		wp_footer();

	echo "</body>
</html>";