<?php

class ModelDashboard
{

    public static function getDashboardItems()
    {
        // Automatically search the modules folder.
        // A module is added to the dashboard if:
        // 1. a model exists with the same name as the module: users -> ModelUsers
        // 2. the model has a function called: getDashboard().
        //    the getDashboard must return the following data:
        //    [ "order"   => number defining the order in the dashboard (low to high)
        //      "title"   => "name of the dashboard",
        //      "icon"    => "icon for the dashboad",
        //      "link"    => "link to the module main page",
        //      "content" => "HTML formatted content to display on the dashboard" ]
        $items = [];
        $fileMatch = strtolower(DIRECTORY_SEPARATOR . "model");
        $modulesPath = DOC_ROOT . APP_MODULES_PATH;
        foreach (glob($modulesPath . '*' , GLOB_ONLYDIR) as $module)
        {
            $modelFile = $module . "/model" . ucfirst(basename($module)) . ".php";
            if (is_file($modelFile))
            {
                $modelName = "model" . ucfirst(basename($module));
                $model = new $modelName();
                if (method_exists($model, "getDashboard"))
                {
                    $items[] = $model->getDashboard();
                }
            }
        }
        usort($items, fn($a, $b) => $a["order"] <=> $b["order"]);
        return $items;
    }

}
