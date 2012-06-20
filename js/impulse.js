function setViewUser(inputUser) {
	var user;
	if(!inputUser) {
		user = document.getElementById("viewuser").value;
	}
	else {
		user = inputUser
	}

	// All actually means null
	if(user == "all") {
		user = '';
	}
	setViewUserCookie(user);
	window.location.href = '/systems/view/' + user;
}

function setViewUserCookie(value) {
	var c_value=escape(value);
	document.cookie='impulse_viewUser' + "=" + c_value + "; path=/";
}

function getViewUserFromCookie() {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) {
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		return unescape(y);
	}
}

function setViewUserSelect() {
	var i;
	var options = document.getElementById("viewuser").options;
	var viewUser = getViewUserFromCookie();
	if(viewUser == '') {
		return;
	}
	for(i=0; i<options.length; i++) {
		if(options[i].value == viewUser) {
			document.getElementById("viewuser").selectedIndex = i;
		}
	}
}

function bodyLoad() {
	setViewUserSelect();
}
