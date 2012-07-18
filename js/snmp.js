$('#action-create').click(function() {
	$.get($(this).attr('href'),function(data) {
		$('#modal-create .modal-header').html("<h2>Create Credentials</h2>");
		$('#modal-create-body').html(data);
		$('#create').attr('href',$('#action-create').attr('href'));
		$('#modal-create').modal('show');
	});
	return false;
});

$('#modal-create #create').click(function() {
     var dataStr = $('#create-form').serialize();
     var url = $('#create').attr('href');
     $.post(url,dataStr,function(data) {
          handlePostRefresh(data);
     });
     return false;
});

$('#action-modify').click(function() {
	$.get($(this).attr('href'),function(data) {
          $('#modal-modify .modal-header').html("<h2>Modify Credentials</h2>");
          $('#modal-modify-body').html(data);
          $('#save').attr('href',$('#action-modify').attr('href'));
          $('#modal-modify').modal('show');
     });
     return false;
});

$('#action-reload').click(function() {
	$.get($(this).attr('href'),function(data) {
		handlePostRefresh(data);
	});
	return false;
});
