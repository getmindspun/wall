<?php
declare(strict_types=1);
namespace mindspun\wall;

/**
 * Stores all application configuration.
 *
 * @property bool $enabled
 * @property ?string $secret
 * @property bool $login_redirect
 * @property int $landing_page
 */
class Settings {

    const OPTION_NAME = 'mindspun_wall';

    /**
     * Enable/disable the wall
     *
     * @var bool enabled;
     */
    private bool $enabled;

    /**
     * Enable/disable redirection to login page
     *
     * @var bool enabled;
     */
    private bool $login_redirect;

    /**
     * Application secret (for the X-Secret header)
     *
     * @var ?string $secret
     */
    private ?string $secret;

    /**
     * Landing page id or 0
     *
     * @var int $landing_page
     */
    private int $landing_page;

    /**
     * Constructor.
     */
    public function __construct() {
        $options = get_option( self::OPTION_NAME );
        if ( ! $options ) {
            $options = array();
        }
        foreach ( $options as $key => $value ) {
            $this->$key = $value;
        }
        if ( ! isset( $this->enabled ) ) {
            $this->enabled = false;
        }
        if ( ! isset( $this->login_redirect ) ) {
            $this->login_redirect = false;
        }
        if ( ! isset( $this->landing_page ) ) {
            $this->landing_page = 0;
        }
        if ( ! isset( $this->secret ) ) {
            $this->secret = null;
        }
    }

    /**
     * Saves all settings as an array option.
     *
     * @return void
     */
    public function save() : void {
        update_option( self::OPTION_NAME, $this->as_array() );
    }

    /**
     * Creates an array with all settings.
     *
     * @return array
     */
    public function as_array() : array {
        $array = array();
        foreach ( get_class_vars( get_class( $this ) ) as $name => $value ) {
            $array[ $name ] = $value;
        }
        return $array;
    }

    /**
     * Getter
     *
     * @param string $name The property name to get.
     */
    public function __get( string $name ) {
        return $this->$name;
    }
}
