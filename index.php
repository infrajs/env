<?php
use infrajs\view\View;
use infrajs\ans\Ans;
use infrajs\mark\Mark;
use infrajs\env\Env;
use infrajs\nostore\Nostore;
use infrajs\path\Path;

Nostore::on();

Env::init();

$ans = array();
$ans['env'] = Env::get();
$ans['name'] = Env::getName();

return Ans::ret($ans);