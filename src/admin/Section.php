<?php
declare(strict_types=1);
namespace mindspun\wall\admin;

use Exception;

/**
 * Creates a sections on a given page.
 */
class Section {
    /**
     * The name of the section.
     *
     * @var string name
     */
    private string $name;
    /**
     * The title of the section.
     *
     * @var ?string title
     */
    private ?string $title;
    /**
     * The section fields.
     *
     * @var array fields
     */
    protected array $fields;

    /**
     * Constructor
     */
    public function __construct( string $name, string $title = null ) {
        $this->name = $name;
        $this->title = $title;
        $this->fields = array();
    }

    /**
     * Generates the section id
     *
     * @return string
     */
    public function id() : string {
        return Admin::SLUG . '-section-' . $this->name;
    }

    /**
     * Echos out any content at the top of the section (between heading and fields).
     *
     * @return void
     */
    public function callback() : void {}

    /**
     * Validates and/or sanitizes this section's option(s).
     */
    public function validate( &$data ) {
        foreach ( $this->fields as $field ) {
            $field->validate( $data );
        }
    }

    /**
     * Adds a SettingsField to this section.
     */
    public function add_field( Field $field ) {
        $this->fields[] = $field;
    }

    /**
     * Register this section on the given page.
     */
    public function register( $page ) {
        foreach ( $this->fields as $field ) {
            add_settings_field(
                $field->id(),
                $field->title,
                array( $field, 'callback' ),
                $page,
                $this->id()
            );
        }

        add_settings_section(
            $this->id(),
            $this->title,
            array( $this, 'callback' ),
            $page
        );
    }

    /**
     * Getter
     *
     * @param string $name The property name.
     * @return string|null
     * @throws Exception For invalid property.
     */
    public function __get( string $name ) : ?string {
        if ( 'name' === $name || 'title' === $name || 'option' == $name ) {
            return $this->$name;
        }
        throw new Exception( 'Undefined property: ' . get_class( $this ) . '::' . $name );
    }
}
