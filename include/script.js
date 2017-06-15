document.createElement("header");
	document.createElement("nav");
/*document.createElement("mf-pre-content");*/
document.createElement("mf-content");
	document.createElement("section");
	document.createElement("article");
document.createElement("footer");

jQuery(function($)
{
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