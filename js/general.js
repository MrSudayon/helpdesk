$(document).ready(function(){
	var urlPath = window.location.pathname,
    urlPathArray = urlPath.split('.'),
    tabId = urlPathArray[0].split('/').pop();
	$('#subject, #department, #user, #ticket, #introduction, #tutorials').removeClass('active');	
	$('#'+tabId).addClass('active');
});
