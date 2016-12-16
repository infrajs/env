<?php
namespace infrajs\env;

use infrajs\mark\Mark;
use infrajs\ans\Ans;
use infrajs\once\Once;
use infrajs\view\View;
use infrajs\sequence\Sequence;

class Env {
	public static $defined = false;
	public static $list = array();
	public static function add($name, $fndef, $fncheck)
	{
		Env::$list[$name] = array('fndef' => $fndef, 'fncheck' => $fncheck);
	}
	public static function mark()
	{
		return Once::exec(__FILE__, function () {
			$mark = new Mark('~.env/');
			foreach (Env::$list as $name => $v) {
				$mark->add($name, $v['fndef'], $v['fncheck']);
			}
			$origname = Ans::GET('-env');
			if (!$origname) $origname = View::getCookie('-env');
			$mark->setVal($origname);
			if ($origname) {
				static::$defined = true;
				$name = $mark->getVal();
				View::setCookie('-env', $name);
			}
			return $mark;
		});
	}
	public static function init()
	{	
		$mark = static::mark();
	}
	public static function get($prop = '')
	{
		$mark = static::mark();
		$data = $mark->getData();
		if(!$prop) return $data;
		$right = array($prop);
		return Sequence::get($data,$right);
	}
	public static function getName()
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