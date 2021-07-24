<?php
/**
 * The main template file.
 */

get_header();

	if(!isset($obj_parallax))
	{
		$obj_parallax = new mf_parallax();
	}

	$result = $wpdb->get_results($wpdb->prepare("SELECT ID, post_title, post_content, post_name FROM ".$wpdb->posts." WHERE post_type = %s AND post_status = %s ORDER BY menu_order ASC", 'page', 'publish'));

	foreach($result as $r)
	{
		$post_id = $r->ID;
		$post_title = $r->post_title;
		$post_content = apply_filters('the_content', $r->post_content);
		$post_name = $r->post_name;

		$post_show_on_page = get_post_meta_or_default($post_id, $obj_parallax->meta_prefix.'show_on_page', true, 'yes');

		if($post_show_on_page == 'yes')
		{
			$post_display_heading = get_post_meta_or_default($post_id, $obj_parallax->meta_prefix.'display_heading', true, 'yes');

			//$post_heading = get_post_meta($post_id, $obj_parallax->meta_prefix.'heading', true);
			$post_aside = get_post_meta($post_id, $obj_parallax->meta_prefix.'aside', true);

			echo "<article id='".$post_name."'>
				<div>";

					/*if($post_heading != '')
					{
						echo "<h2>".$post_heading."</h2>";
					}*/

					echo "<section>";

						if($post_title != '' && $post_display_heading == 'yes')
						{
							echo "<h2>".$post_title."</h2>";
						}

						echo "<div>".$post_content."</div>
					</section>";

					if($post_aside != '')
					{
						echo "<div class='aside'>"
							.apply_filters('the_content', $post_aside)
						."</div>";
					}

				echo "</div>
			</article>";
		}
	}

get_footer();