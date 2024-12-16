<?php

require_once("config.php");
require_once("templateValues.php");


define("APPLICATION_TITLE",     "Lily ERP");
define("FORCE_SSL",             true);

define("APP_MODULES_PATH",      APP_PATH . "modules/");

define("DATABASE_VERSION",      "0.1");
define("DEFAULT_TIME_ZONE",     "Europe/Amsterdam");
define("DEFAULT_LANDING_PAGE",  "dashboard");
define("DEFAULT_COLOR",         "#0066aa");

// So we use the same precision every where for the amounts of money
// 18,6: max amount: 999 999 999 999.999 999 (up to 1 trillion)
define("TYPE_DECIMAL", "DECIMAL(18,6)");
// Decimal precision for calculations
define("DECIMAL_PRECISION", 10);

// Add the modules path to the autoloader
$_AUTOLOADER_SEARCH_PATHS[] = APP_MODULES_PATH;

// Set the time zone
$setting = new ModelDatabaseTableSetting();
$settings = $setting->getSettings();
date_default_timezone_set(isset($settings["time_zone"]) ? $settings["time_zone"] : DEFAULT_TIME_ZONE);

// Start debug log
define("DEBUG_LOG", new ModelSystemLogger("debug"));
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");
DEBUG_LOG->writeMessage("+                            Start debug log                           +");
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");
