<?php
declare(strict_types=1);
namespace mindspun\wall;

use Exception;

/**
 * Global Plugin class
 *
 * @property string version
 * @property string file
 * @property Settings settings;
 */
class Plugin {

    /**
     * Plugin version
     *
     * @var string version
     */
    private string $version;

    /**
     * Path of the module php file.
     *
     * @var string file
     */
    private string $file;
    /**
     * Settings instance.
     *
     * @var Settings settings
     */
    private Settings $settings;

    /**
     * Constructor.
     */
    public function __construct( string $file, string $version ) {
        $this->file = $file;
        $this->version = $version;

        $this->settings = new Settings();

        new Wall( $this );
        new admin\Admin( $this );
    }

    /**
     * Get the url of this plugin - with trailing slash.
     */
    public function get_url(): string {
        return plugin_dir_url( $this->file );
    }

    /**
     * Get the top-level directory of this plugin.
     */
    public function get_directory(): string {
        return dirname( $this->file );
    }

    /**
     * Expose certain internal variables as read-only.
     *
     * @throws Exception For invalid property.
     */
    public function __get( $name ) {
        if ( 'file' === $name || 'version' === $name || 'settings' === $name ) {
            return $this->$name;
        }
        throw new Exception( 'Undefined property: ' . get_class( $this ) . '::' . $name );
    }
}
