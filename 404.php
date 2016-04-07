<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header();

	echo "<article id='404'>
		<h1>".__('Not Found', 'Theme')."</h1>
		<section>
			<p>".__('Apologies, but the page you requested could not be found. Perhaps searching will help.', 'Theme')."</p>";

			get_search_form();

		echo "</section>
	</article>";

get_footer();