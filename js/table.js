// Table Data - Detail Button
$('td .btn-info').click(function() {
	var url = $(this).parent().attr('href');
	$.get(url, function(data) {
		$('#modal-info .modal-header').html("<h2>Detail</h2>");
		$('#modal-info-body').html(data);
		$('#modal-info').modal('show');
	});
	return false;
});

// Table Data - Modify Button
$('td .btn-warning').click(function() {
	var url = $(this).parent().attr('href');
	$.get(url, function(data) {
		$('#modal-modify .modal-header').html("<h2>Modify</h2>");
		$('#modal-modify-body').html(data);
		$('#save').attr('href',url);
		$('#modal-modify').modal('show');
	});
	return false;
});

// Table Data - Remove Button
$('td .btn-danger').click(function() {
	var url = $(this).parent().attr('href');
	$('#modal-confirm-btn').attr('href',url);
	$('#modal-confirm').modal('show');
	return false;
});
