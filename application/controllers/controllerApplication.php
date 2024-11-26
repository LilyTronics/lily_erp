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

        // Setup and log in OK
        return $this->$action($parameters, $isConfigurationOk, $isSessionValid);
    }

    protected function setPageData($pageData)
    {
        ModelApplicationSession::setData("page_data", $pageData);
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

    protected function showPage($pageName, $pageData=[])
    {
        // Merge the page data from the parameter page data with any stored session page data.
        // Data from the previous session overrides the parameter data
        $pageData = array_merge($pageData, ModelApplicationSession::getData("page_data", []));
        ModelApplicationSession::clearData("page_data");

        $pageData["is_logged_in"] = ModelApplicationSession::checkSession();

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
        return $view->output();
    }

}
