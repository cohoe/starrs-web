// Create button on the main page to start the process of creating a record
$('#action-create').click(function() {
	$(this).addClass("disabled");
	$.get($(this).attr('href'),function(data) {
		$('#modal-select-body').html(data);
		$('#modal-select').modal('show');
	});
	return false;
});

$('#action-createaddress').click(function() {
	$(this).addClass("disabled");
	$.get("/dns/zonea/create/"+getObjectFromUrl(),function(data) {
		$('#modal-select-body').html(data);
		$('#continue').addClass('hide');
		$('#createrec').removeClass('hide');
		$('#createrec').attr('href',$('#action-createaddress').attr('href'));
		$('#modal-select').modal('show');
	});
	return false;
});

$('#action-createtxt').click(function() {
	$(this).addClass("disabled");
	$.get("/dns/zonetxt/create/"+getObjectFromUrl(),function(data) {
		$('#modal-select-body').html(data);
		$('#continue').addClass('hide');
		$('#createrec').removeClass('hide');
		$('#createrec').attr('href',$('#action-createtxt').attr('href'));
		$('#modal-select').modal('show');
	});
	return false;
});

// NS
$('#action-createns').click(function() {
	$(this).addClass("disabled");
	$.get($(this).attr('href'),function(data) {
		$('#modal-select-body').html(data);
		$('#continue').addClass('hide');
		$('#createrec').removeClass('hide');
		$('#createrec').attr('href',$('#action-createns').attr('href'));
		$('#modal-select').modal('show');
	});
	return false;
});

// Click after selecting a record type from the dropdown in the popup
$('#continue').click(function() {
	$(this).addClass("disabled");
	var createUrl = "/dns/"+$('[name=rectype]').val().toLowerCase()+"/create/"+$('[name=address]').val();
	$.get(createUrl,function(data) {
		$('#createrec').attr('href',createUrl);
		$('#modal-select-body').html(data);
		$('#continue').addClass('hide');
		$('#createrec').removeClass('hide');
	});
});

// Close the popup and return classes to their defaults
$('#cancel').click(function() {
	$(this).addClass("disabled");
	$('#continue').removeClass('hide');
	$('#createrec').addClass('hide');
});

// Click the button to create a record
$('#createrec').click(function() {
	$(this).addClass("disabled");
	var dataStr = $('#create-form').serialize();
	var url = $('#createrec').attr('href');
	$.post(url,dataStr,function(data) {
		handlePostRefresh(data);	
	});
	return false;
});

// Hax for zone
$('#modifyzone .btn-warning').unbind('click');

function getObjectFromUrl() {
	return window.location.pathname.split('/').pop();
}

function getSchemaFromUrl() {
	window.location.pathname.split('/')[1];
}
