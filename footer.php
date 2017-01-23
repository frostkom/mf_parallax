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

		wp_footer();

	echo "</body>
</html>";