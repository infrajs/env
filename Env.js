import { Fire } from '/vendor/akiyatkin/load/Fire.js'
import { Check } from '/vendor/infrajs/env/Check.js'

const Env = {...Fire }
Env.get = prop => {
	if (!prop) return Check.data
	return Check.data[prop]
}
Env.getName = prop => {
	return Check.name
}


Env.localName = () => {
	let name = Check.fromGET()
	if (!name) name = Check.fromCookie()
	if (!name) name = ''
	return name
}
Env.refresh = async () => {
	let name = Env.localName()
	if (Check.name == name) return //Ничего не поменялось или запрос вернёт тот же результат из кэша
	let json = (await import('/-env/?-env=' + name + '&t='+ Date.now())).default || {}
	if (Check.name == json.name) return //Ничего не поменялось
	Check.data = json.data || {}
	Check.name = json.name || ''
	
	await Env.emit('change')
}

//Env.after('change', () => DOM.puff('check'))

window.Env = Env
export { Env }