<?php
/**
 * Plugin Name: Wall by Mindspun
 * Plugin URI: https://www.mindspun.com
 * Description: Lightweight plugin to make your site private.
 * Version: 0.1.0
 * Author: Mindspun
 * Author URI: https://www.mindspun.com
 * License: GNU Version 2 or Any Later Version
 */

spl_autoload_register(
    function ( $class ) {
        if ( strpos( $class, 'mindspun\\wall\\' ) === 0 ) {
            $file = str_replace( '\\', '/', substr( $class, 14 ) ) . '.php';
            $path = __DIR__ . '/src/' . $file;
            if ( file_exists( $path ) ) {
                require $path;
                return true;
            }
        }
        return false;
    }
);

new mindspun\wall\Plugin( __FILE__, '0.1.0' );
