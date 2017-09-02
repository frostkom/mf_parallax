<?php

header("Content-Type: text/css; charset=utf-8");

if(!defined('ABSPATH'))
{
	$folder = str_replace("/wp-content/themes/mf_parallax/include", "/", dirname(__FILE__));

	require_once($folder."wp-load.php");
}

//do_action('init_style');

$meta_prefix = "mf_parallax_";

//$upload_dir = wp_upload_dir();

$options_fonts = get_theme_fonts();

list($options_params, $options) = get_params();

$out = show_font_face($options_params, $options_fonts, $options);

$style_all = $style_desktop = $style_mobile = "";

$result = $wpdb->get_results("SELECT ID, post_name FROM ".$wpdb->posts." WHERE post_type = 'page' ORDER BY menu_order ASC");

foreach($result as $post)
{
	$post_id = $post->ID;
	$post_name = $post->post_name;

	$css_identifier = "#".$post_name.", .header_".$post_name;

	$background_image = get_post_meta_file_src(array('post_id' => $post_id, 'meta_key' => $meta_prefix.'background_image'));
	$background_repeat = get_post_meta($post_id, $meta_prefix.'background_repeat', true);
	$background_image_mobile = get_post_meta_file_src(array('post_id' => $post_id, 'meta_key' => $meta_prefix.'background_image_mobile'));
	$text_color = get_post_meta($post_id, $meta_prefix.'text_color', true);
	$bg_color = get_post_meta($post_id, $meta_prefix.'bg_color', true);

	$style_bg_img_mobile = $style_bg_img = "";

	if($background_image != '')
	{
		$style_bg_img .= "background-image: url(".$background_image.");";
	}

	if($background_repeat != '')
	{
		$style_bg_img .= "background-repeat: ".$background_repeat.";";
	}

	if($background_image_mobile != '')
	{
		$style_bg_img_mobile .= "background-image: url(".$background_image_mobile.");";
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

$out .= "@media all
{
	body, textarea
	{"
		.render_css(array('property' => 'color', 'value' => 'body_color'))
	."}

	p a
	{"
		.render_css(array('property' => 'color', 'value' => 'body_link_color'))
	."}

	#wrapper .mf_form button, #wrapper .button
	{"
		.render_css(array('property' => 'background', 'value' => array('button_color', 'nav_color_hover')))
		."color: #fff;"
	."}

		#wrapper .mf_form button:hover, #wrapper .button:hover
		{"
			.render_css(array('property' => 'background', 'value' => 'button_color_hover'))
		."}

		#wrapper button.button-secondary
		{
			background: #999;
		}

			#wrapper button.button-secondary:hover
			{
				background: #aaa;
			}

	html
	{
		font-size: .625em;"
		.render_css(array('property' => 'font-size', 'value' => 'body_font_size'))
		."overflow-y: scroll;
	}

	body
	{"
		.render_css(array('property' => 'background', 'value' => 'footer_bg', 'append' => "min-height: 100vh;"))
		.render_css(array('property' => 'font-family', 'value' => 'body_font'))
	."}

		#wrapper
		{"
			.render_css(array('property' => 'background', 'value' => 'body_bg'))
		."}

			header > div, #mf-pre-content > div, article > div, footer > div, .full_width .widget .section, .full_width .widget > div
			{"
				.render_css(array('property' => 'padding', 'value' => 'main_padding'))
				."position: relative;
			}

			.full_width .widget
			{
				left: 50%;
				margin-left: -50vw;
				margin-right: -50vw;
				position: relative;
				right: 50%;
				width: 100vw;
				max-width: none;
			}

			header
			{"
				.render_css(array('property' => 'background', 'value' => 'header_bg'))
				."background-size: 100%;"
				."text-align: center;";

				if(isset($options['header_fixed']) && in_array($options['header_fixed'], array(2, 'absolute', 'fixed')))
				{
					$out .= "left: 0;";

					if($options['header_fixed'] == 2)
					{
						$out .= "position: fixed;";
					}

					else
					{
						$out .= render_css(array('property' => 'position', 'value' => 'header_fixed'));
					}

					$out .= "right: 0;
					z-index: 10;";
				}

			$out .= "}

				header > div
				{"
					//.render_css(array('property' => 'font-family', 'value' => 'logo_font'))
					.render_css(array('property' => 'padding', 'value' => 'header_padding'))
				."}

					header h1, #site_logo
					{"
						.render_css(array('property' => 'color', 'value' => 'logo_color'))
						."display: block;"
						.render_css(array('property' => 'float', 'value' => 'logo_float'))
						.render_css(array('property' => 'font-family', 'value' => 'logo_font'))
						.render_css(array('property' => 'font-size', 'value' => 'logo_font_size'))
						.render_css(array('property' => 'padding', 'value' => 'logo_padding'))
						.render_css(array('property' => 'max-width', 'value' => 'logo_width'))
					."}

					#primary_nav
					{"
						.render_css(array('property' => 'color', 'value' => 'nav_color'))
						.render_css(array('property' => 'float', 'value' => 'nav_float'))
						.render_css(array('property' => 'font-size', 'value' => 'nav_size'))
						.render_css(array('property' => 'padding', 'value' => 'nav_padding'))
						."position: relative;
					}

						#primary_nav > .toggle_icon
						{
							display: none;
						}

						#primary_nav ul
						{
							list-style: none;
						}

							#primary_nav li
							{
								display: inline-block;
							}

								#primary_nav li > a
								{
									color: inherit;
									display: block;"
									.render_css(array('property' => 'padding', 'value' => 'nav_link_padding'))
								."}

									#primary_nav li.current_page_item > a
									{"
										.render_css(array('property' => 'color', 'value' => 'nav_color_hover'))
									."}

					#slide_nav > .toggle_icon
					{"
						.render_css(array('property' => 'color', 'value' => 'logo_color'))
						."display: block;"
						.render_css(array('property' => 'font-size', 'value' => array('hamburger_font_size', 'logo_font_size')))
						."margin: .1em .2em;"
						.render_css(array('property' => 'padding', 'value' => 'hamburger_margin'))
						."position: absolute;";

						switch($options['hamburger_position'])
						{
							default:
								$out .= "right: 0;";
							break;

							case 'left':
								$out .= "left: 0;";
							break;
						}

						$out .= "top: 0;
						z-index: 1;
					}

			#mf-pre-content
			{"
				.render_css(array('property' => 'background', 'value' => 'pre_content_bg'))
				."overflow: hidden;
			}

				#mf-pre-content > div
				{"
					.render_css(array('property' => 'padding', 'value' => 'pre_content_padding'))
				."}

					#mf-pre-content h3
					{"
						.render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
						.render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h3'))
						.render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h3'))
						.render_css(array('property' => 'margin', 'value' => 'heading_margin_h3'))
					."}

					#mf-pre-content p
					{"
						.render_css(array('property' => 'font-size', 'value' => 'section_size'))
						.render_css(array('property' => 'line-height', 'value' => 'section_line_height'))
						.render_css(array('property' => 'margin', 'value' => 'section_margin'))
					."}

			mf-slide-nav
			{
				background: rgba(0, 0, 0, .3);
				bottom: 0;
				display: none;
				left: 0;
				position: absolute;
				position: fixed;
				right: 0;
				top: 0;
				z-index: 1001;
			}

				mf-slide-nav > div
				{"
					.render_css(array('property' => 'background', 'value' => 'slide_nav_bg'))
					."bottom: 0;"
					.render_css(array('property' => 'color', 'value' => 'slide_nav_color'))
					.render_css(array('property' => 'font-family', 'value' => 'nav_font'))
					//.render_css(array('property' => 'font-size', 'value' => 'nav_size'))
					."overflow: hidden;
					padding: 2.6em 0 1em;
					position: absolute;";

					switch($options['slide_nav_position'])
					{
						default:
							$out .= "right: -90%;";
						break;

						case 'left':
							$out .= "left: 0;";
						break;
					}

					$out .= "top: 0;
					width: 90%;
					max-width: 300px;
				}

					mf-slide-nav .fa-close
					{
						font-size: 2em;
						margin: 3% 4% 0 0;
						position: absolute;
						right: 0;
						top: 0;
					}

					mf-slide-nav ul
					{
						list-style: none;
					}

						mf-slide-nav li
						{
							width: 100%;
						}

							mf-slide-nav .theme_nav ul a
							{"
								.render_css(array('property' => 'color', 'value' => 'slide_nav_color'))
								."display: block;
								letter-spacing: .2em;"
								.render_css(array('property' => 'padding', 'value' => 'slide_nav_link_padding'))
								."transition: all .4s ease;
							}

								mf-slide-nav .theme_nav ul a:hover
								{"
									.render_css(array('property' => 'background', 'value' => 'slide_nav_bg_hover'))
									.render_css(array('property' => 'color', 'value' => 'slide_nav_color_hover'))
									."text-indent: .3em;
								}

								mf-slide-nav .theme_nav li.current_page_item > a
								{"
									.render_css(array('property' => 'background', 'value' => 'slide_nav_bg_hover'))
									.render_css(array('property' => 'color', 'value' => 'slide_nav_color_current'))
								."}

							mf-slide-nav .theme_nav li ul
							{
								margin-bottom: 0;
							}

								mf-slide-nav .theme_nav li ul a
								{
									text-indent: 1.4em;
								}

									mf-slide-nav .theme_nav li ul a:hover
									{
										text-indent: 2em;
									}

					mf-slide-nav ul, mf-slide-nav p
					{
						margin-bottom: 1em;
					}

			article
			{
				background: 50% 0 repeat fixed;
				background-size: 100%;";

				if(isset($options['content_stretch_height']) && $options['content_stretch_height'] == 2)
				{
					$out .= "min-height: 100vh;";
				}

				$out .= "overflow: hidden;
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

					$out .= "article h2
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
						.render_css(array('property' => 'margin', 'value' => 'heading_margin_h3'))
						.render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h3'))
					."}

					article h4
					{"
						.render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
						.render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h4'))
						.render_css(array('property' => 'margin', 'value' => 'heading_margin_h4'))
						.render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h4'))
					."}

					article h5
					{"
						.render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
						.render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h5'))
						.render_css(array('property' => 'margin', 'value' => 'heading_margin_h5'))
						.render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h5'))
					."}

					article #aside p
					{"
						.render_css(array('property' => 'font-size', 'value' => 'aside_p'))
					."}

					article section
					{"
						.render_css(array('property' => 'font-size', 'value' => 'section_size'))
						.render_css(array('property' => 'line-height', 'value' => 'section_line_height'))
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

						article blockquote
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
				.render_css(array('property' => 'margin', 'value' => 'footer_margin'))
				."position: relative;
			}

				footer > div
				{
					overflow: hidden;"
					.render_css(array('property' => 'padding', 'value' => 'footer_padding'))
					.render_css(array('property' => 'text-align', 'value' => 'footer_align'))
				."}

					footer .widget
					{"
						.render_css(array('property' => 'color', 'value' => 'footer_color'))
						.render_css(array('property' => 'font-family', 'value' => 'footer_font'))
						.render_css(array('property' => 'font-size', 'value' => 'footer_font_size'))
						.render_css(array('property' => 'padding', 'value' => 'footer_widget_padding'))
					."}

	#hamburger_to_top
	{
		background: #000;
		border-radius: .5em;
		top: .5em;
		color: #fff;
		display: none;
		font-size: 1.3em;
		opacity: .2;
		padding: 1em 1.2em;
		position: fixed;";

		switch($options['hamburger_position'])
		{
			default:
				$out .= "right: .5em;";
			break;

			case 'left':
				$out .= "left: .5em;";
			break;
		}

		$out .= "z-index: 1001;
	}

		#hamburger_to_top:hover
		{
			opacity: .7;
		}"
	.$style_all;

	if(isset($options['custom_css_all']) && $options['custom_css_all'] != '')
	{
		$out .= $options['custom_css_all'];
	}

$out .= "}

@media (min-width: ".$options['mobile_breakpoint']."px)
{
	body:before
	{
		content: 'is_tablet';
	}

	.show_if_mobile
	{
		display: none;
	}

	html
	{"
		.render_css(array('property' => 'font-size', 'value' => 'body_desktop_font_size'))
	."}";

		if($options['content_main_width'] > 0 && $options['content_main_width'] < 100)
		{
			switch($options['content_main_position'])
			{
				default:
				case 'right':
					$pos_section = 'right';
					$pos_aside = 'left';

					$order_section = 2;
					$order_aside = 1;

					$margin_aside = "0 2.5% 0 0";
					$padding_aside = "0 2.5% 0 0";
				break;

				case 'left':
					$pos_section = 'left';
					$pos_aside = 'right';

					$order_section = 1;
					$order_aside = 2;

					$margin_aside = "0 0 0 2.5%";
					$padding_aside = "0 0 0 2.5%";
				break;
			}

			if(!in_array($options['content_main_position'], array('none', 'initial', 'inherit')))
			{
				$width_section = $options['content_main_width'];
				$width_aside = 100 - 5 - $options['content_main_width'];

				$out .= "article > div
				{
					display: -webkit-box;
					display: -ms-flexbox;
					display: -webkit-flex;
					display: flex;
				}

					article section
					{
						-webkit-box-flex: 1 1 ".$width_section."%;
						-webkit-flex: 1 1 ".$width_section."%;
						-ms-flex: 1 1 ".$width_section."%;
						flex: 1 1 ".$width_section."%;
						-webkit-box-ordinal-group: ".$order_section.";
						-webkit-order: ".$order_section.";
						-ms-flex-order: ".$order_section.";
						order: ".$order_section.";
						float: ".$pos_section.";
						min-width: ".$width_section."%;
					}

					article #aside
					{
						-webkit-box-flex: 1 1 ".$width_aside."%;
						-webkit-flex: 1 1 ".$width_aside."%;
						-ms-flex: 1 1 ".$width_aside."%;
						flex: 1 1 ".$width_aside."%;
						-webkit-box-ordinal-group: ".$order_aside.";
						-webkit-order: ".$order_aside.";
						-ms-flex-order: ".$order_aside.";
						order: ".$order_aside.";
						float: ".$pos_aside.";
						margin: ".$margin_aside.";
						padding: ".$padding_aside.";
						min-width: ".$width_aside."%;
					}";
			}
		}

	$out .= $style_desktop
."}

@media (max-width: ".$options['mobile_breakpoint']."px)
{
	body:before
	{
		content: 'is_mobile';
	}

	.hide_if_mobile
	{
		display: none;
	}

		header h1, #site_logo
		{"
			.render_css(array('property' => 'max-width', 'value' => 'logo_width_mobile'))
		."}

		#primary_nav
		{"
			.render_css(array('property' => 'float', 'value' => 'nav_float_mobile'));

			if($options['nav_float_mobile'] == "none")
			{
				$out .= "text-align: center;";
			}

			$out .= render_css(array('property' => 'padding', 'value' => 'nav_padding_mobile'))
		."}";

			if(isset($options['nav_mobile']) && $options['nav_mobile'] == 2)
			{
				$out .= "#primary_nav > .toggle_icon
				{
					display: block;
					font-size: 2em;
					margin-top: .15em;
				}

					#primary_nav .fa-close
					{
						display: none;
					}

					#primary_nav.is_mobile_ready ul > li
					{
						display: none;
					}";

				if(isset($options['nav_click2expand']) && $options['nav_click2expand'] == 2)
				{
					$out .= "#primary_nav.open .fa-bars
					{
						display: none;
					}

					#primary_nav.open .fa-close
					{
						display: block;
					}

					#primary_nav.open ul > li
					{
						display: block;
					}";
				}

				else
				{
					$out .= "#primary_nav > .toggle_icon
					{
						display: none;
					}

						#primary_nav ul > li.current_page_item, #primary_nav ul > li.current_page_parent, #primary_nav ul:hover > li
						{
							display: inline-block;
						}";
				}
			}

	$out .= "article > div
	{
		display: block;
	}

		article h2
		{"
			.render_css(array('property' => 'text-align', 'value' => 'section_heading_alignment_mobile'))
		."}

		#aside p.has_one_image
		{
			text-align: center;
		}

			article #aside
			{
				margin-bottom: 3em;
			}

				aside img, #aside img
				{"
					.render_css(array('property' => 'max-width', 'value' => 'mobile_aside_img_max_width'))
				."}";

	if(isset($options['custom_css_mobile']) && $options['custom_css_mobile'] != '')
	{
		$out .= $options['custom_css_mobile'];
	}

$out .= "}";

if(isset($options['website_max_width']) && $options['website_max_width'] > 0)
{
	$out .= "@media (min-width: ".$options['website_max_width']."px)
	{
		body:before
		{
			content: 'is_desktop';
		}

			header > div, #mf-pre-content > div, article > div, footer > div, .full_width .widget .section, .full_width .widget > div
			{
				margin: 0 auto;
				max-width: ".$options['website_max_width']."px;
			}
	}";
}

$out .= "@media print
{
	body:before
	{
		content: 'is_print';
	}

	body, article
	{
		background: none;
	}

	header, #aside, footer
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

echo $out;