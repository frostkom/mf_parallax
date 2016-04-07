<?php
/**
 * @package WordPress
 * @subpackage MF Parallax
 */

get_header();

	if(have_posts())
	{
		while(have_posts())
		{
			the_post();

			$post_id = $post->ID;
			//$post_title = $post->post_title;
			$post_content = apply_filters('the_content', $post->post_content);
			$post_name = $post->post_name;

			$post_heading = get_post_meta($post_id, 'mf_parallax_heading', true);
			$post_aside = get_post_meta($post_id, 'mf_parallax_aside', true);

			echo "<article id='".$post_name."'>
				<div>";

					if($post_heading != '')
					{
						echo "<h2>".$post_heading."</h2>";
					}

					if($post_aside != '')
					{
						echo "<aside>"
							.apply_filters('the_content', $post_aside)
						."</aside>";
					}

					echo "<section>";

						/*if($post_title != '')
						{
							echo "<h2>".$post_title."</h2>";
						}*/

						echo "<div>".$post_content."</div>
					</section>
				</div>
			</article>";
		}
	}

get_footer();