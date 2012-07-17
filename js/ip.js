// IP - Subnet - Create DHCP Option
$('#action-createdhcpoption').click(function() {
	$.get($(this).attr('href'),function(data) {
		$('#modal-create .modal-header').html("<h2>Create Option</h2>");
		$('#modal-create-body').html(data);
		$('#create').attr('href',$('#action-createdhcpoption').attr('href'));
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

$('#action-adduser').click(function() {
	$.get($(this).attr('href'),function(data) {
		$('#modal-create .modal-header').html("<h2>Add User</h2>");
		$('#modal-create-body').html(data);
		$('#create').attr('href',$('#action-adduser').attr('href'));
		$('#modal-create').modal('show');
	});
	return false;
});
