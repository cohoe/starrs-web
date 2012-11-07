$('#action-remove').click(function() {
	$(this).addClass("disabled");
	$('#modal-confirm-btn').attr('href',$('#remove').attr('href'));
	$('#modal-confirm').modal('show');
	return false;
});

//$('#modal-confirm-btn').click(function() {
//	console.debug('This function needs to die');
//	$('#modal-confirm').modal('show',false);
//	$.post($('#remove').attr('href'),{ confirm:"confirm" },function(data) {
//		if(!data.match(/^\<script\>/g)) {
//			$('#modal-error-body').html(data);
//			$('#modal-error').modal('show');
//		}
//		else {
//			$(this).html($('#remove').html() + data);
//		}
//	});
//	return false;
//});

$('#action-renewall').click(function() {
	$(this).addClass("disabled");
	$('#action-renewall .btn').addClass('disabled');
	$.get($(this).attr('href'),function(data) {
		$('#modal-info .modal-header').html("<h1>"+$('#action-renew').text()+"</h1>");
		$('#modal-info-body').html(data);
		$('#modal-info').modal('show');
		$('#modal-info .modal-footer .btn').click(function() {
			document.location.reload(true);
		});
	});
	return false;
});

$('.renew').unbind('click');
$('.renew').click(function() {
	$(this).addClass("disabled");
	$.get($(this).attr('href'),function(data) {
		$('#modal-info .modal-header').html("<h1>"+$('#action-renew').text()+"</h1>");
		$('#modal-info-body').html(data);
		$('#modal-info').modal('show');
		$('#modal-info .modal-footer .btn').click(function() {
			document.location.reload(true);
		});
	});
	return false;
});

$('#action-renew').click(function() {
	$(this).addClass("disabled");
	$.get($(this).attr('href'),function(data) {
		$('#modal-info .modal-header').html("<h1>"+$('#action-renew').text()+"</h1>");
		$('#modal-info-body').html(data);
		$('#modal-info').modal('show');
		$('#modal-info .modal-footer .btn').click(function() {
			document.location.reload(true);
		});
	});
	return false;
});

$('[name=range]').change(function() {
	if($(this).val()) {
		$.post("/address/getfromrange",{range:$(this).val()},function(data) {
			if(data.match(/ERROR/)) {
				$('#modal-error-body').html(data);
				$('#modal-error').modal('show');
			}
			else {
				$('[name=address]').val(data);
				$('[name=address]').parent().parent().removeClass('error');
			}
		});
	} else {
		$('[name=address]').val("");
		$('[name=address]').parent().parent().addClass('error');
		
	}
});

$('[name=address]').change(function() {
	$.post("/address/getrange",{address:$(this).val()},function(data) {
		if(data.match(/ERROR/)) {
			$('#modal-error-body').html(data);
			$('#modal-error').modal('show');
		}
		else {
			$('[name=range]').val(data);
			$('[name=range]').parent().parent().removeClass('error');
		}
	});
});

$('#random-mac').click(function() {
	$.get("/interfaces/randommac",function(data) {
		$('[name=mac]').val(data);
		$('[name=mac]').parent().parent().removeClass('error');
		$('#mac-warning').removeClass('hidden');
	});
	return false;
});
