// IP - Subnet - Create DHCP Option
$('#action-createdhcpoption').click(function() {
	$(this).addClass("disabled");
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
	$(this).addClass("disabled");
	$.post(url,dataStr,function(data) {
		handlePostRefresh(data);
	});
	return false;
});

$('#action-adduser').click(function() {
	$(this).addClass("disabled");
	$.get($(this).attr('href'),function(data) {
		$('#modal-create .modal-header').html("<h2>Add User</h2>");
		$('#modal-create-body').html(data);
		$('#create').attr('href',$('#action-adduser').attr('href'));
		$('#modal-create').modal('show');
	});
	return false;
});

$('[name=datacenter]').change(function() {
	var datacenter = $('[name=datacenter] option:selected').text();
	$.get("/network/vlans/view/"+datacenter,function(data) {
		var vlans = data.split(":");
		vlans.pop();
		$('[name=vlan]').empty();
		for(var i=0; i<vlans.length; i++) {
			$('[name=vlan]').append("<option>"+vlans[i]+"</option>");
		}
		if($('[name=vlan]').attr('value') != "") {
			$('[name=vlan]').parent().parent().removeClass("error");
		} else {
			$('[name=vlan]').parent().parent().addClass("error");
		}
	});
});
