<?php
declare(strict_types=1);
namespace mindspun\wall\admin;

use mindspun\wall\Plugin;

/**
 * All admin functionality
 */
class Admin {

    const SLUG = 'mindspun-wall';
    /**
     * Constructor.
     */
    public function __construct( Plugin $plugin ) {
        $page = new OptionsPage( $plugin, 'Wall', 'Wall', self::SLUG );

        $section = new Section( 'settings' );
        $section->add_field( new fields\EnabledField( $plugin->settings ) );
        $section->add_field( new fields\LoginRedirectField( $plugin->settings ) );
        $section->add_field( new fields\LandingPageField( $plugin->settings ) );
        $section->add_field( new fields\SecretField( $plugin->settings ) );
        $page->add_section( $section );
    }
}
