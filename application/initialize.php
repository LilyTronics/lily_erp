<?php

date_default_timezone_set("Europe/Amsterdam");

if (IS_LOCALHOST)
{
    define("SHOW_DEBUG", true);
}

define("APPLICATION_TITLE", "Lily ERP");

// Use these two defines for forcing only SSL (HTTPS) URIs
// define("DOMAIN", "<domain_name>");
// define("FORCE_SSL", true);

// Config file must be outside the document root so it can never be reached by a web browser
define("CONFIG_FILE", $_SERVER["DOCUMENT_ROOT"] . "/../lily_erp.ini");


define("TEMPLATE_VALUES", [
    "{BUTTON}" => "w3-button w3-round w3-theme",
    "{INPUT}"  => "w3-input w3-border w3-round w3-padding-small",
    "{TABLE}"  => "w3-table width-auto"
]);

define("DEBUG_LOG", new ModelSystemLogger("debug"));
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");
DEBUG_LOG->writeMessage("+                            Start debug log                           +");
DEBUG_LOG->writeMessage("+----------------------------------------------------------------------+");
