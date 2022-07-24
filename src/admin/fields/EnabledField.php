<?php
declare(strict_types=1);
namespace mindspun\wall\admin\fields;

use mindspun\wall\admin\Field;
use mindspun\wall\Settings;

/**
 * Enable/disable the wall.
 *
 * @property string name
 */
class EnabledField extends Field {
    /**
     * Constructor.
     *
     * @param Settings $settings Settings instance.
     */
    public function __construct( Settings $settings ) {
        parent::__construct( $settings, 'enabled', 'Enabled' );
    }

    /**
     * Validation (always true).
     */
    public function validate( &$data ) {
        $value = $data[ $this->name ] ?? null;
        $data[ $this->name ] = '1' === $value;
    }

    /**
     * Echo the checkbox.
     */
    public function callback() : void {
        ?>
        <!--suppress HtmlFormInputWithoutLabel -->
        <input
            type="checkbox"
            id="<?php echo esc_attr( $this->name ); ?>"
            name="<?php echo esc_attr( $this->input_name() ); ?>"
            value="1"
            <?php checked( true, $this->value() ); ?>
        />
        <?php
    }

}
