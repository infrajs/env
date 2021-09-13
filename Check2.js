const Check = {
	fromCookie: () => {
		var env = document.cookie.match('(^|;)?\-env=([^;]*)(;|$)')
		if (env) env = decodeURIComponent(env[2])
		if (env == 'deleted') env = ''
		return env
	},
	fromGET: () => {
		let r = location.search.match('[\?|&]\-env=([^&]+)')
		if (r) return decodeURIComponent(r[1])
	},
	init: env => {
		if (!env) env = {}
		Check.data = env.data || {}
		Check.name = env.name || ''
		
		let getname = Check.fromGET()
		if (getname) { //Если env установлен в адресе, то готово. Кэш такого адреса всегда по правильному окружению.
			document.cookie = "-env=" + encodeURIComponent(getname) + "; path=/; SameSite=Strict ";
			return
		}
		let cookiename = Check.fromCookie()
		if (!cookiename) return; //Если нет cookie то подходит любой
		if (Check.name == cookiename) return;
		//В cookie уже новый name - надо редиректить 
		//При редиректе сервер проверит имя и скорректирует его если требуется в Check.init()
		
		if (location.search) { 
			location.replace(location.search + '&-env=' + cookiename)
		} else {
			location.replace('?-env=' + cookiename)
		}
	}
}

export { Check }