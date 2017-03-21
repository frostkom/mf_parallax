<?php

if(!function_exists('head_parallax'))
{
	function head_parallax()
	{
		enqueue_theme_fonts();

		$template_url = get_bloginfo('template_url');

		wp_enqueue_style('style', $template_url."/include/style.php");

		list($options_params, $options) = get_params();

		mf_enqueue_script('script_nav', $template_url."/include/jquery.nav.js");
		mf_enqueue_script('script_parallax', $template_url."/include/script.js", array('override_bg' => isset($options['header_override_bg_with_page_bg']) && $options['header_override_bg_with_page_bg'] == 2));
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

		add_post_type_support('page', 'excerpt');

		remove_action('wp_head', 'wp_print_scripts');
		remove_action('wp_head', 'wp_print_head_scripts', 9);
		remove_action('wp_head', 'wp_enqueue_scripts', 1);
		add_action('wp_footer', 'wp_print_scripts', 5);
		add_action('wp_footer', 'wp_enqueue_scripts', 5);
		add_action('wp_footer', 'wp_print_head_scripts', 5);
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

		$bg_placeholder = "#ffffff, rgba(0, 0, 0, .3), url(background.png)";

		$options_params[] = array('category' => __("Generic", 'lang_parallax'), 'id' => "mf_parallax_body");
			$options_params[] = array('type' => "text", 'id' => "body_bg", 'title' => __("Background", 'lang_parallax'), 'default' => "#fff", 'placeholder' => $bg_placeholder);
				$options_params[] = array('type' => "font", 'id' => "body_font", 'title' => __("Font", 'lang_parallax'));
				$options_params[] = array('type' => "color", 'id' => "body_color", 'title' => __("Text Color", 'lang_parallax'));
				$options_params[] = array('type' => "color", 'id' => "body_link_color", 'title' => __("Link Color", 'lang_parallax'));
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
					$options_params[] = array('type' => "text",	'id' => "header_padding_mobile", 'title' => __("Padding", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => 'mobile_breakpoint');
				
			$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Logo", 'lang_parallax'), 'id' => 'mf_parallax_logo');
				$options_params[] = array('type' => "image", 'id' => "header_logo", 'title' => __("Image", 'lang_parallax'));
					$options_params[] = array('type' => "image", 'id' => "header_mobile_logo", 'title' => __("Image", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => 'header_logo');
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

			$options_params[] = array('category' => "Content", 'id' => "mf_parallax_content");
				$options_params[] = array('type' => "checkbox", 'id' => "content_stretch_height", 'title' => __("Match Height with Screen Size", 'lang_parallax'), 'default' => 2);
				$options_params[] = array('type' => "number", 'id' => "content_main_width", 'title' => __("Main Column Width", 'lang_parallax')." (%)", 'default' => "60");
				$options_params[] = array('type' => "text", 'id' => "content_padding", 'title' => __("Padding", 'lang_parallax'), 'default' => "30px 0 20px");
					$options_params[] = array('type' => "text",	'id' => "content_padding_mobile", 'title' => __("Padding", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => 'content_padding');
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h2", 'title' => __("Heading Margin", 'lang_parallax')." (H2)", 'default' => "3em 0 1em");
					$options_params[] = array('type' => "font", 'id' => "heading_font_h2", 'title' => __("Heading Font", 'lang_parallax')." (H2)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h2", 'title' => __("Heading Size", 'lang_parallax')." (H2)", 'default' => "2em");
					$options_params[] = array('type' => "weight", 'id' => "heading_weight_h2", 'title' => __("Heading Weight", 'lang_parallax')." (H2)");
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h3", 'title' => __("Heading Margin", 'lang_parallax')." (H3)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h3", 'title' => __("Heading Size", 'lang_parallax')." (H3)");
					$options_params[] = array('type' => "weight", 'id' => "heading_weight_h3", 'title' => __("Heading Weight", 'lang_parallax')." (H3)");
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h4", 'title' => __("Heading Margin", 'lang_parallax')." (H4)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h4", 'title' => __("Heading Size", 'lang_parallax')." (H4)");
					$options_params[] = array('type' => "weight", 'id' => "heading_weight_h4", 'title' => __("Heading Weight", 'lang_parallax')." (H4)");
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h5", 'title' => __("Heading Margin", 'lang_parallax')." (H5)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h5", 'title' => __("Heading Size", 'lang_parallax')." (H5)");
					$options_params[] = array('type' => "weight", 'id' => "heading_weight_h5", 'title' => __("Heading Weight", 'lang_parallax')." (H5)");
					$options_params[] = array('type' => "text", 'id' => "section_size", 'title' => __("Font Size", 'lang_parallax')." (".__("Content", 'lang_parallax').")", 'default' => "1.6em");
					$options_params[] = array('type' => "text", 'id' => "quote_size", 'title' => __("Quote Size", 'lang_parallax'));
					$options_params[] = array('type' => "text", 'id' => "aside_p", 'title' => __("Aside Paragraph Size", 'lang_parallax'));
			$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Footer", 'lang_parallax'), 'id' => "mf_parallax_footer");
				$options_params[] = array('type' => "text",	'id' => "footer_bg", 'title' => __("Background", 'lang_parallax'), 'placeholder' => $bg_placeholder);
				$options_params[] = array('type' => "font", 'id' => "footer_font", 'title' => __("Font", 'lang_parallax'));
				$options_params[] = array('type' => "text", 'id' => "footer_font_size", 'title' => __("Font Size", 'lang_parallax'), 'default' => "1.8em");
				$options_params[] = array('type' => "color", 'id' => "footer_color", 'title' => __("Color", 'lang_parallax'));
				$options_params[] = array('type' => "text", 'id' => "footer_margin", 'title' => __("Margin", 'lang_parallax')); //, 'default' => "0 0 .3em"
				$options_params[] = array('type' => "text", 'id' => "footer_padding", 'title' => __("Padding", 'lang_parallax'), 'default' => ".1em 0");
				$options_params[] = array('type' => "align", 'id' => "footer_align", 'title' => __("Align", 'lang_parallax'));
					$options_params[] = array('type' => "text",	'id' => "footer_padding_mobile", 'title' => __("Padding", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => 'footer_padding');
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
		register_sidebar(array(
			'name' => __("Header", 'lang_parallax'),
			'id' => 'widget_header',
			'before_widget' => "",
			'before_title' => '<div>',
			'after_title' => '</div>',
			'after_widget' => ""
		));

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
	function meta_boxes_parallax($meta_boxes)
	{
		$meta_prefix = "mf_parallax_";

		$meta_boxes[] = array(
			'id' => 'info',
			'title' => __("Information", 'lang_parallax'),
			'pages' => array('page'),
			'context' => 'after_title',
			'priority' => 'low',
			'fields' => array(
				array(
					'name' => __("Heading", 'lang_parallax'),
					'id'   => $meta_prefix.'heading',
					'type' => 'text'
				),
				array(
					'name' => __("Aside", 'lang_parallax'),
					'id'   => $meta_prefix.'aside',
					'type' => 'wysiwyg'
				),
			)
		);

		$meta_boxes[] = array(
			'id' => 'settings',
			'title' => __("Settings", 'lang_parallax'),
			'pages' => array('page'),
			'context' => 'side',
			'priority' => 'low',
			'fields' => array(
				array(
					'name' => __("Show on page", 'lang_parallax'),
					'id' => $meta_prefix.'show_on_page',
					'type' => 'select',
					'options' => get_yes_no_for_select(),
					'std' => 'yes',
				),
				array(
					'name' => __("Show in menu", 'lang_parallax'),
					'id' => $meta_prefix.'show_in_menu',
					'type' => 'select',
					'options' => get_yes_no_for_select(),
					'std' => 'yes',
				),
				array(
					'name' => __("Background", 'lang_parallax')." (".__("Desktop", 'lang_parallax').")",
					'id' => $meta_prefix.'background_image',
					'type' => 'file_advanced',
				),
				array(
					'name' => __("Background", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")",
					'id' => $meta_prefix.'background_image_mobile',
					'type' => 'file_advanced',
				),
				array(
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
				),
				array(
					'name' => __("Text Color", 'lang_parallax'),
					'id' => $meta_prefix.'text_color',
					'type' => 'color',
				),
				array(
					'name' => __("Background Color", 'lang_parallax'),
					'id' => $meta_prefix.'bg_color',
					'type' => 'color',
				)
			)
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
	function get_menu_parallax()
	{
		global $wpdb;

		$out = "";

		$result = $wpdb->get_results("SELECT ID, post_title, post_name FROM ".$wpdb->posts." WHERE post_type = 'page' AND post_status = 'publish' ORDER BY menu_order ASC");

		$i = 0;

		$nav_content = "";

		$meta_prefix = "mf_parallax_";

		foreach($result as $post)
		{
			$post_id = $post->ID;
			$post_title = $post->post_title;
			$post_name = $post->post_name;

			$css_identifier = "#".$post_name;

			$post_show_on_page = get_post_meta($post_id, $meta_prefix.'show_on_page', true);
			$post_show_in_menu = get_post_meta($post_id, $meta_prefix.'show_in_menu', true);

			if($post_show_on_page == 'yes' && $post_show_in_menu != 'no')
			{
				$nav_content .= "<li class='page_item page-item-".$post_id.($i == 0 ? " current_page_item" : "")."'><a href='/".$css_identifier."'>".($post_title == "" ? "&nbsp;" : $post_title)."</a></li>";

				$i++;
			}
		}

		if($nav_content != '')
		{
			$out .= "<nav id='primary_nav' class='is_mobile_ready'>
				<i class='fa fa-bars toggle_icon'></i>
				<i class='fa fa-close toggle_icon'></i>
				<ul id='menu-main-menu'>".$nav_content."</ul>
			</nav>";
		}

		return $out;
	}
}