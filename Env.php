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
	public static $list = array();
	public static function add($name, $fndef, $fncheck)
	{
		Env::$list[$name] = array('fndef' => $fndef, 'fncheck' => $fncheck);
	}
	public static function is()
	{
		$mark = static::mark();
		return static::$defined;
	}
	public static function mark()
	{
		$mark = &Once::exec(__FILE__, function () {
			if (!Router::$main) Nostore::on(); //Нельзя обращаться к окружению в независимых скриптах);
			$mark = new Mark('~auto/.env/');
			foreach (Env::$list as $name => $v) {
				$mark->add($name, $v['fndef'], $v['fncheck']);
			}
			return $mark;
		});
		Once::exec(__FILE__."init", function () use (&$mark) { //Здесь может повторно вызываться mark по этому вынесено отедльно
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
		});
		return $mark;
	}
	public static function get($prop = '')
	{
		$mark = static::mark();
		$data = $mark->getData();
		if(!$prop) return $data;
		$right = array($prop);
		return Sequence::get($data, $right);
	}
	public static function name()
	{
		$mark = static::mark();
		return $mark->getVal();		
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