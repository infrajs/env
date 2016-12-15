<?php
use infrajs\event\Event;
use infrajs\view\View;
use infrajs\env\Env;
use infrajs\load\Load;

Event::one('Controller.onshow', function () {

	$html = '<script>window.ENVcontent="'.Env::getName().'";';
	$html .= Load::loadTEXT('-env/check.js');
	$html .= '</script>';
	View::head($html, true);

});
