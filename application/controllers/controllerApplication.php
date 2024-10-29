<?php

class ControllerApplication extends ControllerBase
{

    /* Execute actions */
    public function executeAction($action, $level, $parameters)
    {
        // $level = access level:
        // 0 - always available
        // 1 - setup must be OK, log in not required
        // 2 - setup must be OK and must be logged in

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

    /* Set page data */
    protected function setPageData($pageData)
    {
        ModelApplicationSession::setData("page_data", $pageData);
    }

    /* Log in */
    protected function showLogIn($parameters)
    {
        return $this->showPage("viewLogIn");
    }

    /* Log out */
    protected function logOut()
    {
        ModelApplicationSession::deleteSession();
        $this->gotoLocation("");
    }

    /* Show the  page */
    protected function showPage($pageName, $pageData=[])
    {
        // Merge the page data from the parameter with any stored session data.
        // The parameter page data will overwrite any stored session data when the keys are same.
        $newPageData = array_merge(
            ModelApplicationSession::getData("page_data", []),
            $pageData
        );
        ModelApplicationSession::clearData("page_data");

        $view = new ViewApplication();
        $view->setView($pageName);
        $view->setUserData("page_data", $newPageData);
        $view->setPageTitle(APPLICATION_TITLE);
        $view->addMetaTag("name=\"viewport\" content=\"width=device-width, initial-scale=1\"");
        $view->addJavascriptPreVariable("WEB_ROOT", "\"" . WEB_ROOT . "\"");
        $view->addJavascriptPreVariable("BUTTON", "\"{BUTTON}\"");
        $view->addStyleSheet("w3.css");
        $view->addStyleSheet("w3-theme-blue-grey.css");
        $view->addStyleSheet("lily-erp.css");
        $view->addStyleSheet("loader.css");
        $view->addStyleSheet("fontawesome/css/fontawesome.min.css");
        $view->addStyleSheet("fontawesome/css/brands.min.css");
        $view->addStyleSheet("fontawesome/css/solid.min.css");
        $view->addJavaScriptFile("dialogs.js");
        $view->addJavaScriptFile("api.js");
        $view->addJavaScriptFile("record_table.js");
        return $view->output();
    }

}
