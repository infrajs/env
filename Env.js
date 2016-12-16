window.Env = {
	getName: function () {
		return window.ENVcontent;
	},
	get: function (name) {
		if (!name) return window.ENVdata;
		return window.ENVdata[name];
	}
}
Template.scope['~env'] = Env.get();