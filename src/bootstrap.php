<?php

define('DS', DIRECTORY_SEPARATOR);

define('REPO_DIR', dirname(dirname(__file__)));
define('ROOT_DIR', REPO_DIR . DS . '..');
define('SRC_DIR', REPO_DIR . DS . 'src');
define('DATA_DIR', ROOT_DIR . DS . 'data');
define('CODE_DIR', ROOT_DIR . DS . 'code');

require_once SRC_DIR . DS . 'core' . DS . 'Autoload.php';

Core\Autoload::initialize(array(
    SRC_DIR,
    CODE_DIR
));

Core\Template::setTemplatesDirectory(CODE_DIR . DS . 'views' . DS . 'templates');
Core\Controller::loadAndDispatch(CODE_DIR . DS . 'handlers');