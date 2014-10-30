<?php

require_once PATH_LIB . "/Controller.php";
require_once PATH_COM . "/menu/model/Menu.php";

class Menu_Controller extends Controller
{
    public function action_insert($request)
    {
        $MenuModel = new Menu_Model();
        $aMenuItem = $request->get("menuItem");
        
        $menuItemId = $MenuModel->insertMenuItem($aMenuItem);
        
        if (!empty($menuItemId)) {
            Output::raiseMessage("Menu item added successfully.", MSG_TYPE_SUCCESS);
        } else {
            Output::raiseMessage("Menu item NOT added.", MSG_TYPE_ERROR);
        }
        header("Location: ?menuItemId=" . $menuItemId);
        exit();
    }
    public function action_update($request)
    {
        $MenuModel = new Menu_Model();
        $aMenuItem = $request->get("menuItem");
        $result = $MenuModel->updateMenuItem($aMenuItem);
        if (!empty($result)) {
            Output::raiseMessage("Menu item updated successfully.", MSG_TYPE_SUCCESS);
        } else {
            Output::raiseMessage("Menu item NOT updated.", MSG_TYPE_ERROR);
        }
        header("Location: ?menuItemId=" . $aMenuItem["menu_item_id"]);
        exit();
    }
    public function action_delete($request)
    {
        $MenuModel = new Menu_Model();
        $menuItemId = $request->get("menuItemId");
        $result = $MenuModel->deleteMenuItem($menuItemId);
        if (!empty($result)) {
            Output::raiseMessage("Menu item deleted successfully.", MSG_TYPE_SUCCESS);
        } else {
            Output::raiseMessage("Menu item NOT deleted.", MSG_TYPE_ERROR);
        }
    }
}

?>