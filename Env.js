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
	const name = Env.localName()

	if (Check.name == name) return //Ничего не поменялось или запрос вернёт тот же результат из кэша
	//const json = (await import('/-env/?-env=' + name + '&t='+ Date.now())).default || {}
	const response = await fetch('/-env/?-env=' + name)
	if (!response.ok) return
	const json = await response.json();
	if (Check.name == json.name) return //Ничего не поменялось
	Check.data = json.data || {}
	Check.name = json.name || ''
	Env.emit('change')
}

export { Env }