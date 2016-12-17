<?php
use infrajs\view\View;
use infrajs\ans\Ans;
use infrajs\mark\Mark;
use infrajs\env\Env;
use infrajs\nostore\Nostore;
use infrajs\path\Path;
use infrajs\config\Config;

Nostore::on(); //Вызов должен быть всегда так как устанавливаются cookie
Config::get();
Env::init();

$ans = array();
$ans['env'] = Env::get();
$ans['name'] = Env::getName();
$ans['get'] = $_GET['-env'];

return Ans::ret($ans);