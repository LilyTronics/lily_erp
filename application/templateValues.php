<?php

// Can be used in the HTML as {KEY_NAME}, e.g.: <div class="{CONTAINER}">

$GLOBALS["TEMPLATE_VALUES"] = [
    // Style classes

    "{CONTAINER}"       => "container-fluid p-3",
    "{BUTTON}"          => "btn theme-btn",
    "{BUTTON_RED}"      => "btn btn-danger",
    "{INPUT}"           => "form-control",
    "{TOOL_BUTTON}"     => "btn btn-sm theme-btn",
    "{TOOL_BUTTON_RED}" => "btn btn-sm btn-danger",
    "{SHOW_LOADER}"     => "data-bs-toggle=\"modal\" data-bs-target=\"#modal-loader\"",

    // Various
    "{WEB_ROOT}"        => WEB_ROOT,
    "{API_URI}"         => WEB_ROOT . "api"
];

?>
