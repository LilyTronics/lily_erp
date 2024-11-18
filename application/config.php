<?php

date_default_timezone_set("Europe/Amsterdam");

// Define your domain name here to make SSL work properly
define("DOMAIN", "erp.lilytronics.nl");

// Config file must be outside the document root so it can never be reached by a web browser
define("CONFIG_FILE", $_SERVER["DOCUMENT_ROOT"] . "/../lily_erp.ini");
