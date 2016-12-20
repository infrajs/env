<?php
use infrajs\event\Event;
use infrajs\view\View;
use infrajs\env\Env;
use infrajs\load\Load;
use infrajs\once\Once;
use infrajs\template\Template;
use infrajs\nostore\Nostore;
use infrajs\controller\Layer;

Event::handler('Controller.oninit', function (&$layer) {
	Template::$scope['Env'] = array();
	Template::$scope['Env']['get'] = function ($name = false) {
		return Env::get($name);
	};
	Template::$scope['Env']['name'] = function () {
		return Env::name();
	};
	Template::$scope['Env']['is'] = function () {
		return Env::is();
	};
	Layer::parsedAdd( function ($layer) {
		if (empty($layer['data'])&&empty($layer['json'])) return '';
		return Env::name().(Env::is()?'1':'0');
	});
});

Event::handler('Layer.onshow', function (&$layer) {
	if (empty($layer['environment'])) return;
	Once::exec(__FILE__, function () {
		$data = Env::get();
		$data = Load::json_encode($data);
		$html = '<script>window.ENVcontent="'.Env::name().'";window.ENVdata='.$data.';';
		$html .= Load::loadTEXT('-env/check.js');
		$html .= '</script>';
		View::head($html, true);	
	});
});
