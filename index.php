<?php
use infrajs\view\View;
use infrajs\ans\Ans;
use infrajs\mark\Mark;
use infrajs\env\Env;
use infrajs\nostore\Nostore;
use infrajs\path\Path;
use infrajs\config\Config;

Config::get();
$ans = array();
$ans['env'] = Env::get();
$ans['name'] = Env::name();
$ans['get'] = Ans::GET('-env');

return Ans::ret($ans);