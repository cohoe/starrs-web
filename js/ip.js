$('#createdhcpoption').click(function() {
	$.get($(this).attr('href'),function(data) {
		$('#modal-create-body').html(data);
		$('#create').attr('href',$('#createdhcpoption').attr('href'));
		$('#modal-create').modal('show');
	});
	return false;
});

$('#create').click(function() {
	var dataStr = $('#create-form').serialize();
	var url = $('#create').attr('href');
	$.post(url,dataStr,function(data) {
		handlePost(data);
	});
	return false;
});
