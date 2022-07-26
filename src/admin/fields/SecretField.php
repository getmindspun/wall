<?php
declare(strict_types=1);
namespace mindspun\wall\admin\fields;

use mindspun\wall\admin\Field;
use mindspun\wall\Settings;

/**
 * Secret to use via X-SECRET header.
 *
 * @property string name
 */
class SecretField extends Field {
    /**
     * Constructor.
     *
     * @param Settings $settings Settings instance.
     */
    public function __construct( Settings $settings ) {
        parent::__construct( $settings, 'secret', 'Secret' );
    }

    /**
     * Validation (always true).
     */
    public function validate( &$data ) {
        $data[ $this->name ] = sanitize_text_field( $data[ $this->name ] ?: null );
    }

    /**
     * Echo the checkbox.
     */
    public function callback() : void {
        ?>
        <!--suppress HtmlFormInputWithoutLabel -->
        <input
            type="password"
            name="<?php echo esc_attr( $this->input_name() ); ?>"
            value="<?php echo esc_attr( $this->value() ); ?>"
            size="48"
        />
        <p class="small">Allow direct access to the site using the X-Secret header.</p>
        <?php
    }
}
