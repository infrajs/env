<?php

namespace infrajs\env;

use infrajs\mark\BuildData;
use infrajs\ans\Ans;
use infrajs\view\View;
use infrajs\nostore\Nostore;
//use infrajs\router\Router;
use infrajs\sequence\Sequence;



class Env
{
	public static $defined = false;
	public static $name = null;
	public static $data = null;
	public static $props = array();
	public static function json()
	{
		$ar = array(
			'name'=> Env::$name,
			'data'=> Env::$data
		);
		return json_encode($ar);
	}
	public static function add($name, $fndef, $fncheck)
	{
		Env::$props[$name] = array('fndef' => $fndef, 'fncheck' => $fncheck);
	}
	public static function is()
	{
		return static::$defined;
	}
	public static function localName() 
	{
		$origname = Ans::GET('-env');
		if (is_null($origname)) $origname = View::getCookie('-env');
		return $origname;
	}
	public static function init() //Запускается только один раз
	{
		//if (!Router::$main) Nostore::on(); 
		//Нельзя обращаться к окружению в независимых скриптах у которых нет редиректа для public кэша

		$origname = Env::localName();

		$res = BuildData::init(Env::$props, $origname);
		
		$data = $res['data'];
		$name = $res['name'];

		Env::$name = $name;
		if (Env::$name) {
			Env::$defined = true;
			View::setCookie('-env', Env::$name);
		} else {
			View::setCookie('-env'); //Куки выставлять не обязательно
		}
		Env::$data = $data;
	}
	public static function get($prop = '')
	{
		if (is_null(Env::$data)) {
			$r = false;
			if (isset($_GET[$prop])) $val = (string) $_GET[$prop];
			else $val = '';
			if (Env::$props[$prop]) {
				if ($val !== '') $r = Env::$props[$prop]['fncheck']($val);
				if (!$r) $val = Env::$props[$prop]['fndef']();
			}
			return $val;
		}
		$data = Env::$data;
		if (!$prop) return $data;
		$right = array($prop);
		return Sequence::get($data, $right);
	}
	public static function getName()
	{
		return Env::$name;
	}
}
// Env::add('nostore', function () {
// 	return '';
// }, function ($newval) {
// 	return in_array($newval, array('1'));
// });

/*
Пример
Env::add('region', function fndef () {
	return 'samara';
}, function fncheck ($newval) {
	return in_array($newval, array('togliatti','samara','syzran'));
});
*/