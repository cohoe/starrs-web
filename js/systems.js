$('#remove').click(function() {
	$('#modal-confirm-btn').attr('href',$('#remove').attr('href'));
	$('#modal-confirm').modal('show');
	return false;
});

$('#modal-confirm-btn').click(function() {
	console.debug("lol");
	$('#modal-confirm').modal('show',false);
	$.post($('#remove').attr('href'),{ confirm:"confirm" },function(data) {
		if(!data.match(/^\<script\>/g)) {
			$('#modal-error-body').html(data);
			$('#modal-error').modal('show');
		}
		else {
			$(this).html($('#remove').html() + data);
		}
	});
	return false;
});

$('#renew').click(function() {
	$.get($(this).attr('href'),function(data) {
		$('#modal-info .modal-header').html("<h1>"+$('#renew').text()+"</h1>");
		$('#modal-info-body').html(data);
		$('#modal-info').modal('show');
		$('#modal-info .modal-footer .btn').click(function() {
			document.location.reload(true);
		});
	});
	return false;
});

$('[name=range]').change(function() {
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
