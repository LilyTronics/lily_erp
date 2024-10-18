<?php

class ControllerApplication extends ControllerBase
{

    /* Execute actions */
    public function executeAction($action, $level, $parameters)
    {
        $controllerName = get_class($this);
        DEBUG_LOG->writeMessage("Start execute action");
        DEBUG_LOG->writeMessage("Controller      : {$controllerName}");
        DEBUG_LOG->writeMessage("Action          : {$action}");
        DEBUG_LOG->writeMessage("Parameters:");
        DEBUG_LOG->writeDataArray($parameters);

        $isConfigurationOk = ModelSetup::checkConfiguration();
        $isSessionValid = ModelApplicationSession::checkSession();

        DEBUG_LOG->writeMessage("Configuration OK: " . var_export($isConfigurationOk, true));
        DEBUG_LOG->writeMessage("Valid session   : " . var_export($isSessionValid, true));

        // If not the setup controller or API controller, do a system check
        if (array_search($controllerName, ["ControllerSetup", "ControllerApi"]) === false)
        {
            if (!$isConfigurationOk)
            {
                DEBUG_LOG->writeMessage("Redirect to: setup/create-config");
                $this->gotoLocation("setup/create-config");
                exit();
            }
        }

        // Check if user is logged in
        if ($isConfigurationOk and $controllerName != "ControllerApi" and
            $action != "showLogIn" and !$sessionValid) {
            $this->gotoLocation("log-in");
            exit();
        }

        // No redirect so execute action
        return $this->$action($parameters);
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
    protected function showPage($pageName, $pageData=null)
    {
        $view = new ViewApplication();
        $view->setView($pageName);
        $view->setUserData("page_data", $pageData);
        $view->setPageTitle(APPLICATION_TITLE);
        $view->addMetaTag("name=\"viewport\" content=\"width=device-width, initial-scale=1\"");
        $view->addJavascriptPreVariable("WEB_ROOT", "\"" . WEB_ROOT . "\"");
        $view->addJavascriptPreVariable("BUTTON", "\"{BUTTON}\"");
        $view->addStyleSheet("w3.css");
        $view->addStyleSheet("w3-theme-blue-grey.css");
        $view->addStyleSheet("lily-erp.css");
        $view->addStyleSheet("fontawesome/css/fontawesome.min.css");
        $view->addStyleSheet("fontawesome/css/brands.min.css");
        $view->addStyleSheet("fontawesome/css/solid.min.css");
        $view->addJavaScriptFile("dialogs.js");
        $view->addJavaScriptFile("api.js");
        $view->addJavaScriptFile("record_table.js");
        return $view->output();
    }

}
