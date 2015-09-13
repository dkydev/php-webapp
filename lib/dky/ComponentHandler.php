<?php

class DKY_ComponentHandler
{
    /**
     * Get the component controller.
     *
     * @param string $componentName The name of the component.
     * @return Component The component object if found. NULL if not found.
     */
    public static function getComponent($componentName)
    {
        $component = null;
        $componentClass = ucfirst($componentName) . "_Component";
        $componentPath = DKY_PATH_COM . "/" . $componentName . "/" . ucfirst($componentName) . ".php";
        if (file_exists($componentPath) && include_once ($componentPath)) {
            $component = new $componentClass();
        } else {
            DKY_Log::e("Component not found.");
        }
        return $component;
    }

}