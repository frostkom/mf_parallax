<?php

include_once("include/classes.php");

add_action('after_setup_theme', 'setup_parallax');
add_action('widgets_init', 'widgets_parallax');
add_action('customize_register', 'customize_theme');
add_action('rwmb_meta_boxes', 'meta_boxes_parallax');
add_action('admin_menu', 'options_parallax');

if(!function_exists('setup_parallax'))
{
	function setup_parallax()
	{
		load_theme_textdomain('lang_parallax', get_template_directory()."/lang");

		register_nav_menus(array(
			'primary' => __('Primary Navigation', 'lang_parallax')
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
		add_theme_page(__('Theme Options', 'lang_parallax'), __('Theme Options', 'lang_parallax'), 'edit_theme_options', 'theme_options', 'options_page_parallax');
	}
}

if(!function_exists('options_page_parallax'))
{
	function options_page_parallax()
	{
		global $done_text, $error_text;

		$strFileContent = check_var('strFileContent');

		echo "<div class='wrap'>
			<h2>".__('Theme Options', 'lang_parallax')."</h2>";

			list($upload_path, $upload_url) = get_uploads_folder("mf_parallax");

			$dir_exists = true;

			if(!is_dir($upload_path))
			{
				if(!mkdir($upload_path, 0755, true))
				{
					$dir_exists = false;
				}
			}

			if($dir_exists == false)
			{
				$error_text = __("Could not create a folder in uploads. Please add the correct rights for the script to create a new subfolder", 'lang_parallax');
			}

			else
			{
				$error_text = $done_text = "";

				if(isset($_POST['btnParallaxBackup']))
				{
					list($options_params, $options) = get_params();

					if(count($options) > 0)
					{
						$file = "mf_parallax_".date("YmdHi").".json";

						$success = set_file_content(array('file' => $upload_path.$file, 'mode' => 'a', 'content' => json_encode($options)));

						if($success == true)
						{
							$done_text = __("The theme settings were backed up", 'lang_parallax');
						}

						else
						{
							$error_text = __("It was not possible to backup the theme settings", 'lang_parallax');
						}
					}

					else
					{
						$error_text = __("There were no theme settings to save", 'lang_parallax');
					}
				}

				else if(isset($_REQUEST['btnParallaxRestore']))
				{
					$strFileName = check_var('strFileName');

					if($strFileName != '')
					{
						$strFileContent = get_file_content(array('file' => $upload_path.$strFileName));
					}

					else
					{
						$strFileContent = stripslashes(str_replace(array("\\", '"'), array("", "'"), $strFileContent));
					}

					if($strFileContent != '')
					{
						$json = json_decode($strFileContent, true);

						if(is_array($json))
						{
							foreach($json as $key => $value)
							{
								if($value != '')
								{
									set_theme_mod($key, $value);
								}
							}

							$done_text = __("The restore was successful", 'lang_parallax');

							$strFileContent = "";
						}

						else
						{
							$error_text = __("There is something wrong with the source to restore", 'lang_parallax')." (".htmlspecialchars($strFileContent)." -> ".var_export($json, true).")";
						}
					}
				}

				else if(isset($_GET['btnParallaxDelete']))
				{
					$strFileName = check_var('strFileName');

					unlink($upload_path.$strFileName);

					$done_text = __("The file was deleted successfully", 'lang_parallax');
				}

				echo get_notification();

				global $globals;

				$globals['mf_parallax_files'] = array();

				get_file_info(array('path' => $upload_path, 'callback' => "get_previous_backups"));

				$count_temp = count($globals['mf_parallax_files']);

				if($count_temp > 0)
				{
					echo "<table class='widefat striped'>";

						$arr_header[] = __("Name", 'lang_parallax');
						$arr_header[] = __("Date", 'lang_parallax');

						echo show_table_header($arr_header)
						."<tbody>";

							for($i = 0; $i < $count_temp; $i++)
							{
								echo "<tr>
									<td>"
										.$globals['mf_parallax_files'][$i]['name']
										."<div class='row-actions'>
											<a href='".$upload_url.$globals['mf_parallax_files'][$i]['name']."'>Download</a>
											 | <a href='?page=theme_options&btnParallaxRestore&strFileName=".$globals['mf_parallax_files'][$i]['name']."'>Restore</a>
											 | <a href='?page=theme_options&btnParallaxDelete&strFileName=".$globals['mf_parallax_files'][$i]['name']."'>Delete</a>
										</div>
									</td>
									<td>".date("Y-m-d H:i", $globals['mf_parallax_files'][$i]['time'])."</td>
								</tr>";
							}

						echo "</tbody>
					</table>
					<br>";
				}

				else
				{
					echo "<p>".__("There are no previous backups", 'lang_parallax')."</p>";
				}

				echo "<form method='post' action=''>"
					.show_submit(array('name' => "btnParallaxBackup", 'text' => __("Save New Backup", 'lang_parallax')))
				."</form>
				<br>
				<form method='post' action=''>"
					.show_textarea(array('name' => 'strFileContent', 'value' => $strFileContent))
					.show_submit(array('name' => "btnParallaxRestore", 'text' => __("Restore Backup", 'lang_parallax')))
				."</form>";
			}

		echo "</div>";
	}
}

if(!function_exists('get_previous_backups'))
{
	function get_previous_backups($data)
	{
		global $globals;

		$globals['mf_parallax_files'][] = array(
			'dir' => $data['file'],
			'name' => basename($data['file']), 
			'time' => filemtime($data['file'])
		);
	}
}

if(!function_exists('get_params'))
{
	function get_params()
	{
		$options_params = array();

		$bg_placeholder = "#ffffff, rgba(0, 0, 0, .3), url(background.png)";

		$options_params[] = array('category' => __("Generic", 'lang_parallax'), 'id' => "mf_parallax_body");
			$options_params[] = array('type' => "text", 'id' => "body_bg", 'title' => __("Background", 'lang_parallax'), 'placeholder' => $bg_placeholder);
				$options_params[] = array('type' => "font", 'id' => "body_font", 'title' => __("Font", 'lang_parallax'));
				$options_params[] = array('type' => "color", 'id' => "body_color", 'title' => __("Text Color", 'lang_parallax'));
				$options_params[] = array('type' => "color", 'id' => "body_link_color", 'title' => __("Link Color", 'lang_parallax'));
				$options_params[] = array('type' => "text", 'id' => "body_font_size", 'title' => __("Font size", 'lang_parallax'), 'default' => "1.2vw");
				$options_params[] = array('type' => "text", 'id' => "body_desktop_font_size", 'title' => __("Font size", 'lang_parallax')." (".__("Desktop", 'lang_parallax').")", 'default' => ".625em", 'show_if' => "body_font_size");
				$options_params[] = array('type' => "number", 'id' => "website_max_width", 'title' => __("Website Max Width", 'lang_parallax'), 'default' => "1100");
				$options_params[] = array('type' => "number", 'id' => "mobile_breakpoint", 'title' => __("Mobile Breakpoint", 'lang_parallax'), 'default' => "600");
					$options_params[] = array('type' => "text", 'id' => "mobile_aside_img_max_width", 'title' => __("Aside Image Max Width", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => "mobile_breakpoint");
		$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Header", 'lang_parallax'), 'id' => "mf_parallax_header");
				$options_params[] = array('type' => "checkbox", 'id' => "header_fixed", 'title' => __("Fixed", 'lang_parallax'), 'default' => 2);
				$options_params[] = array('type' => "text",	'id' => "header_bg", 'title' => __("Background", 'lang_parallax'), 'placeholder' => $bg_placeholder);
				$options_params[] = array('type' => "checkbox", 'id' => "header_override_bg_with_page_bg", 'title' => __("Override background with page background", 'lang_parallax'), 'default' => 2);
				$options_params[] = array('type' => "text",	'id' => "header_padding", 'title' => __("Padding", 'lang_parallax'));
					$options_params[] = array('type' => "text",	'id' => "header_padding_mobile", 'title' => __("Padding", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")");
				$options_params[] = array('type' => "image", 'id' => "header_logo", 'title' => __("Logo", 'lang_parallax'));
					$options_params[] = array('type' => "image", 'id' => "header_mobile_logo", 'title' => __("Logo", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => "header_logo");
					$options_params[] = array('type' => "text",	'id' => "logo_padding", 'title' => __("Logo Padding", 'lang_parallax'), 'default' => "1.5em 1em");
					$options_params[] = array('type' => "font",	'id' => "logo_font", 'title' => __("Logo Font", 'lang_parallax'), 'hide_if' => "header_logo");
					$options_params[] = array('type' => "text", 'id' => "logo_font_size", 'title' => __("Logo Font Size", 'lang_parallax'), 'default' => "3em", 'hide_if' => "header_logo");
					$options_params[] = array('type' => "color", 'id' => "logo_color", 'title' => __("Logo Color", 'lang_parallax'), 'hide_if' => "header_logo");
			$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Navigation", 'lang_parallax'), 'id' => "mf_parallax_navigation");
				$options_params[] = array('type' => "checkbox", 'id' => "nav_mobile", 'title' => __("Compressed on mobile", 'lang_parallax'), 'default' => 2);
					$options_params[] = array('type' => "checkbox", 'id' => "nav_click2expand", 'title' => __("Click to expand", 'lang_parallax'), 'default' => 1);
				$options_params[] = array('type' => "text", 'id' => "nav_padding", 'title' => __("Padding", 'lang_parallax'), 'default' => "0 1em");
				$options_params[] = array('type' => "text", 'id' => "nav_padding_mobile", 'title' => __("Padding", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => "nav_padding");
				$options_params[] = array('type' => "float", 'id' => "nav_float", 'title' => __("Float", 'lang_parallax'), 'default' => "right");
				$options_params[] = array('type' => "float", 'id' => "nav_float_mobile", 'title' => __("Float", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'default' => "none", 'show_if' => "nav_float");
				$options_params[] = array('type' => "text", 'id' => "nav_size", 'title' => __("Size", 'lang_parallax'), 'default' => "2em");
				$options_params[] = array('type' => "color", 'id' => "nav_color", 'title' => __("Color", 'lang_parallax'));
					$options_params[] = array('type' => "color", 'id' => "nav_color_hover", 'title' => __("Color", 'lang_parallax')." (".__("Hover", 'lang_parallax').")", 'show_if' => "nav_color");
				$options_params[] = array('type' => "text", 'id' => "nav_link_padding", 'title' => __("Link Padding", 'lang_parallax'), 'default' => "1em");
			$options_params[] = array('category_end' => "");

			/*$options_params[] = array('category' => __("Pre Content", 'lang_parallax'), 'id' => "mf_parallax_front");
				$options_params[] = array('type' => "text", 'id' => "front_bg", 'title' => __("Background", 'lang_parallax'), 'placeholder' => $bg_placeholder);
			$options_params[] = array('category_end' => "");*/

			$options_params[] = array('category' => "Content", 'id' => "mf_parallax_content");
				$options_params[] = array('type' => "checkbox", 'id' => "content_stretch_height", 'title' => __("Match height with screen size", 'lang_parallax'), 'default' => 2);
				$options_params[] = array('type' => "number", 'id' => "content_main_width", 'title' => __("Main column width", 'lang_parallax')." (%)", 'default' => "60");
				$options_params[] = array('type' => "text", 'id' => "content_padding", 'title' => __("Padding", 'lang_parallax'), 'default' => "30px 0 20px");
					$options_params[] = array('type' => "text",	'id' => "content_padding_mobile", 'title' => __("Padding", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => "content_padding");
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h2", 'title' => __("Heading Margin", 'lang_parallax')." (H2)", 'default' => "3em 0 1em");
					$options_params[] = array('type' => "font", 'id' => "heading_font_h2", 'title' => __("Heading Font", 'lang_parallax')." (H2)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h2", 'title' => __("Heading Size", 'lang_parallax')." (H2)", 'default' => "2em");
					$options_params[] = array('type' => "text", 'id' => "heading_weight_h2", 'title' => __("Heading Weight", 'lang_parallax')." (H2)");
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h3", 'title' => __("Heading Margin", 'lang_parallax')." (H3)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h3", 'title' => __("Heading Size", 'lang_parallax')." (H3)");
					$options_params[] = array('type' => "text", 'id' => "heading_weight_h3", 'title' => __("Heading Weight", 'lang_parallax')." (H3)");
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h4", 'title' => __("Heading Margin", 'lang_parallax')." (H4)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h4", 'title' => __("Heading Size", 'lang_parallax')." (H4)");
					$options_params[] = array('type' => "text", 'id' => "heading_weight_h4", 'title' => __("Heading Weight", 'lang_parallax')." (H4)");
					$options_params[] = array('type' => "text", 'id' => "heading_margin_h5", 'title' => __("Heading Margin", 'lang_parallax')." (H5)");
					$options_params[] = array('type' => "text", 'id' => "heading_font_size_h5", 'title' => __("Heading Size", 'lang_parallax')." (H5)");
					$options_params[] = array('type' => "text", 'id' => "heading_weight_h5", 'title' => __("Heading Weight", 'lang_parallax')." (H5)");
					$options_params[] = array('type' => "text", 'id' => "section_size", 'title' => __("Paragraph text size", 'lang_parallax'), 'default' => "1.6em");
					$options_params[] = array('type' => "text", 'id' => "quote_size", 'title' => __("Quote size", 'lang_parallax'));
					$options_params[] = array('type' => "text", 'id' => "aside_p", 'title' => __("Aside paragraph size", 'lang_parallax'));
			$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Footer", 'lang_parallax'), 'id' => "mf_parallax_footer");
				$options_params[] = array('type' => "text",	'id' => "footer_bg", 'title' => __("Background", 'lang_parallax'), 'placeholder' => $bg_placeholder);
				$options_params[] = array('type' => "font", 'id' => "footer_font", 'title' => __("Font", 'lang_parallax'));
				$options_params[] = array('type' => "text", 'id' => "footer_font_size", 'title' => __("Font size", 'lang_parallax'), 'default' => "1.8em");
				$options_params[] = array('type' => "color", 'id' => "footer_color", 'title' => __("Color", 'lang_parallax'));
				$options_params[] = array('type' => "text", 'id' => "footer_margin", 'title' => __("Margin", 'lang_parallax'), 'default' => "0 0 .3em");
				$options_params[] = array('type' => "text", 'id' => "footer_padding", 'title' => __("Padding", 'lang_parallax'), 'default' => ".1em");
					$options_params[] = array('type' => "text",	'id' => "footer_padding_mobile", 'title' => __("Padding", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")", 'show_if' => "footer_padding");
					$options_params[] = array('type' => "text", 'id' => "footer_widget_padding", 'title' => __("Widget Padding", 'lang_parallax'), 'default' => ".2em");
			$options_params[] = array('category_end' => "");

			$options_params[] = array('category' => __("Custom", 'lang_parallax'), 'id' => "mf_parallax_generic");
				$options_params[] = array('type' => "textarea",	'id' => "custom_css_all", 'title' => __("Custom CSS", 'lang_parallax'));
				$options_params[] = array('type' => "textarea",	'id' => "custom_css_mobile", 'title' => __("Custom CSS", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")");
			$options_params[] = array('category_end' => "");

		$options = array();

		//Maybe use get_theme_mods() instead?

		foreach($options_params as $param)
		{
			if(!isset($param['category']) && !isset($param['category_end']))
			{
				$default = isset($param['default']) ? $param['default'] : "";

				$options[$param['id']] = get_theme_mod($param['id'], $default);
			}
		}

		return array($options_params, $options);
	}
}

if(!function_exists('widgets_parallax'))
{
	function widgets_parallax()
	{
		register_sidebar(array(
			'name' => __('Header', 'lang_parallax'),
			'id' => 'widget_header',
			'description' => __('The widget area', 'lang_parallax'),
			'before_widget' => "",
			'before_title' => '<div>',
			'after_title' => '</div>',
			'after_widget' => ""
		));

		register_sidebar(array(
			'name' => __('Pre Content', 'lang_parallax'),
			'id' => 'widget_pre_content',
			'description' => __('The widget area', 'lang_theme'),
			'before_widget' => "<div class='widget %s %s'>",
			'before_title' => '<h3>',
			'after_title' => '</h3>',
			'after_widget' => '</div>'
		));

		register_sidebar(array(
			'name' => __('Footer', 'lang_parallax'),
			'id' => 'widget_footer',
			'description' => __('The widget area', 'lang_parallax'),
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
			'title' => __('Information', 'lang_parallax'),
			'pages' => array('page'),
			//'context' => 'side',
			'priority' => 'low',
			'fields' => array(
				array(
					'name' => __("Heading", 'lang_parallax'),
					'id'   => $meta_prefix."heading",
					'type' => 'text'
				),
				array(
					'name' => __("Aside", 'lang_parallax'),
					'id'   => $meta_prefix."aside",
					'type' => 'wysiwyg'
				),
			)
		);

		$meta_boxes[] = array(
			'id' => 'settings',
			'title' => __('Settings', 'lang_parallax'),
			'pages' => array('page'),
			'context' => 'side',
			'priority' => 'low',
			'fields' => array(
				array(
					'name' => __("Show on page", 'lang_parallax'),
					'id' => $meta_prefix."show_on_page",
					'type' => 'select',
					'options' => get_yes_no_for_select(),
					'std' => 'yes',
				),
				array(
					'name' => __("Background", 'lang_parallax')." (".__("Desktop", 'lang_parallax').")",
					'id' => $meta_prefix."background_image",
					'type' => 'thickbox_image',
				),
				array(
					'name' => __("Background", 'lang_parallax')." (".__("Mobile", 'lang_parallax').")",
					'id' => $meta_prefix."background_image_mobile",
					'type' => 'thickbox_image',
				),
				array(
					'name' => __("Text Color", 'lang_parallax'),
					'id' => $meta_prefix."text_color",
					'type' => 'color',
				),
				array(
					'name' => __("Background Color", 'lang_parallax'),
					'id' => $meta_prefix."bg_color",
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

			if($post_show_on_page == 'yes')
			{
				$nav_content .= "<li class='page_item page-item-".$post_id.($i == 0 ? " current_page_item" : "")."'><a href='/".$css_identifier."'>".($post_title == "" ? "&nbsp;" : $post_title)."</a></li>";

				$i++;
			}
		}

		if($nav_content != '')
		{
			$out .= "<nav>
				<i class='fa fa-bars'></i>
				<i class='fa fa-close'></i>
				<ul>".$nav_content."</ul>
			</nav>";
		}

		return $out;
	}
}