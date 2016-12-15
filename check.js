(function(){
	var env = document.cookie.match('(^|;)?\-env=([^;]*)(;|$)');
	if (env) env = env[2];
	if (!env) return;
	if (env != window.ENVcontent) {
		if (location.search) {
			if (/\-env=/.test(location.search)) return;
			location.reload(true);
			location.replace(location.search + '&-env='+env);
		} else {
			location.reload(true);
			location.replace('?-env='+env);
		}
	}
})();