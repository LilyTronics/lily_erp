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

$GLOBALS["TEMPLATE_VALUES"] = [
    "{BUTTON}"          => "w3-button w3-round w3-theme",
    "{BUTTON_RED}"      => "w3-button w3-round w3-red",
    "{INPUT}"           => "w3-input w3-border w3-round w3-padding-small",
    "{SELECT}"          => "w3-input w3-border w3-round",
    "{TABLE}"           => "w3-table width-auto",
    "{TOOL_BUTTON}"     => "w3-button w3-round w3-padding-small w3-theme",
    "{TOOL_BUTTON_RED}" => "w3-button w3-round w3-padding-small w3-red"
];

define("DEBUG_LOG", new ModelSystemLogger("debug"));
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");
DEBUG_LOG->writeMessage("+                            Start debug log                           +");
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");

// Add the modules path to the autoloader
$_AUTOLOADER_SEARCH_PATHS[] = APP_MODULES_PATH;
