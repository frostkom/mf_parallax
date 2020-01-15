<?php

if(!defined('ABSPATH'))
{
	header("Content-Type: text/css; charset=utf-8");

	$folder = str_replace("/wp-content/themes/mf_parallax/include", "/", dirname(__FILE__));

	require_once($folder."wp-load.php");
}

else
{
	global $wpdb;
}

if(!isset($obj_theme_core))
{
	$obj_theme_core = new mf_theme_core();
}

if(!isset($obj_parallax))
{
	$obj_parallax = new mf_parallax();
}

$obj_theme_core->get_params();

$out = $obj_theme_core->show_font_face();

$style_all = $style_desktop = $style_mobile = "";

$result = $wpdb->get_results("SELECT ID, post_name FROM ".$wpdb->posts." WHERE post_type = 'page' ORDER BY menu_order ASC");

foreach($result as $r)
{
	$post_id = $r->ID;
	$post_name = $r->post_name;

	$css_identifier = "#".$post_name.", .header_".$post_name;

	$background_image = get_post_meta_file_src(array('post_id' => $post_id, 'meta_key' => $obj_parallax->meta_prefix.'background_image'));
	$background_repeat = get_post_meta($post_id, $obj_parallax->meta_prefix.'background_repeat', true);
	$background_image_mobile = get_post_meta_file_src(array('post_id' => $post_id, 'meta_key' => $obj_parallax->meta_prefix.'background_image_mobile'));
	$text_color = get_post_meta($post_id, $obj_parallax->meta_prefix.'text_color', true);
	$bg_color = get_post_meta($post_id, $obj_parallax->meta_prefix.'bg_color', true);

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
{"
	.$obj_theme_core->get_common_style()

	."header > div, #mf-pre-content > div, article > div, footer > div, .full_width > div > .widget .section, .full_width > div > .widget > div
	{"
		.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'main_padding'))
		."position: relative;
	}

	header
	{"
		.$obj_theme_core->render_css(array('property' => 'background', 'value' => 'header_bg'))
		.$obj_theme_core->render_css(array('property' => 'background-color', 'value' => 'header_bg_color'))
		.$obj_theme_core->render_css(array('property' => 'background-image', 'prefix' => 'url(', 'value' => 'header_bg_image', 'suffix' => '); background-size: cover'))
		."background-size: 100%;"
		.$obj_theme_core->render_css(array('property' => 'overflow', 'value' => 'header_overflow'))
		.$obj_theme_core->render_css(array('property' => 'position', 'value' => 'header_fixed'))
		."text-align: center;
	}

		header > div
		{"
			.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'header_padding'))
		."}

			header h1, #site_logo
			{"
				.$obj_theme_core->render_css(array('property' => 'color', 'value' => 'logo_color'))
				."display: block;"
				.$obj_theme_core->render_css(array('property' => 'float', 'value' => 'logo_float'))
				.$obj_theme_core->render_css(array('property' => 'font-family', 'value' => 'logo_font'))
				.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'logo_font_size'))
				.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'logo_padding'))
				.$obj_theme_core->render_css(array('property' => 'max-width', 'value' => 'logo_width'))
			."}

			#primary_nav
			{"
				.$obj_theme_core->render_css(array('property' => 'background', 'value' => 'nav_bg'))
				.$obj_theme_core->render_css(array('property' => 'background-color', 'value' => 'nav_bg_color'))
				.$obj_theme_core->render_css(array('property' => 'background-image', 'prefix' => 'url(', 'value' => 'nav_bg_image', 'suffix' => '); background-size: cover'))
				.$obj_theme_core->render_css(array('property' => 'clear', 'value' => 'nav_clear'))
				.$obj_theme_core->render_css(array('property' => 'color', 'value' => 'nav_color'))
				.$obj_theme_core->render_css(array('property' => 'float', 'value' => 'nav_float'))
				.$obj_theme_core->render_css(array('property' => 'font-family', 'value' => 'nav_font'))
				.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'nav_size'))
				.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'nav_padding'))
				.$obj_theme_core->render_css(array('property' => 'text-align', 'value' => 'nav_align'))
				."position: relative;
			}

				#primary_nav > .toggle_icon
				{
					display: none;
				}

				header #primary_nav > div
				{"
					.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'nav_padding'))
				."}

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
								.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'nav_link_padding'))
							."}

								#primary_nav li.current_page_item > a
								{"
									.$obj_theme_core->render_css(array('property' => 'color', 'value' => 'nav_color_hover'))
								."}

			#slide_nav > .toggle_icon
			{"
				.$obj_theme_core->render_css(array('property' => 'color', 'value' => 'logo_color'))
				."display: block;"
				.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => array('hamburger_font_size', 'logo_font_size')))
				."margin: .1em .2em;"
				.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'hamburger_margin'))
				."position: absolute;";

				switch($obj_theme_core->options['hamburger_position'])
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
			}";

	if(is_active_widget_area('widget_slide'))
	{
		$out .= "#mf-slide-nav
		{
			background: rgba(0, 0, 0, .7);
			bottom: 0;
			display: none;
			left: 0;
			position: absolute;
			position: fixed;
			right: 0;
			top: 0;
			z-index: 1003;
		}

			#mf-slide-nav > div
			{"
				.$obj_theme_core->render_css(array('property' => 'background', 'value' => 'slide_nav_bg'))
				."bottom: 0;"
				.$obj_theme_core->render_css(array('property' => 'color', 'value' => 'slide_nav_color'))
				.$obj_theme_core->render_css(array('property' => 'font-family', 'value' => 'nav_font'))
				."overflow: hidden;
				padding: 2.6em 0 1em;
				position: absolute;";

				switch($obj_theme_core->options['slide_nav_position'])
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

				#mf-slide-nav .fa-times
				{
					font-size: 2em;
					margin: 3% 4% 0 0;
					position: absolute;
					right: 0;
					top: 0;
				}

				#mf-slide-nav ul
				{
					list-style: none;
				}

					#mf-slide-nav li
					{
						width: 100%;
					}

						#mf-slide-nav .theme_nav ul a
						{"
							.$obj_theme_core->render_css(array('property' => 'color', 'value' => 'slide_nav_color'))
							."display: block;
							letter-spacing: .2em;"
							.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'slide_nav_link_padding'))
							."transition: all .4s ease;
						}

							#mf-slide-nav .theme_nav ul a:hover
							{"
								.$obj_theme_core->render_css(array('property' => 'background', 'value' => 'slide_nav_bg_hover'))
								.$obj_theme_core->render_css(array('property' => 'color', 'value' => 'slide_nav_color_hover'))
								."text-indent: .3em;
							}

							#mf-slide-nav .theme_nav li.current_page_item > a
							{"
								.$obj_theme_core->render_css(array('property' => 'background', 'value' => 'slide_nav_bg_hover'))
								.$obj_theme_core->render_css(array('property' => 'color', 'value' => 'slide_nav_color_current'))
							."}

						#mf-slide-nav .theme_nav li ul
						{
							margin-bottom: 0;
						}

							#mf-slide-nav .theme_nav li ul a
							{
								text-indent: 1.4em;
							}

								#mf-slide-nav .theme_nav li ul a:hover
								{
									text-indent: 2em;
								}

				#mf-slide-nav ul, #mf-slide-nav p
				{
					margin-bottom: 1em;
				}";
	}

	if(is_active_widget_area('widget_pre_content'))
	{
		$out .= "#mf-pre-content
		{"
			.$obj_theme_core->render_css(array('property' => 'background', 'value' => 'pre_content_bg'))
			.$obj_theme_core->render_css(array('property' => 'background-color', 'value' => 'pre_content_bg_color'))
			.$obj_theme_core->render_css(array('property' => 'background-image', 'prefix' => 'url(', 'value' => 'pre_content_bg_image', 'suffix' => '); background-size: cover'))
			."overflow: hidden;
		}

			#mf-pre-content > div
			{"
				.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'pre_content_padding'))
			."}

				/*#mf-pre-content h3
				{"
					.$obj_theme_core->render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
					.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h3'))
					.$obj_theme_core->render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h3'))
					.$obj_theme_core->render_css(array('property' => 'margin', 'value' => 'heading_margin_h3'))
				."}*/

				#mf-pre-content p
				{"
					.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'section_size'))
					.$obj_theme_core->render_css(array('property' => 'line-height', 'value' => 'section_line_height'))
				."}

					#mf-pre-content p:not(:last-child)
					{"
						.$obj_theme_core->render_css(array('property' => 'margin', 'value' => 'section_margin'))
					."}";
	}

	$out .= "article
	{
		background: 50% 0 repeat fixed;
		background-size: 100%;";

		if(isset($obj_theme_core->options['content_stretch_height']) && $obj_theme_core->options['content_stretch_height'] == 2)
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
			.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'content_padding'))
			."overflow: hidden;
			position: relative;
		}";

			/*article h1
			{"
				.$obj_theme_core->render_css(array('property' => 'font-family', 'value' => 'heading_font'))
				.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'heading_font_size'))
			."}*/

			$out .= "article h2
			{"
				.$obj_theme_core->render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
				.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h2'))
				.$obj_theme_core->render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h2'))
				.$obj_theme_core->render_css(array('property' => 'margin', 'value' => 'heading_margin_h2'))
			."}

			article h3, #mf-pre-content h3
			{"
				.$obj_theme_core->render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
				.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h3'))
				.$obj_theme_core->render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h3'))
				.$obj_theme_core->render_css(array('property' => 'margin', 'value' => 'heading_margin_h3'))
			."}

			article h4
			{"
				.$obj_theme_core->render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
				.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h4'))
				.$obj_theme_core->render_css(array('property' => 'margin', 'value' => 'heading_margin_h4'))
				.$obj_theme_core->render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h4'))
			."}

			article h5
			{"
				.$obj_theme_core->render_css(array('property' => 'font-family', 'value' => 'heading_font_h2'))
				.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'heading_font_size_h5'))
				.$obj_theme_core->render_css(array('property' => 'margin', 'value' => 'heading_margin_h5'))
				.$obj_theme_core->render_css(array('property' => 'font-weight', 'value' => 'heading_weight_h5'))
			."}

			article .aside p
			{"
				.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'aside_p'))
			."}

			article section
			{"
				.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'section_size'))
				.$obj_theme_core->render_css(array('property' => 'line-height', 'value' => 'section_line_height'))
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
					.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'quote_size'))
					."margin-left: 0;
				}

				article form button
				{"
					.$obj_theme_core->render_css(array('property' => 'background', 'value' => 'nav_color_hover'))
					."color: #fff;
				}";

	if(is_active_widget_area('widget_footer'))
	{
		$out .= "footer
		{"
			.$obj_theme_core->render_css(array('property' => 'background', 'value' => 'footer_bg'))
			.$obj_theme_core->render_css(array('property' => 'background-color', 'value' => 'footer_bg_color'))
			.$obj_theme_core->render_css(array('property' => 'background-image', 'prefix' => 'url(', 'value' => 'footer_bg_image', 'suffix' => '); background-size: cover'))
			.$obj_theme_core->render_css(array('property' => 'margin', 'value' => 'footer_margin'))
			//."position: relative;"
			.$obj_theme_core->render_css(array('property' => 'position', 'value' => 'header_fixed'))
		."}

			footer > div
			{
				overflow: hidden;"
				.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'footer_padding'))
				.$obj_theme_core->render_css(array('property' => 'text-align', 'value' => 'footer_align'))
			."}

				footer .widget
				{"
					.$obj_theme_core->render_css(array('property' => 'color', 'value' => 'footer_color'))
					.$obj_theme_core->render_css(array('property' => 'font-family', 'value' => 'footer_font'))
					.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'footer_font_size'))
					.$obj_theme_core->render_css(array('property' => 'padding', 'value' => 'footer_widget_padding'))
				."}";
	}

	if($obj_theme_core->options['hamburger_fixed'] == 'fixed')
	{
		$out .= "#hamburger_to_top
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

			switch($obj_theme_core->options['hamburger_position'])
			{
				default:
					$out .= "right: .5em;";
				break;

				case 'left':
					$out .= "left: .5em;";
				break;
			}

			$out .= "z-index: 1003;
		}

			#hamburger_to_top:hover
			{
				opacity: .7;
			}";
	}

	$out .= $style_all;

	if(isset($obj_theme_core->options['custom_css_all']) && $obj_theme_core->options['custom_css_all'] != '')
	{
		$out .= $obj_theme_core->options['custom_css_all'];
	}

$out .= "}

@media (min-width: ".$obj_theme_core->options['mobile_breakpoint']."px)
{
	body:before
	{
		content: 'is_tablet'; /* is_size_lap */
	}

	.show_if_mobile
	{
		display: none !important;
	}

	html
	{"
		.$obj_theme_core->render_css(array('property' => 'font-size', 'value' => 'body_desktop_font_size'))
	."}";

		if($obj_theme_core->options['content_main_width'] > 0 && $obj_theme_core->options['content_main_width'] < 100)
		{
			switch($obj_theme_core->options['content_main_position'])
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

			if(!in_array($obj_theme_core->options['content_main_position'], array('none', 'initial', 'inherit')))
			{
				$width_section = $obj_theme_core->options['content_main_width'];
				$width_aside = 100 - 5 - $obj_theme_core->options['content_main_width'];

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

					article .aside
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

@media (max-width: ".$obj_theme_core->options['mobile_breakpoint']."px)
{
	body:before
	{
		content: 'is_mobile'; /* is_size_palm */
	}

	.hide_if_mobile
	{
		display: none !important;
	}

		header h1, #site_logo
		{"
			.$obj_theme_core->render_css(array('property' => 'max-width', 'value' => 'logo_width_mobile'))
		."}

		#primary_nav
		{"
			.$obj_theme_core->render_css(array('property' => 'float', 'value' => 'nav_float_mobile'));

			if($obj_theme_core->options['nav_float_mobile'] == "none")
			{
				$out .= "text-align: center;";
			}

			$out .= $obj_theme_core->render_css(array('property' => 'padding', 'value' => 'nav_padding_mobile'))
		."}";

			if(isset($obj_theme_core->options['nav_mobile']) && $obj_theme_core->options['nav_mobile'] == 2)
			{
				$out .= "#primary_nav > .toggle_icon
				{
					display: block;
					font-size: 2em;
					margin-top: .15em;
				}

					#primary_nav .fa-times
					{
						display: none;
					}

					#primary_nav.is_mobile_ready ul > li
					{
						display: none;
					}";

				if(isset($obj_theme_core->options['nav_click2expand']) && $obj_theme_core->options['nav_click2expand'] == 2)
				{
					$out .= "#primary_nav.open .fa-bars
					{
						display: none;
					}

					#primary_nav.open .fa-times
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
			.$obj_theme_core->render_css(array('property' => 'text-align', 'value' => 'section_heading_alignment_mobile'))
		."}

		.aside p.has_one_image
		{
			text-align: center;
		}

			article .aside
			{
				margin-bottom: 3em;
			}

				aside img, .aside img
				{"
					.$obj_theme_core->render_css(array('property' => 'max-width', 'value' => 'mobile_aside_img_max_width'))
				."}";

	if(isset($obj_theme_core->options['custom_css_mobile']) && $obj_theme_core->options['custom_css_mobile'] != '')
	{
		$out .= $obj_theme_core->options['custom_css_mobile'];
	}

$out .= "}";

if(isset($obj_theme_core->options['website_max_width']) && $obj_theme_core->options['website_max_width'] > 0)
{
	$out .= "@media (min-width: ".$obj_theme_core->options['website_max_width']."px)
	{
		body:before
		{
			content: 'is_desktop'; /* is_size_desk */
		}

			header > div, #mf-pre-content > div, article > div, footer > div, body:not(.is_mobile) nav.full_width > div, .full_width > div > .widget > *
			{
				margin: 0 auto;
				margin-left: auto !important;
				margin-right: auto !important;
				max-width: ".$obj_theme_core->options['website_max_width']."px;
			}
	}";
}

echo $out;