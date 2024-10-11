<?php

class ControllerApplication extends ControllerBase
{

    public function executeAction($action, $level, $parameters)
    {
        $controllerName = get_class($this);

        // If not the setup controller or API controller, do a system check
        $noCheckControllers = ["ControllerSetup", "ControllerApi"];

        if (array_search($controllerName, $noCheckControllers) === false) {
            $redirectTo = $this->systemCheck();
            if ($redirectTo != null)
            {
                DEBUG_LOG->writeMessage("Redirect to: $redirectTo");
                $this->gotoLocation($redirectTo);
                exit();
            }
        }

        // No redirect so execute action
        return $this->$action($parameters);
    }

    protected function createView($viewName)
    {
        $view = new ViewApplication();
        $view->setPageTitle(APPLICATION_TITLE);
        $view->addMetaTag("name=\"viewport\" content=\"width=device-width, initial-scale=1\"");
        $view->addJavascriptPreVariable("API_URI", "\"" . WEB_ROOT . "api\"");
        $view->addJavascriptPreVariable("BUTTON", "\"{BUTTON}\"");
        $view->addStyleSheet("w3.css");
        $view->addStyleSheet("w3-theme-blue-grey.css");
        $view->addStyleSheet("lily-erp.css");
        $view->addJavaScriptFile("dialogs.js");
        $view->addJavaScriptFile("api.js");
        $view->setView($viewName);
        return $view;
    }


    public function systemCheck()
    {

        if (!is_file(CONFIG_FILE))
        {
            DEBUG_LOG->writeMessage("The file: " . CONFIG_FILE . "does not exist");
            return "setup/create-config";
        }

    }

}
