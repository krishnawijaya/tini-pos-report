<?php

namespace KrishnaWijaya\TiniPosReport\Helpers;

use KrishnaWijaya\TiniPosReport\Models\Menu;

class SideBarMenu
{
    public static function get($menuName, $type = null, array $options = [])
    {
        return Menu::display($menuName, $type, $options);
    }
}
