<?php
/**
 * The Footer for our theme.
 */

				echo "</div>
			</div>";

			if(is_active_sidebar('widget_footer'))
			{
				echo "<footer>
					<div>";

						dynamic_sidebar('widget_footer');

					echo "</div>
				</footer>";
			}

		echo "</div>";

		wp_footer();

	echo "</body>
</html>";