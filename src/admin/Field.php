<?php
declare(strict_types=1);
namespace mindspun\wall\admin;

use Exception;
use mindspun\wall\Settings;


/**
 * Creates a field in a given section.
 *
 * @property string name;
 * @property string title;
 */
abstract class Field {
    /**
     * The name of both the option this field represents.
     *
     * @var string name
     */
    private string $name;
    /**
     * Field title
     *
     * @var string title
     */
    private string $title;
    /**
     * The settings instance.
     *
     * @var Settings settings
     */
    protected Settings $settings;

    /**
     * Constructor.
     *
     * @param Settings $settings Settings instance.
     * @param string   $name The member of the setting (underscore version).
     * @param string   $title The formatted label for the field.
     */
    public function __construct( Settings $settings, string $name, string $title ) {
        $this->settings = $settings;
        $this->name = $name;
        $this->title = $title;
    }

    /**
     * Fills the field with the desired form inputs (echos output).
     *
     * @return void
     */
    abstract public function callback() : void;

    /**
     * Validates and/or sanitizes the option's value (in-place);
     */
    abstract public function validate( &$data );


    /**
     * Returns the value for this field.
     */
    public function value() {
        $name = $this->name;
        return $this->settings->$name;
    }

    /**
     * Generates the field id
     *
     * @return string
     */
    public function id() : string {
        return Admin::SLUG . '-field-' . str_replace( '_', '-', $this->settings::OPTION_NAME . '-' . $this->name );
    }

    /**
     * Generates the name for an input tag
     */
    public function input_name() : string {
        return $this->settings::OPTION_NAME . '[' . $this->name . ']';
    }

    /**
     * Getter
     *
     * @throws Exception For invalid property.
     */
    public function __get( string $name ): string {
        if ( 'name' === $name || 'title' === $name ) {
            return $this->$name;
        }
        throw new Exception( 'Undefined property: ' . get_class( $this ) . '::' . $name );
    }
}
