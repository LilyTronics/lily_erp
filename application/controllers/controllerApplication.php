<?php

class ControllerApplication extends ControllerBase
{

    public function executeAction($action, $level, $parameters)
    {
        $controllerName = get_class($this);

        // If not the setup controller or API controller, do a system check
        $noCheckControllers = ["ControllerSetup", "ControllerApi"];

        if (array_search($controllerName, $noCheckControllers) === false) {
            $redirectTo = ModelSetup::checkConfiguration();
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
        $view->addJavascriptPreVariable("WEB_ROOT", "\"" . WEB_ROOT . "\"");
        $view->addJavascriptPreVariable("BUTTON", "\"{BUTTON}\"");
        $view->addStyleSheet("w3.css");
        $view->addStyleSheet("w3-theme-blue-grey.css");
        $view->addStyleSheet("lily-erp.css");
        $view->addJavaScriptFile("dialogs.js");
        $view->addJavaScriptFile("api.js");
        $view->setView($viewName);
        return $view;
    }

}
