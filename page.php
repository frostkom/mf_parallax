<?php

get_header();

	if(have_posts())
	{
		if(!isset($obj_parallax))
		{
			$obj_parallax = new mf_parallax();
		}

		while(have_posts())
		{
			the_post();

			$post_id = $post->ID;
			$post_title = $post->post_title;
			$post_content = apply_filters('the_content', $post->post_content);
			$post_name = $post->post_name;

			$post_display_heading = get_post_meta_or_default($post_id, $obj_parallax->meta_prefix.'display_heading', true, 'yes');

			$post_heading = get_post_meta($post_id, $obj_parallax->meta_prefix.'heading', true);
			$post_aside = get_post_meta($post_id, $obj_parallax->meta_prefix.'aside', true);

			echo "<article id='".$post_name."'>
				<div>";

					if($post_heading != '')
					{
						echo "<h2>".$post_heading."</h2>";
					}

					if($post_aside != '')
					{
						echo "<div class='aside'>"
							.apply_filters('the_content', $post_aside)
						."</div>";
					}

					echo "<section>";

						if($post_title != '' && $post_display_heading == 'yes')
						{
							echo "<h2>".$post_title."</h2>";
						}

						echo "<div>".$post_content."</div>
					</section>
				</div>
			</article>";
		}
	}

get_footer();