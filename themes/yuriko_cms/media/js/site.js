$(document).ready(function(){
	var height = $('#content_container').height();
	if (height < 430)
	{
		var gutter = $('#gutter').height();
		$('#content_container').height(0);
		$('#gutter').height(gutter);
	}
	else
	{
		$('#content_container').height($('#content_container').height() - 430);
	}
});