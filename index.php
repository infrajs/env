<?php
use infrajs\view\View;
use infrajs\ans\Ans;
use infrajs\mark\Mark;
use infrajs\env\Env;
use infrajs\nostore\Nostore;
use infrajs\path\Path;
use infrajs\config\Config;


Config::get(); 
//если расширение определяет параметр env, то оно должно быть загружено до и становится зависимостью для Env
//Получается что Env не знает от чего он зависит и ему нужно загрузить всё. 

Env::init(); //Считали GET или COOKIE

$ans = array();
$ans['env'] = Env::get(); //Обращение к окружениею без контроллера отменяет public кэш
$ans['name'] = Env::name();
$ans['defined'] = Env::$defined;
$ans['get'] = Ans::GET('-env');

return Ans::ret($ans);