<?php

class ControllerApplication extends ControllerBase
{

    public function executeAction($action, $level, $parameters)
    {
        // $level = access level:
        // 0 - always available
        // 1 - configuration must be OK, log in not required
        // 2 - configuration must be OK and must be logged in

        $controllerName = get_class($this);
        DEBUG_LOG->writeMessage("Start execute action");
        DEBUG_LOG->writeMessage("Controller      : {$controllerName}");
        DEBUG_LOG->writeMessage("Action          : {$action}");
        DEBUG_LOG->writeMessage("Level           : {$level}");
        DEBUG_LOG->writeMessage("Parameters:");
        DEBUG_LOG->writeDataArray($parameters);

        $isConfigurationOk = ModelSetup::checkConfiguration();
        $isSessionValid = ModelApplicationSession::checkSession();
        DEBUG_LOG->writeMessage("Configuration OK: " . var_export($isConfigurationOk, true));
        DEBUG_LOG->writeMessage("Valid session   : " . var_export($isSessionValid, true));

        // Check the setup, only for level 1 or higher
        if (!$isConfigurationOk and $level >= 1) {
            DEBUG_LOG->writeMessage("Redirect to: setup/create-config");
            $this->gotoLocation("setup/create-config");
            exit();
        }

        // Check session, only for level 2 or higher
        if (!$isSessionValid and $level >= 2)
        {
            DEBUG_LOG->writeMessage("Redirect to: log-in");
            $this->gotoLocation("log-in");
            exit();
        }

        DEBUG_LOG->writeMessage("Execute action: {$action}");
        return $this->$action($parameters, $isConfigurationOk, $isSessionValid);
    }

    protected function setPageData($pageData)
    {
        ModelApplicationSession::setData("page_data", $pageData);
    }

    protected function showLandingPage($parameters)
    {
        $table = new ModelDatabaseTableSetting();
        $settings = $table->getSettings();
        if (isset($settings["landing_page"])) {
            $this->gotoLocation($settings["landing_page"]);
        }
        // If not set, something in the configuration is wrong
        DEBUG_LOG->writeMessage("No landing page defined, redirect to: log-in");
        $this->gotoLocation("setup/create-config");
    }

    protected function showLogIn($parameters)
    {
        return $this->showPage("viewLogIn");
    }

    protected function showDashboard($parameters)
    {
        $pageData = [
            "items" => ModelDashboard::getDashboardItems()
        ];
        return $this->showPage("viewDashboard", $pageData);
    }


    protected function showMyAccount($parameters)
    {
        $pageData = [];
        return $this->showPage("viewMyAccount", $pageData);
    }

    protected function showPage($pageName, $pageData=[])
    {
        DEBUG_LOG->writeMessage("Show page: {$pageName}");
        $controllerName = get_class($this);

        // Merge the page data from the parameter page data with any stored session page data.
        // The record must be merged separately, else we lose data
        DEBUG_LOG->writeMessage("Merge page data");
        $sessionData = ModelApplicationSession::getData("page_data", []);
        ModelApplicationSession::clearData("page_data");

        $recordData = [];
        if (isset($sessionData["record"]))
        {
            $recordData = $sessionData["record"];
            unset($sessionData["record"]);
        }
        // Merge page data without record
        $pageData = array_merge($pageData, $sessionData);
        // Merge record if needed
        if (isset($pageData["record"]) and count($recordData) > 0)
        {
            $pageData["record"] = array_merge($pageData["record"], $recordData);
        }

        $pageData["is_logged_in"] = ModelApplicationSession::checkSession();

        DEBUG_LOG->writeMessage("Generate theme");
        ModelColorTheme::generateTheme();

        DEBUG_LOG->writeMessage("Create view");
        $view = new ViewApplication();
        $view->setView($pageName);
        $view->setPageData($pageData);
        $view->setPageTitle(APPLICATION_TITLE);
        $view->addMetaTag("name=\"viewport\" content=\"width=device-width, initial-scale=1\"");
        $view->addJavascriptPreVariable("WEB_ROOT", "\"" . WEB_ROOT . "\"");
        $view->addJavascriptPreVariable("BUTTON", "\"{BUTTON}\"");
        $view->addStyleSheet("bootstrap.css");
        $view->addStyleSheet("lily-erp.css");
        $view->addStyleSheet("loader.css");
        $view->addStyleSheet("color-theme.css");
        $view->addStyleSheet("fontawesome/css/fontawesome.min.css");
        $view->addStyleSheet("fontawesome/css/brands.min.css");
        $view->addStyleSheet("fontawesome/css/solid.min.css");
        $view->addJavaScriptFile("bootstrap.bundle.js");
        if ($controllerName == "ControllerAdministrator")
        {
            $view->addJavaScriptFile("color-theme.js");
        }
        DEBUG_LOG->writeMessage("Output view");
        return $view->output();
    }

}
