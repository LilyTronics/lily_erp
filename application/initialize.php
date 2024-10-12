<?php

date_default_timezone_set("Europe/Amsterdam");


define("APPLICATION_TITLE", "Lily ERP");

// Use these two defines for forcing only SSL (HTTPS) URIs
// define("DOMAIN", "<domain_name>");
// define("FORCE_SSL", true);


define("CONFIG_FILE", DOC_ROOT . "../lily_erp.ini");
define("DEBUG_LOG", new ModelSystemLogger("debug"));

define("TEMPLATE_VALUES", [
    "{BUTTON}" => "w3-button w3-round w3-theme",
    "{INPUT}"  => "w3-input w3-border w3-round w3-padding-small",
    "{TABLE}"  => "w3-table width-auto"
]);
