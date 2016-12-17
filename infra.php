<?php
use infrajs\event\Event;
use infrajs\view\View;
use infrajs\env\Env;
use infrajs\load\Load;
use infrajs\once\Once;
use infrajs\template\Template;
use infrajs\nostore\Nostore;

Event::handler('Controller.oninit', function (&$layer) {
	Template::$scope['Env'] = array();
	Template::$scope['Env']['get'] = function ($name = false) {
		return Env::get($name);
	};
	Template::$scope['Env']['getName'] = function () {
		return Env::getName();
	};
	Template::$scope['Env']['is'] = function () {
		return Env::is();
	};
});

Event::handler('Layer.onshow', function (&$layer) {
	if (empty($layer['environment'])) return;
	Once::exec(__FILE__, function () {
		$data = Env::get();
		$data = Load::json_encode($data);
		$html = '<script>window.ENVcontent="'.Env::getName().'";window.ENVdata='.$data.';';
		$html .= Load::loadTEXT('-env/check.js');
		$html .= '</script>';
		View::head($html, true);	
	});
});
