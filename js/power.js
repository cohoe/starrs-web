$('#action-power').click(function() {
     $('#action-power .btn-warning').addClass("disabled");
     $.get($(this).attr('href'),function(data) {
          $('#modal-select-body').html(data);
          $('#modal-select').modal('show');
     });
     return false;
});

$('#execute').click(function() {
     $(this).addClass("disabled");
	$('#modal-loading').modal('show');
	$.post($('#action-power').attr('href')+"/"+$('[name=action]').val(),function(data) {
		handlePostRefresh(data);
	});
	return false;
});
