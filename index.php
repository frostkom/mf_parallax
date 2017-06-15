<?php
/**
 * The main template file.
 */

get_header();

	$meta_prefix = "mf_parallax_";

	$result = $wpdb->get_results("SELECT ID, post_content, post_name FROM ".$wpdb->posts." WHERE post_type = 'page' AND post_status = 'publish' ORDER BY menu_order ASC");

	foreach($result as $post)
	{
		$post_id = $post->ID;
		$post_content = apply_filters('the_content', $post->post_content);
		$post_name = $post->post_name;

		$post_show_on_page = get_post_meta_or_default($post_id, $meta_prefix.'show_on_page', true, 'yes');

		if($post_show_on_page == 'yes')
		{
			$post_heading = get_post_meta($post_id, $meta_prefix.'heading', true);
			$post_aside = get_post_meta($post_id, $meta_prefix.'aside', true);

			echo "<article id='".$post_name."'>
				<div>";

					if($post_heading != '')
					{
						echo "<h2>".$post_heading."</h2>";
					}

					if($post_aside != '')
					{
						echo "<div id='aside'>"
							.apply_filters('the_content', $post_aside)
						."</div>";
					}

					echo "<section>
						<div>".$post_content."</div>
					</section>
				</div>
			</article>";
		}
	}

get_footer();