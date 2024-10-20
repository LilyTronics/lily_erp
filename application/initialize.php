<?php

require_once("config.php");


if (IS_LOCALHOST)
{
    define("SHOW_DEBUG", true);
}

define("APPLICATION_TITLE", "Lily ERP");
define("FORCE_SSL", true);

// Paths
define("APP_MODULES_PATH", APP_PATH . "modules/");

define("TEMPLATE_VALUES", [
    "{BUTTON}" => "w3-button w3-round w3-theme",
    "{INPUT}"  => "w3-input w3-border w3-round w3-padding-small",
    "{TABLE}"  => "w3-table width-auto"
]);

define("DEBUG_LOG", new ModelSystemLogger("debug"));
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");
DEBUG_LOG->writeMessage("+                            Start debug log                           +");
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");

// Add the modules path to the autoloader
$_AUTOLOADER_SEARCH_PATHS[] = APP_MODULES_PATH;
