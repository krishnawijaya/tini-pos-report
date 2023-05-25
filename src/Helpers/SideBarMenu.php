<?php

namespace Krishnawijaya\DodiUkirReport\Helpers;

use Krishnawijaya\DodiUkirReport\Models\Menu;

class SideBarMenu
{
    public static function get($menuName, $type = null, array $options = [])
    {
        return Menu::display($menuName, $type, $options);
    }
}
