<?php
use infrajs\path\Path;

if (Path::theme(Path::$conf['data'])) {
	Path::mkdir(Path::$conf['auto']);
	Path::mkdir(Path::$conf['auto'].'.env/');
}