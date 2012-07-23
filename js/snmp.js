$('#action-create').click(function() {
	$.get($(this).attr('href'),function(data) {
		$('#modal-create .modal-header').html("<h2>Create Credentials</h2>");
		$('#modal-create-body').html(data);
		$('#create').attr('href',$('#action-create').attr('href'));
		$('#modal-create').modal('show');
	});
	return false;
});

$('#modal-create #create').unbind('click');
$('#modal-create #create').click(function() {
console.debug('lolol');
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
	$('#modal-info-body').html('Loading data from device. This can take a while.<br /><br /><div class="progress active"><div class="bar" style="width: 0%;"></div></div>');
	$('#modal-info .modal-footer').html('');
	$('#modal-info').modal('show');
	pgBar();
	$.get($(this).attr('href'),function(data) {
		handlePostRefresh(data);
		$('#modal-info').modal('hide');
	});
	return false;
});

$('#action-reloadall').click(function() {
	$('#modal-info-body').html('Loading data from device. This can take a while.<br /><br /><div class="progress active"><div class="bar" style="width: 0%;"></div></div>');
	$('#modal-info .modal-footer').html('');
	$('#modal-info').modal('show');
	pgBar();
	return false;
});

function pgBar() {
	var width = 0;
	var pG = setInterval(function() {
		if(width == 100) {
			width = 0;
			// clearInterval(pG);
		} else {
			$('#modal-info-body .bar').css('width',(width + 1)+'%');
			width += 1;
		}
	},300);
}

$('.switchport-link').click(function() {
	$.get($(this).attr('href'),function(data) {
		$('#modal-info-body').html(data);
		$('#modal-info').modal('show');
	});
	return false;
});

$('.switchport-div').click(function() {
	var ifId = $(this).attr('id');
	$.get($('#'+ifId+'-a').attr('href'),function(data) {
		$('#modal-info-body').html(data);
		$('#modal-info').modal('show');
	});
	return false;
});
