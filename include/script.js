document.createElement("header");
	document.createElement("nav");
/*document.createElement("mf-slide-nav");
document.createElement("mf-content");*/
	document.createElement("section");
	document.createElement("article");
document.createElement("footer");

jQuery(function($)
{
	/* Slide nav */
	if($("#slide_nav").length > 0)
	{
		if(script_parallax.slide_nav_position == 'left')
		{
			/* The same solution as from the right does not work in iOS */
			function show_or_hide_slide_menu()
			{
				var dom_obj = $("#mf-slide-nav");

				if(dom_obj.is(':visible'))
				{
					dom_obj.fadeOut();
				}

				else
				{
					dom_obj.fadeIn();
				}

				return false;
			}
		}

		else
		{
			var offset_orig = $("#mf-slide-nav > div").css('right');

			function show_or_hide_slide_menu()
			{
				var dom_obj = $("#mf-slide-nav");

				if(dom_obj.is(':visible'))
				{
					dom_obj.children("div").animate({'right': offset_orig}, 500, function()
					{
						$(this).parent("#mf-slide-nav").fadeOut();
					});
				}

				else
				{
					dom_obj.fadeIn().children("div").animate({'right': '0'}, 500);
				}

				return false;
			}
		}

		$(document).on('click', "#slide_nav, #mf-slide-nav, #mf-slide-nav .fa-times, #mf-slide-nav a", function()
		{
			show_or_hide_slide_menu();
		});
	}

	/* One-page nav */
	else
	{
		$("header nav").onePageNav(
		{
			currentClass: 'current_page_item',
			changeHash: true,
			scrollThreshold: 0.1,
			/* Extension */
			scrollToCurrentTopAnyway: true,
			classChange: function(self, $parent)
			{
				if(script_parallax.override_bg)
				{
					var header_class = $parent.children("a").attr('href').replace("/", "").replace("#", "header_");

					self.$elem.parents("header").attr({'class': header_class});
				}
			}
		});

		$(document).on('click', "header nav > .toggle_icon", function()
		{
			$(this).parent("nav").toggleClass('open');
		});
	}

	/* Fixed Hamburger */
	if(script_parallax.hamburger_fixed == 'fixed')
	{
		function show_or_hide_hamburger()
		{
			if($(this).scrollTop() > 300)
			{
				$("#hamburger_to_top").fadeIn();
			}

			else
			{
				$("#hamburger_to_top").fadeOut();
			}
		}

		$("body").append("<a href='#' id='hamburger_to_top'><i class='fa fa-bars fa-lg'></i></a>");

		show_or_hide_hamburger();

		$(window).scroll(function()
		{
			show_or_hide_hamburger();
		});

		$(document).on('click', "#hamburger_to_top", function()
		{
			scroll_to_top();
			show_or_hide_slide_menu();

			return false;
		});
	}

	$(".aside p").each(function()
	{
		if($(this).children("img").length == 1 || ($(this).children("img.show_if_mobile").length == 1 && $(this).children("img.hide_if_mobile").length == 1))
		{
			$(this).addClass('has_one_image');
		}
	});
});