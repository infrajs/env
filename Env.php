<?php
namespace infrajs\env;

use infrajs\mark\Mark;
use infrajs\ans\Ans;
use infrajs\once\Once;
use infrajs\view\View;
use infrajs\nostore\Nostore;
use infrajs\router\Router;
use infrajs\sequence\Sequence;

class Env {
	public static $defined = false;
	public static $mark = false; //Определяется в Env::init() - нужно выполнять на сервере если требуется работа с окружением
	public static $list = array();
	public static function add($name, $fndef, $fncheck)
	{
		Env::$list[$name] = array('fndef' => $fndef, 'fncheck' => $fncheck);
	}
	public static function is()
	{
		return static::$defined;
	}
	public static function init()
	{
		if (Env::$mark) return;

		if (!Router::$main) Nostore::on(); //Нельзя обращаться к окружению в независимых скриптах у которых нет редиректа для public кэша

		$mark = new Mark('~auto/.env/');
		foreach (Env::$list as $name => $v) {
			$mark->add($name, $v['fndef'], $v['fncheck']);
		}
	
		$origname = Ans::GET('-env');
		if (is_null($origname)) $origname = View::getCookie('-env');
		$mark->setVal($origname);
		if ($origname) {
			static::$defined = true;
			$name = $mark->getVal();
			View::setCookie('-env', $name);
		} else if (!is_null($origname)) {
			View::setCookie('-env'); //Куки выставлять не обязательно
		}
		Env::$mark = $mark;
	}
	public static function get($prop = '')
	{
		$data = Env::$mark->getData();
		if(!$prop) return $data;
		$right = array($prop);
		return Sequence::get($data, $right);
	}
	public static function name()
	{
		return Env::$mark->getVal();		
	}
}
/*
Пример
Env::add('region', function () {
	return 'samara';
}, function ($newval) {
	return in_array($newval, array('togliatti','samara','syzran'));
});
*/