( function () {
	var first = true;

	Template.scope['Env'] = {};
	Template.scope['Env']['get'] = function (name) { return Env.get(name) };
	Template.scope['Env']['name'] = function () { return Env.name(); };
	Template.scope['Env']['is'] = function () { return Env.is(); };
	
	Controller.parsedAdd(function(layer){
		//Можно получить список вызываемых в шаблоне функций и точней определить зависит слой или нет от окружения
		//Но есть ещё другие расширения Region Lang
		if (!layer.data&&!layer.json) return '';
		return Env.name()+(Env.is()?'1':'0');
	});
})();