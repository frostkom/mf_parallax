document.createElement("header");
	document.createElement("nav");
document.createElement("mf-slide-nav");
/*document.createElement("mf-pre-content");*/
document.createElement("mf-content");
	document.createElement("section");
	document.createElement("article");
document.createElement("footer");

jQuery(function($)
{
	/* Slide nav */
	if(script_parallax.slide_nav_position == 'left')
	{
		// The same solution as from the right does not work in iOS
		function show_slide_menu()
		{
			$('mf-slide-nav').fadeIn();

			return false;
		}

		function hide_slide_menu()
		{
			$('mf-slide-nav').fadeOut();

			return false;
		}
	}

	else
	{
		var offset_orig = $('mf-slide-nav > div').css('right');

		function show_slide_menu()
		{
			$('mf-slide-nav').fadeIn().children('div').animate({'right': '0'}, 500);

			return false;
		}

		function hide_slide_menu()
		{
			$('mf-slide-nav > div').animate({'right': offset_orig}, 500, function()
			{
				$(this).parent('mf-slide-nav').fadeOut();
			});

			return false;
		}
	}

	$(document).on('click', '#slide_nav', function()
	{
		show_slide_menu();
	});

	$(document).on('click', 'mf-slide-nav, mf-slide-nav .fa-close, mf-slide-nav a', function()
	{
		hide_slide_menu();
	});

	/* One-page nav */
	$('header nav').onePageNav(
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
				var header_class = $parent.children('a').attr('href').replace("/", "").replace("#", "header_");

				self.$elem.parents('header').attr({'class': header_class});
			}
		}
	});

	/* Mobile nav */
	$(document).on('click', 'header nav > .toggle_icon', function()
	{
		$(this).parent('nav').toggleClass('open');
	});

	$('aside p, #aside p').each(function()
	{
		if($(this).children('img').length == 1 || ($(this).children('img.show_if_mobile').length == 1 && $(this).children('img.hide_if_mobile').length == 1))
		{
			$(this).addClass('has_one_image');
		}
	});
});