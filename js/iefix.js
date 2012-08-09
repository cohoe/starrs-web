// The only reason this is here is because IE8 is retarded and doesnt actually do anything when you click the buttons.
// By using JavaScript to do the link, the browser actually responds. It has something to do with the <button> class.
// I hate IE. Die in a fire.
$('.imp-actionbtn').click(function() {
	window.location.href($(this).parent().attr('href'));
});
