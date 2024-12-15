<?php

require_once("config.php");
require_once("templateValues.php");


define("APPLICATION_TITLE",     "Lily ERP");
define("FORCE_SSL",             true);

define("APP_MODULES_PATH",      APP_PATH . "modules/");

define("DATABASE_VERSION",      "0.1");
define("DEFAULT_LANDING_PAGE",  "dashboard");
define("DEFAULT_COLOR",         "#0066aa");

// So we use the same precision every where for the amounts of money
// 18,6: max amount: 999 999 999 999.999 999 (up to 1 trillion)
define("TYPE_DECIMAL", "DECIMAL(18,6)");
// Decimal precision for calculations
define("DECIMAL_PRECISION", 10);


define("DEBUG_LOG",             new ModelSystemLogger("debug"));

DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");
DEBUG_LOG->writeMessage("+                            Start debug log                           +");
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");

// Add the modules path to the autoloader
$_AUTOLOADER_SEARCH_PATHS[] = APP_MODULES_PATH;
