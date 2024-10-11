<?php

class ControllerApplication extends ControllerBase
{

    public function executeAction($action, $level, $parameters)
    {
        $controllerName = get_class($this);

        // If not the setup controller, do a system check
        if ($controllerName != "ControllerSetup") {
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
        $view->addStyleSheet("w3.css");
        $view->addStyleSheet("w3-theme-blue-grey.css");
        $view->addStyleSheet("lily-erp.css");
        $view->addJavaScriptFile("field_descriptions.js");
        $view->addJavaScriptFile("dialogs.js");
        $view->addJavaScriptFile("evaluator.js");
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
