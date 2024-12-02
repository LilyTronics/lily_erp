<?php

require_once("config.php");
require_once("templateValues.php");


define("APPLICATION_TITLE",     "Lily ERP");
define("FORCE_SSL",             true);

define("APP_MODULES_PATH",      APP_PATH . "modules/");

define("DATABASE_VERSION",      "0.1");
define("DEFAULT_LANDING_PAGE",  "dashboard");
define("DEFAULT_COLOR",         "#0066aa");

define("DEBUG_LOG",             new ModelSystemLogger("debug"));

DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");
DEBUG_LOG->writeMessage("+                            Start debug log                           +");
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");

// Add the modules path to the autoloader
$_AUTOLOADER_SEARCH_PATHS[] = APP_MODULES_PATH;
