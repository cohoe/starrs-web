// IP - Subnet - Create DHCP Option
$('#action-create').click(function() {
	$(this).addClass("disabled");
	$.get($(this).attr('href'),function(data) {
		$('#modal-create .modal-header').html("<h2>Create Configuration Directive</h2>");
		$('#modal-create-body').html(data);
		$('#create').attr('href',$('#action-create').attr('href'));
		$('#modal-create').modal('show');
	});
	return false;
});

$('#modal-create #create').unbind('click');
$('#modal-create #create').click(function() {
	$(this).addClass("disabled");
	var dataStr = $('#create-form').serialize();
	var url = $('#create').attr('href');
	$.post(url,dataStr,function(data) {
		handlePostRefresh(data);
	});
	return false;
});
