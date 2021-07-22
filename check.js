(function(){
	var env = location.search.match('[\?|&]\-env=([^&]+)');
	if (env) env = env[1];
	if (env) { //Если env установлен в адресе, то готово. Кэш такого адреса всегда по правильному окружению.
		document.cookie = "-env=" + env + "; Path=/; SameSite=Strict";
		return;
	}
	var env = document.cookie.match('(^|;)?\-env=([^;]*)(;|$)');	
	if (env) env = env[2];
	if (!env) return;

	if (env != window.ENVcontent) {
		if (location.search) {
			location.replace(location.search + '&-env=' + env);
		} else {
			location.replace('?-env=' + env);
		}
	}
})();