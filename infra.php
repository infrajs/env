<?php
use infrajs\event\Event;
use infrajs\view\View;
use infrajs\env\Env;
use infrajs\load\Load;
use infrajs\once\Once;
use infrajs\template\Template;
use MatthiasMullie\Minify;
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
	/*Layer::parsedAdd( function ($layer) {
		if (empty($layer['data'])&&empty($layer['json'])) return '';
		return Env::name().(Env::is()?'1':'0');
	});*/
});

Event::handler('Layer.onshow', function (&$layer) {
	if (empty($layer['environment'])) return;
	Once::func( function () {
		$data = Env::get();
		$data = Load::json_encode($data);
		$html = '<script>';
		$code = 'window.ENVcontent="'.Env::name().'";window.ENVdata='.$data.';';
		$code .= Load::loadTEXT('-env/check.js');
		$min = new Minify\JS($code);
		$code = $min->minify();
		$html .= $code;
		$html .= '</script>';
		View::head($html, true);	
	});
},'ENV:tpl');
