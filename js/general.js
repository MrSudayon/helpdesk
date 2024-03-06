$(document).ready(function(){
	var urlPath = window.location.pathname,
    urlPathArray = urlPath.split('.'),
    tabId = urlPathArray[0].split('/').pop();
	$('#department, #user, #ticket, #purchase').removeClass('active');	
	$('#'+tabId).addClass('active');
});