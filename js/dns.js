// Create button on the main page to start the process of creating a record
$('#create').click(function() {
	$.get("/dns/record/create/",function(data) {
		$('#modal-select-body').html(data);
		$('#modal-select').modal('show');
	});
	return false;
});

// Click after selecting a record type from the dropdown in the popup
$('#continue').click(function() {
	var createUrl = "/dns/"+$('[name=rectype]').val().toLowerCase()+"/create";
	$.get(createUrl,function(data) {
		$('#createrec').attr('href',createUrl);
		$('#modal-select-body').html(data);
		$('#continue').addClass('hide');
		$('#createrec').removeClass('hide');
	});
});

// Close the popup and return classes to their defaults
$('#cancel').click(function() {
	$('#continue').removeClass('hide');
	$('#createrec').addClass('hide');
});

// Click the button to create a record
$('#createrec').click(function() {
	var dataStr = $('#create-form').serialize();
	dataStr = dataStr+"&address="+getIpFromUrl();
	var url = $('#createrec').attr('href');
	console.debug(url);
	$.post(url,dataStr,function(data) {
		handlePost(data);	
	});
	$('#continue').removeClass('hide');
	$('#createrec').addClass('hide');
	return false;
});

// Click save to modify a record
$('#save').click(function() {
	var dataStr = $('#modify-form').serialize();
	$.post($(this).attr('href'),dataStr,function(data) {
		handlePost(data);
	});
	return false;
});

// Remove buttons on the main page
$('.btn-danger').click(function() {
	var url = $(this).parent().attr('href');
	$('#modal-confirm-btn').attr('href',url);
	$('#modal-confirm').modal('show');
	return false;
});

// Info button on the main page
$('.btn-info').click(function() {
	var url = $(this).parent().attr('href');
	$.get(url,function(data) {
		$('#modal-info .modal-header').html("<h2>Record Detail</h2>");
		$('#modal-info-body').html(data);
		$('#modal-info').modal('show');
	});
	return false;
});

// Modify button on the main page
$('.btn-warning').click(function() {
	var url = $(this).parent().attr('href');
	$.get(url,function(data) {
		$('#modal-modify-body').html(data);
		$('#save').attr('href',url);
		$('#modal-modify').modal('show');
	});
	return false;
});

// Confirm to remove the record
$('#modal-confirm-btn').click(function() {
	$.post($(this).attr('href'),{confirm:"confirm"},function(data) {
		handlePost(data);
	});
	return false;
});

function getIpFromUrl() {
	return window.location.pathname.split('/').pop();
}
