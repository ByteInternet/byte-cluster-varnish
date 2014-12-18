jQuery(function() {
	document.formvalidator.setHandler('terebinthhost',
		function (value) {
            regex1=/^([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])(\.([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]))*(:[0-9]{2,5})?$/;
            regex2=/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(:[0-9]{2,5})?$/;
			return ( ( regex1.test(value) || regex2.test(value) ) );
	});
});

