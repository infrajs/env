<?php
use infrajs\event\Event;
use infrajs\view\View;
use infrajs\env\Env;
use infrajs\load\Load;
use infrajs\once\Once;
use infrajs\template\Template;
use infrajs\controller\Controller;
use infrajs\nostore\Nostore;
use infrajs\router\Router;
use infrajs\controller\Layer;
		


Event::handler('Controller.oninit', function (&$layer) {
	Template::$scope['Env'] = array();
	Template::$scope['Env']['get'] = function ($prop = false) {
		return Env::get($prop);
	};
	Template::$scope['Env']['getName'] = function () {
		return Env::getName();
	};
});
