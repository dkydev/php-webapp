<?php

class DKY_Menu
{    
    public static function getMenuById($menuId)
    {
        return DKY_DB::get("menu", "menu_id", $menuId);
    }
}

?>