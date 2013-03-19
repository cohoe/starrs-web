//$('[name=submit]').click(function() {
//	console.debug('Hi!');
//	var str1 = $("#search-form").serialize();
//	var str2 = $("#field-form").serialize();
//	$('#search-form fieldset').append("<field type=hidden name=fields value=\""+str2+"\" />");
//	$('[name=datacenter]').val("lolz");
//});

$('#search-form').submit(function() {
	$('[name=datacenter]').val("lolz");
	//	$('[name=datacenter]').val("lolz");
	var input = $("<input>").attr("type", "hidden").attr("name", "fields").val($('#field-form').serialize());
	$('#search-form').append($(input));
});

$('#f-all').click(function() {
	$('[name=fields]').each(function() {
		$(this).attr('checked','checked');
	});
	return false;
});
$('#f-none').click(function() {
	$('[name=fields]').each(function() {
		$(this).removeAttr('checked');
	});
	return false;
});
$('#f-def').click(function() {
	$('[name=fields]').each(function() {
		$(this).removeAttr('checked');
	});
	$('[value=datacenter]').attr('checked','checked');
	$('[value=system_name]').attr('checked','checked');
	$('[value=mac]').attr('checked','checked');
	$('[value=address]').attr('checked','checked');
	$('[value=system_owner]').attr('checked','checked');
	$('[value=range]').attr('checked','checked');
	return false;
});
