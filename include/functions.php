<?php

if(!function_exists('head_parallax'))
{
	function head_parallax()
	{
		enqueue_theme_fonts();

		$template_url = get_bloginfo('template_url');

		mf_enqueue_style('style', $template_url."/include/style.php", get_plugin_version(__FILE__));

		list($options_params, $options) = get_params();

		mf_enqueue_script('script_nav', $template_url."/include/jquery.nav.js", get_plugin_version(__FILE__));
		mf_enqueue_script('script_parallax', $template_url."/include/script.js", array('override_bg' => isset($options['header_override_bg_with_page_bg']) && $options['header_override_bg_with_page_bg'] == 2), get_plugin_version(__FILE__));
	}
}

if(!function_exists('setup_parallax'))
{
	function setup_parallax()
	{
		load_theme_textdomain('lang_parallax', get_template_directory()."/lang");

		register_nav_menus(array(
			'primary' => __("Primary Navigation", 'lang_parallax')
		));
	}
}

if(!function_exists('options_parallax'))
{
	function options_parallax()
	{
		add_theme_page(__("Theme Options", 'lang_parallax'), __("Theme Options", 'lang_parallax'), 'edit_theme_options', 'theme_options', 'options_page_parallax');
	}
}

if(!function_exists('options_page_parallax'))
{
	function options_page_parallax()
	{
		echo get_options_page_theme_core(array('dir' => "mf_parallax"));
	}
}

if(!function_exists('get_params'))
{
	function get_params()
	{
		$options_params = array();

		$arr_sidebars = wp_get_sidebars_widgets();

		$bg_placeholder = "#ffffff, rgba(0, 0, 0, .3), url(background.png)";

		$options_params[] = array('category' => __("Generic", 'lang_parallax'), 'id' => "mf_parallax_body");
			$options_params[] = array('type' => "text", 'id' => "body_bg", 'title' => __("Background", 'lang_parallax'), 'default' => "#fff", 'placeholder' => $bg_placeholder);
				$options_params[] = array('type' => "text", 'id' => 'main_padding', 'title' => __("Padding", 'lang_parallax'), 'default' => "1em 2em");
				$options_params[] = array('type' => "font", 'id' => "body_font", 'title' => __("Font", 'lang_parallax'));
				$options_params[] = array('type' => "color", 'id' => "body_color", 'title' => __("Text Color", 'lang_parallax'));
				$options_params[] = array('type' => "color", 'id' => "body_link_color", 'title' => __("Link Color", 'lang_parallax'));
				$options_params[] = array('type' => "color", 'id' => 'button_color', 'title' => __("Button Color", 'lang_parallax'));
					$options_params[] = array('type' => "color", 'id' => 'button_color_hover', 'title' => " - ".__("Button Color", 'lang_parallax')." (".__("Hover", 'lang_theme').")", 'show_if' => 'button_color');
				$options_params[] = array('type' => "number", 'id' => "website_max_width", 'title' => __("Max Width", 'lang_parallax'), 'default' => "1100");
				$options_params[] = array('type' => "text", 'id' => "body_desktop_font_size", 'title' => __("Font Size", 'lang_parallax'), 'default' => ".625em", 'show_if' => "body_font_size");
				$options_params[] = array('type' => "number", 'id' => "mobile_breakpoint", 'title' => __("Breakpoint", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'default' => "600");
				$options_params[] = array('type' => "text", 'id' => "body_font_size", 'title' => __("Font Size", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'default' => "1.2vw", 'show_if' => 'mobile_breakpoint');
					$options_params[] = array('type' => "text", 'id' => "mobile_aside_img_max_width", 'title' => __("Aside Image Max Width", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => "mobile_breakpoint");
		$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Header", 'lang_parallax'), 'id' => "mf_parallax_header");
				$options_params[] = array('type' => "position", 'id' => "header_fixed", 'title' => __("Position", 'lang_parallax'), 'default' => 'fixed');
				$options_params[] = array('type' => "text",	'id' => "header_bg", 'title' => __("Background", 'lang_parallax'), 'placeholder' => $bg_placeholder);
				$options_params[] = array('type' => "checkbox", 'id' => "header_override_bg_with_page_bg", 'title' => __("Override background with page background", 'lang_parallax'), 'default' => 2);
				$options_params[] = array('type' => "text",	'id' => "header_padding", 'title' => __("Padding", 'lang_parallax'));
					//$options_params[] = array('type' => "text",	'id' => "header_padding_mobile", 'title' => __("Padding", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => 'mobile_breakpoint');
			$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Logo", 'lang_parallax'), 'id' => 'mf_parallax_logo');
				$options_params[] = array('type' => "image", 'id' => "header_logo", 'title' => __("Image", 'lang_parallax'));
					$options_params[] = array('type' => "float", 'id' => 'logo_float', 'title' => __("Position", 'lang_parallax'), 'default' => 'left', 'show_if' => 'header_logo');
					$options_params[] = array('type' => "text", 'id' => 'logo_width', 'title' => __("Width", 'lang_parallax'), 'show_if' => 'header_logo');
				$options_params[] = array('type' => "image", 'id' => "header_mobile_logo", 'title' => __("Image", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => 'header_logo');
					$options_params[] = array('type' => "text", 'id' => 'logo_width_mobile', 'title' => __("Width", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")");
				$options_params[] = array('type' => "text",	'id' => "logo_padding", 'title' => __("Padding", 'lang_parallax'), 'default' => "1.5em 1em");
				$options_params[] = array('type' => "font",	'id' => "logo_font", 'title' => __("Font", 'lang_parallax'), 'hide_if' => 'header_logo');
				$options_params[] = array('type' => "text", 'id' => "logo_font_size", 'title' => __("Font Size", 'lang_parallax'), 'default' => "3em", 'hide_if' => 'header_logo');
				$options_params[] = array('type' => "color", 'id' => "logo_color", 'title' => __("Text Color", 'lang_parallax'), 'hide_if' => 'header_logo');
			$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Navigation", 'lang_parallax'), 'id' => "mf_parallax_navigation");
				$options_params[] = array('type' => "checkbox", 'id' => "nav_mobile", 'title' => __("Compressed on mobile", 'lang_parallax'), 'default' => 2);
					$options_params[] = array('type' => "checkbox", 'id' => "nav_click2expand", 'title' => __("Click to expand", 'lang_parallax'), 'default' => 1);
				$options_params[] = array('type' => "text", 'id' => "nav_padding", 'title' => __("Padding", 'lang_parallax'), 'default' => "0 1em");
				$options_params[] = array('type' => "text", 'id' => "nav_padding_mobile", 'title' => __("Padding", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => 'nav_padding');
				$options_params[] = array('type' => "float", 'id' => "nav_float", 'title' => __("Float", 'lang_parallax'), 'default' => "right");
				$options_params[] = array('type' => "float", 'id' => "nav_float_mobile", 'title' => __("Float", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'default' => "none", 'show_if' => 'nav_float');
				$options_params[] = array('type' => "text", 'id' => "nav_size", 'title' => __("Font Size", 'lang_parallax'), 'default' => "2em");
				$options_params[] = array('type' => "color", 'id' => "nav_color", 'title' => __("Text Color", 'lang_parallax'));
					$options_params[] = array('type' => "color", 'id' => "nav_color_hover", 'title' => __("Text Color", 'lang_parallax')." (".__("Hover", 'lang_parallax').")", 'show_if' => 'nav_color');
				$options_params[] = array('type' => "text", 'id' => "nav_link_padding", 'title' => __("Link Padding", 'lang_parallax'), 'default' => "1em");
			$options_params[] = array('category_end' => "");

			if(isset($arr_sidebars['widget_slide']) && count($arr_sidebars['widget_slide']) > 0)
			{
				$options_params[] = array('category' => " - ".__("Mobile Menu", 'lang_parallax'), 'id' => 'mf_theme_navigation_hamburger');
					$options_params[] = array('type' => "text", 'id' => 'hamburger_font_size', 'title' => __("Size", 'lang_parallax'), 'default' => "2.5em");
					$options_params[] = array('type' => "text", 'id' => 'hamburger_margin', 'title' => __("Margin", 'lang_parallax'), 'default' => "1em .8em");
				$options_params[] = array('category_end' => "");

				$options_params[] = array('category' => " - ".__("Slide Menu", 'lang_parallax'), 'id' => 'mf_theme_navigation_slide');
					$options_params[] = array('type' => "text", 'id' => 'slide_nav_link_padding', 'title' => __("Link Padding", 'lang_parallax'), 'default' => "1.5em 1em 1em");
					$options_params[] = array('type' => "color", 'id' => 'slide_nav_bg', 'title' => __("Background", 'lang_parallax'), 'default' => "#fff");
					$options_params[] = array('type' => "color", 'id' => 'slide_nav_bg_hover', 'title' => " - ".__("Background", 'lang_parallax')." (".__("Hover", 'lang_parallax').")", 'show_if' => 'slide_nav_bg');
					$options_params[] = array('type' => "color", 'id' => 'slide_nav_color', 'title' => __("Text Color", 'lang_parallax'));
					$options_params[] = array('type' => "color", 'id' => 'slide_nav_color_hover', 'title' => " - ".__("Text Color", 'lang_parallax')." (".__("Hover", 'lang_parallax').")", 'show_if' => 'slide_nav_color');
					$options_params[] = array('type' => "color", 'id' => 'slide_nav_color_current', 'title' => __("Text Color", 'lang_parallax')." (".__("Current", 'lang_parallax').")");
				$options_params[] = array('category_end' => "");
			}

			if(isset($arr_sidebars['widget_pre_content']) && count($arr_sidebars['widget_pre_content']) > 0)
			{
				$options_params[] = array('category' => __("Pre Content", 'lang_parallax'), 'id' => 'mf_parallax_pre_content');
					$options_params[] = array('type' => "checkbox", 'id' => 'pre_content_full_width', 'title' => __("Full Width", 'lang_parallax'), 'default' => 1);
					$options_params[] = array('type' => "text", 'id' => 'pre_content_bg', 'title' => __("Background", 'lang_parallax'), 'placeholder' => $bg_placeholder);
					$options_params[] = array('type' => "text", 'id' => 'pre_content_padding', 'title' => __("Padding", 'lang_parallax'));
					//$options_params[] = array('type' => "text", 'id' => "pre_content_size", 'title' => __("Font Size", 'lang_parallax'));
				$options_params[] = array('category_end' => "");
			}

			$options_params[] = array('category' => __("Content", 'lang_parallax'), 'id' => "mf_parallax_content");
				$options_params[] = array('type' => "checkbox", 'id' => "content_stretch_height", 'title' => __("Match Height with Screen Size", 'lang_parallax'), 'default' => 2);
				$options_params[] = array('type' => "float", 'id' => "content_main_position", 'title' => __("Main Column Position", 'lang_parallax'), 'default' => "right");
				$options_params[] = array('type' => "number", 'id' => "content_main_width", 'title' => __("Main Column Width", 'lang_parallax')." (%)", 'default' => "60");
				$options_params[] = array('type' => "text", 'id' => "content_padding", 'title' => __("Padding", 'lang_parallax')); //, 'default' => "30px 0 20px"
					//$options_params[] = array('type' => "text",	'id' => "content_padding_mobile", 'title' => __("Padding", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => 'content_padding');
			$options_params[] = array('category_end' => "");

				$options_params[] = array('category' => " - ".__("Headings", 'lang_parallax'), 'id' => 'mf_parallax_content_heading');
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h2", 'title' => __("Margin", 'lang_parallax')." (H2)", 'default' => "0 0 1em");
					$options_params[] = array('type' => "font", 'id' => "heading_font_h2", 'title' => __("Font", 'lang_parallax')." (H2)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h2", 'title' => __("Size", 'lang_parallax')." (H2)", 'default' => "2em");
					$options_params[] = array('type' => "weight", 'id' => "heading_weight_h2", 'title' => __("Weight", 'lang_parallax')." (H2)");
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h3", 'title' => __("Margin", 'lang_parallax')." (H3)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h3", 'title' => __("Size", 'lang_parallax')." (H3)");
					$options_params[] = array('type' => "weight", 'id' => "heading_weight_h3", 'title' => __("Weight", 'lang_parallax')." (H3)");
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h4", 'title' => __("Margin", 'lang_parallax')." (H4)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h4", 'title' => __("Size", 'lang_parallax')." (H4)");
					$options_params[] = array('type' => "weight", 'id' => "heading_weight_h4", 'title' => __("Weight", 'lang_parallax')." (H4)");
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h5", 'title' => __("Margin", 'lang_parallax')." (H5)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h5", 'title' => __("Size", 'lang_parallax')." (H5)");
					$options_params[] = array('type' => "weight", 'id' => "heading_weight_h5", 'title' => __("Weight", 'lang_parallax')." (H5)");
				$options_params[] = array('category_end' => "");

				$options_params[] = array('category' => " - ".__("Text", 'lang_parallax'), 'id' => 'mf_parallax_content_text');
					$options_params[] = array('type' => "text", 'id' => "section_size", 'title' => __("Font Size", 'lang_parallax')." (".__("Content", 'lang_parallax').")", 'default' => "1.6em");
					$options_params[] = array('type' => "text", 'id' => 'section_line_height', 'title' => __("Line Height", 'lang_parallax'), 'default' => "1.5");
					$options_params[] = array('type' => "text", 'id' => 'section_margin', 'title' => __("Margin", 'lang_parallax'));
					$options_params[] = array('type' => "text", 'id' => "quote_size", 'title' => __("Quote Size", 'lang_parallax'));
				$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Aside", 'lang_parallax'), 'id' => 'mf_parallax_aside');
				$options_params[] = array('type' => "text", 'id' => "aside_p", 'title' => __("Paragraph Size", 'lang_parallax'));
			$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Footer", 'lang_parallax'), 'id' => "mf_parallax_footer");
				$options_params[] = array('type' => "text",	'id' => "footer_bg", 'title' => __("Background", 'lang_parallax'), 'placeholder' => $bg_placeholder);
				$options_params[] = array('type' => "font", 'id' => "footer_font", 'title' => __("Font", 'lang_parallax'));
				$options_params[] = array('type' => "text", 'id' => "footer_font_size", 'title' => __("Font Size", 'lang_parallax'), 'default' => "1.8em");
				$options_params[] = array('type' => "color", 'id' => "footer_color", 'title' => __("Color", 'lang_parallax'));
				$options_params[] = array('type' => "text", 'id' => "footer_margin", 'title' => __("Margin", 'lang_parallax')); //, 'default' => "0 0 .3em"
				$options_params[] = array('type' => "text", 'id' => "footer_padding", 'title' => __("Padding", 'lang_parallax'), 'default' => ".1em 0");
				$options_params[] = array('type' => "align", 'id' => "footer_align", 'title' => __("Align", 'lang_parallax'));
					//$options_params[] = array('type' => "text",	'id' => "footer_padding_mobile", 'title' => __("Padding", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => 'footer_padding');
					$options_params[] = array('type' => "text", 'id' => "footer_widget_padding", 'title' => __("Widget Padding", 'lang_parallax'), 'default' => ".2em");
			$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Custom", 'lang_parallax'), 'id' => "mf_parallax_generic");
				$options_params[] = array('type' => "textarea",	'id' => "custom_css_all", 'title' => __("Custom CSS", 'lang_parallax'));
				$options_params[] = array('type' => "textarea",	'id' => "custom_css_mobile", 'title' => __("Custom CSS", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => 'mobile_breakpoint');
			$options_params[] = array('category_end' => "");

		return gather_params($options_params);
	}
}

if(!function_exists('widgets_parallax'))
{
	function widgets_parallax()
	{
		$arr_sidebars = wp_get_sidebars_widgets();

		register_sidebar(array(
			'name' => __("Header", 'lang_parallax'),
			'id' => 'widget_header',
			'before_widget' => "",
			'before_title' => '<div>',
			'after_title' => '</div>',
			'after_widget' => ""
		));

		if(isset($arr_sidebars['widget_header']) && count($arr_sidebars['widget_header']) > 0)
		{
			register_sidebar(array(
				'name' => __("Slide menu", 'lang_parallax'),
				'id' => 'widget_slide',
				'before_widget' => "",
				'before_title' => "",
				'after_title' => "",
				'after_widget' => ""
			));
		}

		register_sidebar(array(
			'name' => __("Pre Content", 'lang_parallax'),
			'id' => 'widget_pre_content',
			'before_widget' => "<div class='widget %s %s'>",
			'before_title' => '<h3>',
			'after_title' => '</h3>',
			'after_widget' => '</div>'
		));

		register_sidebar(array(
			'name' => __("Footer", 'lang_parallax'),
			'id' => 'widget_footer',
			'before_widget' => "<div class='widget'>",
			'before_title' => '<h3>',
			'after_title' => '</h3>',
			'after_widget' => '</div>'
		));

		register_widget('widget_parallax_logo');
		register_widget('widget_parallax_menu');
	}
}

if(!function_exists('meta_boxes_parallax'))
{
	function get_show_on_page_info()
	{
		$out = "<p>".sprintf(__("To choose if this page should be part of the One Page/Parallax you have to set %sShow on Front%s to Your latest Posts.", 'lang_parallax'), "<a href='".admin_url("options-reading.php")."'>", "</a>")."</p>";

		return $out;
	}

	function meta_boxes_parallax($meta_boxes)
	{
		$meta_prefix = "mf_parallax_";

		$meta_boxes[] = array(
			'id' => 'info',
			'title' => __("Information", 'lang_parallax'),
			'post_types' => array('page'),
			'context' => 'after_title',
			'priority' => 'low',
			'fields' => array(
				/*array(
					'name' => __("Heading", 'lang_parallax'),
					'id'   => $meta_prefix.'heading',
					'type' => 'text'
				),*/
				array(
					'name' => __("Aside", 'lang_parallax'),
					'id'   => $meta_prefix.'aside',
					'type' => 'wysiwyg'
				),
			)
		);

		$arr_page_settings = array();

		if(get_option('show_on_front') == 'posts')
		{
			$arr_page_settings[] = array(
				'name' => __("Show in Menu", 'lang_parallax'),
				'id' => $meta_prefix.'show_in_menu',
				'type' => 'select',
				'options' => get_yes_no_for_select(),
				'std' => 'yes',
			);

			$arr_page_settings[] = array(
				'name' => __("Show on Page", 'lang_parallax'),
				'id' => $meta_prefix.'show_on_page',
				'type' => 'select',
				'options' => get_yes_no_for_select(),
				'std' => 'yes',
			);
		}

		else
		{
			$arr_page_settings[] = array(
				'id' => $meta_prefix.'info',
				'type' => 'custom_html',
				'callback' => 'get_show_on_page_info',
			);
		}

		$arr_page_settings[] = array(
			'name' => __("Display Heading", 'lang_parallax'),
			'id' => $meta_prefix.'display_heading',
			'type' => 'select',
			'options' => get_yes_no_for_select(),
			'std' => 'yes',
		);

		$arr_page_settings[] = array(
			'name' => __("Background Color", 'lang_parallax'),
			'id' => $meta_prefix.'bg_color',
			'type' => 'color',
		);

		$arr_page_settings[] = array(
			'name' => __("Background", 'lang_parallax')." (".__("Desktop", 'lang_parallax').")",
			'id' => $meta_prefix.'background_image',
			'type' => 'file_advanced',
		);

		$arr_page_settings[] = array(
			'name' => __("Background", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")",
			'id' => $meta_prefix.'background_image_mobile',
			'type' => 'file_advanced',
		);

		$arr_page_settings[] = array(
			'name' => __("Repeat Image", 'lang_parallax'),
			'id' => $meta_prefix.'background_repeat',
			'type' => 'select',
			'options' => array(
				'' => "-- ".__("Choose here", 'lang_parallax')." --",
				'no-repeat' => __("No", 'lang_parallax'),
				//'repeat' => __("Yes", 'lang_parallax'),
				'repeat-x' => __("Yes", 'lang_parallax')." (".__("Horizontal", 'lang_parallax').")",
				'repeat-y' => __("Yes", 'lang_parallax')." (".__("Vertical", 'lang_parallax').")",
			),
		);

		$arr_page_settings[] = array(
			'name' => __("Text Color", 'lang_parallax'),
			'id' => $meta_prefix.'text_color',
			'type' => 'color',
		);

		$meta_boxes[] = array(
			'id' => 'settings',
			'title' => __("Settings", 'lang_parallax'),
			'post_types' => array('page'),
			'context' => 'side',
			'priority' => 'low',
			'fields' => $arr_page_settings,
		);

		return $meta_boxes;
	}
}

if(!function_exists('get_logo_parallax'))
{
	function get_logo_parallax($options = "")
	{
		if($options == "")
		{
			list($options_params, $options) = get_params();
		}

		$out = "<a href='".get_site_url()."/' id='site_logo'>";

			if($options['header_logo'] != '' || $options['header_mobile_logo'] != '')
			{
				if($options['header_logo'] != '')
				{
					$out .= "<img src='".$options['header_logo']."'".($options['header_mobile_logo'] != '' ? " class='hide_if_mobile'" : "")." alt='".__("Site logo", 'lang_parallax')."'>";
				}

				if($options['header_mobile_logo'] != '')
				{
					$out .= "<img src='".$options['header_mobile_logo']."'".($options['header_logo'] != '' ? " class='show_if_mobile'" : "")." alt='".__("Site mobile logo", 'lang_parallax')."'>";
				}
			}

			else
			{
				$site_name = get_bloginfo('name');
				$site_description = get_bloginfo('description');

				$out .= "<div>".$site_name."</div>";

				if($site_description != '')
				{
					$out .= "<span>".$site_description."</span>";
				}
			}

		$out .= "</a>";

		return $out;
	}
}

if(!function_exists('get_menu_parallax'))
{
	function get_menu_parallax($data = array())
	{
		global $wpdb;

		if(!isset($data['where'])){		$data['where'] = "";}
		if(!isset($data['type'])){		$data['type'] = "";}

		$out = "";

		if($data['type'] == 'slide')
		{
			$out .= "<nav>
				<a href='#' id='slide_nav'>
					<i class='fa fa-bars toggle_icon'></i>
				</a>
			</nav>"; //".__("Menu", 'lang_parallax')." 
		}

		else
		{
			if(in_array($data['type'], array('', 'secondary', 'both')))
			{
				$nav_content = wp_nav_menu(array('theme_location' => 'secondary', 'menu' => 'Secondary', 'container' => "div", 'container_override' => false, 'fallback_cb' => false, 'echo' => false));

				if($nav_content != '')
				{
					$out .= "<nav id='secondary_nav' class='theme_nav is_mobile_ready'>"
						.$nav_content
					."</nav>";
				}
			}

			if(in_array($data['type'], array('', 'main', 'both')))
			{
				$nav_content = "";

				if(get_option('show_on_front') == 'posts')
				{
					$nav_content .= "<ul id='menu-main-menu'>";

						$result = $wpdb->get_results("SELECT ID, post_title, post_name FROM ".$wpdb->posts." WHERE post_type = 'page' AND post_status = 'publish' ORDER BY menu_order ASC");

						$i = 0;

						$meta_prefix = "mf_parallax_";

						foreach($result as $post)
						{
							$post_id = $post->ID;
							$post_title = $post->post_title;
							$post_name = $post->post_name;

							$post_show_on_page = get_post_meta_or_default($post_id, $meta_prefix.'show_on_page', true, 'yes');
							$post_show_in_menu = get_post_meta_or_default($post_id, $meta_prefix.'show_in_menu', true, 'yes');

							if($post_show_in_menu == 'yes')
							{
								$post_url = ($post_show_on_page == 'yes' ? "/#".$post_name : get_permalink($post_id));

								$nav_content .= "<li class='page_item page-item-".$post_id.($i == 0 ? " current_page_item" : "")."'><a href='".$post_url."'>".($post_title == "" ? "&nbsp;" : $post_title)."</a></li>";

								$i++;
							}
						}

					$nav_content .= "</ul>";
				}

				else
				{
					$nav_content = wp_nav_menu(array('theme_location' => 'primary', 'menu' => 'Main', 'container' => "div", 'container_override' => false, 'echo' => false));
				}

				if($nav_content != '')
				{
					if($data['where'] == 'widget_slide')
					{
						$out .= "<nav id='primary_nav' class='theme_nav'>"
							.$nav_content
						."</nav>";
					}

					else
					{
						$out .= "<nav id='primary_nav' class='is_mobile_ready'>
							<i class='fa fa-bars toggle_icon'></i>
							<i class='fa fa-close toggle_icon'></i>"
							.$nav_content
						."</nav>";
					}
				}
			}
		}

		return $out;
	}
}