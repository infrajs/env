
window.Env = {};
 
Env.name = function () {
	Env.refresh();
	return window.ENVcontent;
};
Env.is = function () {
	var env = document.cookie.match('(^|;)?\-env=([^;]*)(;|$)');	
	if (env) env = env[2];
	return env;
};
Env.refresh = function () {
	var val = Env.is();
	if (Crumb.get && (Crumb.get['-env'] || Crumb.get['-env'] == '')) {
		val = Crumb.get['-env'];
	}
	if (!val) val = '';
	if (!window.ENVdata) window.ENVdata = {};
	if (Env.data.get == val) return;
	var src = '-env/?-env='+val;
	Load.unload(src);
	var data = Load.loadJSON(src);
	Env.data = data;
	window.ENVdata = data.env;
	window.ENVcontent = data.name;
},
Env.get = function (name) {
	Env.refresh();
	if (!name) return window.ENVdata;
	return window.ENVdata[name];
}
Env.init = function () {
	Env.data = {};
	var env = location.search.match('[\?|&]\-env=([^&]+)');
	if (env) env = env[1];
	if (env) Env.data.get = Env;
	else Env.data.get = '';
	Env.data.env = window.ENVdata;
	Env.data.name = window.ENVcontent;
}
Env.init();
