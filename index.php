<?php
use infrajs\view\View;
use infrajs\ans\Ans;
use infrajs\mark\Mark;

$name = View::getCookie('-env');
$mark = new Mark('~.env/','mark');
$ans = array();
if ($mark->name != $name) return Ans::err($ans, 'Запрос устарел, уже установлено новое окружение');
$ans['env'] = $mark->get();

return Ans::ret($ans);