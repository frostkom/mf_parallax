<?php

header("Content-Type: text/css; charset=utf-8");

if(!defined('ABSPATH'))
{
	$folder = str_replace("/wp-content/themes/mf_parallax/include", "/", dirname(__FILE__));

	require_once($folder."wp-load.php");
}

do_action('init_style');

$meta_prefix = "mf_parallax_";

$upload_dir = wp_upload_dir();

$options_fonts = get_theme_fonts();

list($options_params, $options) = get_params();

echo show_font_face($options_params, $options_fonts, $options);

$style_all = $style_desktop = $style_mobile = "";

$result = $wpdb->get_results("SELECT ID, post_name FROM ".$wpdb->posts." WHERE post_type = 'page' ORDER BY menu_order ASC");

foreach($result as $post)
{
	$post_id = $post->ID;
	$post_name = $post->post_name;

	$css_identifier = "#".$post_name.", .header_".$post_name;

	$background_image = get_meta_image_url($post_id, $meta_prefix.'background_image');
	$background_image_mobile = get_meta_image_url($post_id, $meta_prefix.'background_image_mobile');
	$text_color = get_post_meta($post_id, $meta_prefix.'text_color', true);
	$bg_color = get_post_meta($post_id, $meta_prefix.'bg_color', true);

	$style_bg_img_mobile = $style_bg_img = "";

	if($background_image != '')
	{
		$style_bg_img = "background-image: url(".$background_image.");";
	}

	if($background_image_mobile != '')
	{
		$style_bg_img_mobile = "background-image: url(".$background_image_mobile.");";
	}

	$style_all .= $css_identifier
	."{"
		.($text_color != '' ? "color: ".$text_color.";" : "")
		.($bg_color != '' ? "background-color: ".$bg_color.";" : "");

		if($background_image_mobile != '')
		{
			$style_all .= $style_bg_img_mobile;
		}

		else if($background_image != '')
		{
			$style_all .= $style_bg_img;
		}

	$style_all .= "}";

	if($background_image != '')
	{
		$style_desktop .= $css_identifier
		."{"
			.$style_bg_img
		."}";
	}
}

echo "@media all
{
	body:before
	{
		display: none;
	}

	html, body, div, h1, h2, h3, h4, h5, h6, p, ul, li, ol, button, header, nav, mf-pre-content, mf-content, article, section, footer
	{
		margin: 0;
		padding: 0;
	}

	html
	{
		overflow-y: scroll;
	}

	body, textarea
	{"
		.render_css(array('property' => 'color', 'value' => 'body_color'))
	."}

	div, a, p, ul, li, form, input, select, textarea, button, header, nav, mf-pre-content, mf-content, article, section, footer
	{
		box-sizing: border-box;
	}

	a
	{
		color: inherit;
		text-decoration: none;
	}

		p a
		{
			text-decoration: underline;"
			.render_css(array('property' => 'color', 'value' => 'body_link_color'))
		."}

	img
	{
		border: 0;
		max-width: 100%;
	}

	.clear
	{
		clear: both;
	}

	.aligncenter
	{
		margin: .5em 0 .5em 0;
		text-align: center;
	}

	.alignleft
	{
		float: left;
		margin: 0 .5em .5em 0;
	}

	.alignright
	{
		float: right;
		margin: 0 0 .5em .5em;
	}

	html
	{"
		.render_css(array('property' => 'font-size', 'value' => 'body_font_size'))
	."}

	body
	{"
		.render_css(array('property' => 'background', 'value' => 'body_bg'))
		.render_css(array('property' => 'font-family', 'value' => 'body_font'))
	."}

		header
		{"
			.render_css(array('property' => 'background', 'value' => 'header_bg'))
			."background-size: 100%;"
			.render_css(array('property' => 'font-family', 'value' => 'logo_font'))
			.render_css(array('property' => 'padding', 'value' => 'header_padding'))
			."text-align: center;";

			if(isset($options['header_fixed']) && $options['header_fixed'] == 2)
			{
				echo "left: 0;
				position: fixed;
				right: 0;
				z-index: 10;";
			}

		echo "}

			header h1, #site_logo
			{"
				.render_css(array('property' => 'color', 'value' => 'logo_color'))
				."float: left;"
				.render_css(array('property' => 'font-family', 'value' => 'logo_font'))
				.render_css(array('property' => 'font-size', 'value' => 'logo_font_size'))
				.render_css(array('property' => 'padding', 'value' => 'logo_padding'))
			."}

			header nav
			{"
				.render_css(array('property' => 'color', 'value' => 'nav_color'))
				.render_css(array('property' => 'float', 'value' => 'nav_float'))
				.render_css(array('property' => 'font-size', 'value' => 'nav_size'))
				.render_css(array('property' => 'padding', 'value' => 'nav_padding'))
				."position: relative;
			}

				header nav > .toggle_icon
				{
					display: none;
				}

				header nav ul
				{
					list-style: none;
				}

					header nav li
					{
						display: inline-block;
					}

						header nav li > a
						{
							color: inherit;
							display: block;"
							.render_css(array('property' => 'padding', 'value' => 'nav_link_padding'))
						."}

							header nav li.current_page_item > a
							{"
								.render_css(array('property' => 'color', 'value' => 'nav_color_hover'))
							."}

		article
		{ 
			background: 50% 0 repeat fixed;
			background-size: 100%;";

			if(isset($options['content_stretch_height']) && $options['content_stretch_height'] == 2)
			{
				echo "min-height: 100vh;";
			}

			echo "overflow: hidden;
			position: relative;
			width: 100%;
		}

			article > div
			{
				margin: 0 auto;"
				.render_css(array('property' => 'padding', 'value' => 'content_padding'))
				."overflow: hidden;
				position: relative;
			}";

				/*article h1
				{"
					.render_css(array('property' => 'font-family', 'value' => 'heading_font'))
					.render_css(array('property' => 'font-size', 'value' => 'heading_font_size'))
				."}*/

				echo "article h2
				{"
					.render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
					.render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h2'))
					.render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h2'))
					.render_css(array('property' => 'margin', 'value' => 'heading_margin_h2'))
				."}

				article h3
				{"
					.render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
					.render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h3'))
					.render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h3'))
					.render_css(array('property' => 'margin', 'value' => 'heading_margin_h3'))
				."}

				article h4
				{"
					.render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
					.render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h4'))
					.render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h4'))
				."}

				article h5
				{"
					.render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
					.render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h5'))
					.render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h5'))
				."}

				article aside, article #aside{}

					article aside p, article #aside p
					{"
						.render_css(array('property' => 'font-size', 'value' => 'aside_p'))
					."}

				article section
				{"
					.render_css(array('property' => 'font-size', 'value' => 'section_size'))
				."}

					article a
					{
						color: inherit;
					}

						article a:hover
						{
							text-decoration: underline;
						}

					article p, article ol, article ul
					{
						list-style-position: inside;
						margin-bottom: .5em;
					}

					section blockquote
					{"
						.render_css(array('property' => 'font-size', 'value' => 'quote_size'))
						."margin-left: 0;
					}

					article form button
					{"
						.render_css(array('property' => 'background', 'value' => 'nav_color_hover'))
						."color: #fff;
					}

		footer
		{"
			.render_css(array('property' => 'background', 'value' => 'footer_bg'))
			.render_css(array('property' => 'color', 'value' => 'footer_color'))
			.render_css(array('property' => 'font-family', 'value' => 'footer_font'))
			.render_css(array('property' => 'font-size', 'value' => 'footer_font_size'))
			.render_css(array('property' => 'margin', 'value' => 'footer_margin'))
			.render_css(array('property' => 'padding', 'value' => 'footer_padding'))
			."position: relative;
		}

			footer .widget
			{"
				.render_css(array('property' => 'padding', 'value' => 'footer_widget_padding'))
			."}"
	.$style_all;

	if(isset($options['custom_css_all']) && $options['custom_css_all'] != '')
	{
		echo $options['custom_css_all'];
	}

echo "}

@media (min-width: ".$options['mobile_breakpoint']."px)
{
	body:before
	{
		content: 'desktop';
	}

	.show_if_mobile
	{
		display: none;
	}

	html
	{"
		.render_css(array('property' => 'font-size', 'value' => 'body_desktop_font_size'))
	."}";

		if($options['website_max_width'] > 0)
		{
			echo "header > div, mf-pre-content > div, article > div, footer > div
			{
				margin: 0 auto;
				max-width: ".$options['website_max_width']."px;
			}";
		}

		if($options['content_main_width'] > 0 && $options['content_main_width'] < 100)
		{
			echo "article > div > h2, section
			{
				float: right;
				width: ".$options['content_main_width']."%;
			}

			article aside, article #aside
			{
				float: left;
				width: ".(100 - 5 - $options['content_main_width'])."%;
			}";
		}

	echo $style_desktop
."}

@media (max-width: ".$options['mobile_breakpoint']."px)
{
	body:before
	{
		content: 'mobile';
	}

	.hide_if_mobile
	{
		display: none;
	}

		header
		{"
			.render_css(array('property' => 'padding', 'value' => 'header_padding_mobile'))
		."}

			header nav
			{"
				.render_css(array('property' => 'float', 'value' => 'nav_float_mobile'));

				if($options['nav_float_mobile'] == "none")
				{
					echo "text-align: center;";
				}

				echo render_css(array('property' => 'padding', 'value' => 'nav_padding_mobile'))
			."}";

				if(isset($options['nav_mobile']) && $options['nav_mobile'] == 2)
				{
					echo "header nav > .toggle_icon
					{
						cursor: pointer;
						display: block;
						font-size: 2em;
						margin-top: .15em;
					}

						header nav .fa-close
						{
							display: none;
						}

						header nav.is_mobile_ready ul > li
						{
							display: none;
						}";

					if(isset($options['nav_click2expand']) && $options['nav_click2expand'] == 2)
					{
						echo "header nav.open .fa-bars
						{
							display: none;
						}

						header nav.open .fa-close
						{
							display: block;
						}

						header nav.open ul > li
						{
							display: block;
						}";
					}

					else
					{
						echo "header nav > .toggle_icon
						{
							display: none;
						}

							header nav ul > li.current_page_item, header nav ul > li.current_page_parent, header nav ul:hover > li
							{
								display: inline-block;
							}";
					}
				}

	echo "article > div
	{"
		.render_css(array('property' => 'padding', 'value' => 'content_padding_mobile'))
	."}

	article h2, aside p.has_one_image, #aside p.has_one_image
	{
		text-align: center;
	}

		aside img, #aside img
		{"
			.render_css(array('property' => 'max-width', 'value' => 'mobile_aside_img_max_width'))
		."}

	footer
	{"
		.render_css(array('property' => 'padding', 'value' => 'footer_padding_mobile'))
	."}";

	if(isset($options['custom_css_mobile']) && $options['custom_css_mobile'] != '')
	{
		echo $options['custom_css_mobile'];
	}

echo "}

@media print
{
	body:before
	{
		content: 'print';
	}

	body, article
	{
		background: none;
	}

	header, aside, #aside, footer
	{
		display: none;
	}

	header, article > div, footer
	{
		padding: 0;
	}

	article
	{
		min-height: auto;
	}
}";