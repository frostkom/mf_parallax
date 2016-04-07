jQuery(function($)
{
	wp.customize('blogname', function(value)
	{
		value.bind(function(newval)
		{
			$('#site-title a').html(newval);
		});
	});
});