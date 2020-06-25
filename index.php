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
//Получается что Env не знает от чего он зависит
$ans = array();
$ans['env'] = Env::get();
$ans['name'] = Env::name();
$ans['get'] = Ans::GET('-env');

return Ans::ret($ans);