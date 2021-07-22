
import { Fire } from '/vendor/akiyatkin/load/Fire.js'

let Env = {...Fire }

Env.fromCookie = () => {
	var env = document.cookie.match('(^|;)?\-env=([^;]*)(;|$)')
	if (env) env = decodeURIComponent(env[2])
	if (env == 'deleted') env = ''
	return env
}
Env.fromGET = () => {
	let r = location.search.match('[\?|&]\-env=([^&]+)')
	if (r) return decodeURIComponent(r[1])
}

Env.check = env => {
	if (!env) env = {}
	Env.data = env.data || {}
	Env.name = env.name || ''
	
	let getname = Env.fromGET()
	if (getname) { //Если env установлен в адресе, то готово. Кэш такого адреса всегда по правильному окружению.
		document.cookie = "-env=" + encodeURIComponent(getname) + "; path=/; SameSite=Strict ";
		return
	}
	let cookiename = Env.fromCookie()
	if (!cookiename) return; //Если нет cookie то подходит любой
	if (Env.name == cookiename) return;
	//В cookie уже новый name - надо редиректить 
	//При редиректе сервер проверит имя и скорректирует его если требуется в Env.init()
	
	if (location.search) { 
		location.replace(location.search + '&-env=' + cookiename)
	} else {
		location.replace('?-env=' + cookiename)
	}
}

Env.get = prop => {
	if (!prop) return Env.data
	return Env.data[prop]
}
Env.getName = prop => {
	return Env.name
}


Env.localName = () => {
	let name = Env.fromGET()
	if (!name) name = Env.fromCookie()
	if (!name) name = ''
	return name
}
Env.refresh = async () => {
	let name = Env.localName()
	if (Env.name == name) return //Ничего не поменялось или запрос вернёт тот же результат из кэша
	let json = (await import('/-env/?-env=' + name)).default || {}
	if (Env.name == json.name) return //Ничего не поменялось
	Env.data = json.data || {}
	Env.name = json.name || ''
	
	await Env.emit('change')
}

//Env.after('change', () => DOM.puff('check'))

window.Env = Env
export { Env }