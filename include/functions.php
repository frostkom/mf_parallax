<?php

if(!function_exists('head_parallax'))
{
	function head_parallax()
	{
		$obj_theme_core = new mf_theme_core();
		$obj_theme_core->get_params();
		$obj_theme_core->enqueue_theme_fonts();

		$template_url = get_bloginfo('template_url');
		$theme_version = get_theme_version();

		mf_enqueue_style('style', $template_url."/include/style.php", $theme_version);

		mf_enqueue_script('script_nav', $template_url."/include/jquery.nav.js", $theme_version);
		mf_enqueue_script('script_parallax', $template_url."/include/script.js", array(
			'override_bg' => (isset($obj_theme_core->options['header_override_bg_with_page_bg']) && $obj_theme_core->options['header_override_bg_with_page_bg'] == 2),
			'slide_nav_position' => (isset($obj_theme_core->options['slide_nav_position']) && $obj_theme_core->options['slide_nav_position'] == 'left' ? $obj_theme_core->options['slide_nav_position'] : 'right'),
			'hamburger_fixed' => (isset($obj_theme_core->options['hamburger_fixed']) ? $obj_theme_core->options['hamburger_fixed'] : false)
		), $theme_version);
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

if(!function_exists('widgets_parallax'))
{
	function widgets_parallax()
	{
		$obj_theme_core = new mf_theme_core();
		$obj_theme_core->get_custom_widget_areas();

		register_sidebar(array(
			'name' => __("Header", 'lang_parallax'),
			'id' => 'widget_header',
			'before_widget' => "",
			'before_title' => '<div>',
			'after_title' => '</div>',
			'after_widget' => ""
		));

		$obj_theme_core->display_custom_widget_area('widget_header');

		if(is_active_widget_area('widget_header'))
		{
			register_sidebar(array(
				'name' => __("Slide menu", 'lang_parallax'),
				'id' => 'widget_slide',
				'before_widget' => "",
				'before_title' => "",
				'after_title' => "",
				'after_widget' => ""
			));

			$obj_theme_core->display_custom_widget_area('widget_slide');
		}

		register_sidebar(array(
			'name' => __("Pre Content", 'lang_parallax'),
			'id' => 'widget_pre_content',
			'before_widget' => "<div class='widget %s %s'>",
			'before_title' => '<h3>',
			'after_title' => '</h3>',
			'after_widget' => '</div>'
		));

		$obj_theme_core->display_custom_widget_area('widget_pre_content');

		register_sidebar(array(
			'name' => __("Footer", 'lang_parallax'),
			'id' => 'widget_footer',
			'before_widget' => "<div class='widget %s %s'>",
			'before_title' => '<h3>',
			'after_title' => '</h3>',
			'after_widget' => '</div>'
		));

		$obj_theme_core->display_custom_widget_area('widget_footer');

		register_widget('widget_parallax_menu');
	}
}

if(!function_exists('meta_show_on_page_info'))
{
	function meta_show_on_page_info()
	{
		$out = "<p>".sprintf(__("To choose if this page should be part of the One Page/Parallax you have to set %sShow on Front%s to Your latest Posts.", 'lang_parallax'), "<a href='".admin_url("options-reading.php")."'>", "</a>")."</p>";

		return $out;
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
			'post_types' => array('page'),
			'context' => (function_exists('is_gutenberg_page') && !isset($_GET['classic-editor']) ? 'normal' : 'after_title'),
			'priority' => (function_exists('is_gutenberg_page') && !isset($_GET['classic-editor']) ? 'high' : 'low'),
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
				'callback' => 'meta_show_on_page_info',
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
				'' => "-- ".__("Choose Here", 'lang_parallax')." --",
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

						foreach($result as $r)
						{
							$post_id = $r->ID;
							$post_title = $r->post_title;
							$post_name = $r->post_name;

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
						global $obj_theme_core;

						if(!isset($obj_theme_core))
						{
							$obj_theme_core = new mf_theme_core();
						}

						$obj_theme_core->get_params();

						$out .= "<nav id='primary_nav' class='is_mobile_ready".(isset($obj_theme_core->options['nav_full_width']) && $obj_theme_core->options['nav_full_width'] == 2 ? " full_width" : "")."'>
							<i class='fa fa-bars toggle_icon'></i>
							<i class='fa fa-times toggle_icon'></i>"
							.$nav_content
						."</nav>";
					}
				}
			}
		}

		return $out;
	}
}