<?php

use infrajs\view\View;
use infrajs\ans\Ans;
use infrajs\env\Env;
use infrajs\config\Config;
use infrajs\nostore\Nostore;


Config::get();
//если расширение определяет параметр env, то оно должно быть загружено до и становится зависимостью для Env
//Получается что Env не знает от чего он зависит и ему нужно загрузить всё. 

Env::init(); //Считали GET или COOKIE и установили COOKIE

Nostore::on();// иначе при изменении окрущения этот скрипт будет выдавать закэшированные данные и не будет вносить изменения
//Обращение к окружениею без контроллера отменяет public кэш

$ans = array();
$ans['data'] = Env::get();
$ans['name'] = Env::getName();
$ans['defined'] = Env::$defined;
$ans['GET'] = Ans::GET('-env');
$ans['cookie'] = View::getCOOKIE('-env');

header('Content-type: application/javascript');
echo 'export default ';
echo json_encode($ans, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
