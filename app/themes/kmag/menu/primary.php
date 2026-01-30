<?php
/**
 * The Primary Site navigation
 *
 * @package CN
 */

use CN\App\Menus\PrimaryMenuWalker;

wp_nav_menu(
    [
        'theme_location'  => 'primary',
        'menu_class'      => 'navbar-nav',
        'container_class' => 'collapse navbar-collapse',
        'container_id'    => 'primary-menu',
        'fallback_cb'     => false,
        'depth'           => 2,
        'walker'          => new PrimaryMenuWalker()
    ]
);
