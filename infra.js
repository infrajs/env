import { DOM } from '/vendor/akiyatkin/load/DOM.js'
import { Env } from "/vendor/infrajs/env/Env.js"

//Расширяем Template с первым check
DOM.once('check', async () => {
	await import('./init.js')
})

//C каждым check проверяем изменения (могло быть в адресе get или в соседней вкладке в cookie)
DOM.before('check', async () => {
	await Env.refresh()
})