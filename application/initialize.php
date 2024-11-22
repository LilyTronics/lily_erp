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
    "{CONTAINER}"       => "container-fluid p-3",
    "{BUTTON}"          => "btn theme-btn",
    // "{BUTTON_RED}"      => "",
    "{INPUT}"           => "form-control",
    // "{SELECT}"          => "",
    "{TOOL_BUTTON}"     => "btn btn-sm theme-btn",
    "{TOOL_BUTTON_RED}" => "btn btn-sm btn-danger",
    "{SHOW_LOADER}" => "data-bs-toggle=\"modal\" data-bs-target=\"#modal-loader\""
];

define("DEBUG_LOG", new ModelSystemLogger("debug"));
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");
DEBUG_LOG->writeMessage("+                            Start debug log                           +");
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");

// Add the modules path to the autoloader
$_AUTOLOADER_SEARCH_PATHS[] = APP_MODULES_PATH;
