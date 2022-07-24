<?php
declare(strict_types=1);
namespace mindspun\wall\admin\fields;

use mindspun\wall\admin\Field;
use mindspun\wall\Settings;

/**
 * Landing page to use.
 *
 * @property string name
 */
class LandingPageField extends Field {
    /**
     * Constructor.
     *
     * @param Settings $settings Settings instance.
     */
    public function __construct( Settings $settings ) {
        parent::__construct( $settings, 'landing_page', 'Landing Page' );
    }

    /**
     * Validation (always true).
     */
    public function validate( &$data ) {
        $value = $data[ $this->name ] ?? 0;
        $data[ $this->name ] = intval( $value );
    }

    /**
     * Echo the checkbox.
     */
    public function callback() : void {
        wp_dropdown_pages(
            array(
                'name' => esc_attr( $this->input_name() ),
                'show_option_none' => 'None',
                'selected' => esc_attr( $this->value() ),
            )
        );
    }

}
