<?php
declare(strict_types=1);
namespace mindspun\wall\admin;

use mindspun\wall\Plugin;

/**
 * Admin page under the 'Settings' menu
 */
class OptionsPage {

    /**
     * The plugin
     *
     * @var Plugin plugin
     */
    protected Plugin $plugin;
    /**
     * The page title
     *
     * @var string page_title
     */
    protected string $page_title;
    /**
     * The title of the subpage in the Settings menu
     *
     * @var string menu_title
     */
    protected string $menu_title;
    /**
     * The slug for the page (in page=)
     *
     * @var string menu_slug
     */
    protected string $menu_slug;
    /**
     * List of sections in this page
     *
     * @var array sections
     */
    protected array $sections;

    /**
     * Constructor.
     */
    public function __construct(
        Plugin $plugin,
        string $page_title,
        string $menu_title,
        string $menu_slug = null
    ) {
        $this->plugin = $plugin;
        $this->page_title = $page_title;
        $this->menu_title = $menu_title;
        $this->menu_slug = $menu_slug;

        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
        add_action( 'admin_init', array( $this, 'register' ) );

        $this->sections = array();
    }

    /**
     * Generate the 'option_group' value using the menu slug.
     */
    public function option_group() : string {
         return str_replace( '-', '_', $this->menu_slug );
    }

    /**
     * Generate the 'page' value using the menu slug.
     */
    public function page() : string {
         return $this->menu_slug;
    }

    /**
     * The add_options_page callback.
     */
    public function add_options_page() {
        add_options_page(
            $this->page_title,
            $this->menu_title,
            'manage_options', // capability.
            $this->menu_slug,
            array( $this, 'render' )  // callback.
        );
    }

    /**
     * Add a section to the page.
     */
    public function add_section( Section $section ): void {
        $this->sections[] = $section;
    }

    /**
     * Render this page.
     */
    public function render() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_attr( $this->page_title ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( $this->option_group() );
                do_settings_sections( $this->menu_slug );
                ?>
                <p class="submit">
                    <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save Changes' ); ?>"/>
                </p>
            </form>
        </div>
        <?php
    }

    /**
     * Register all settings for all sections.
     */
    public function register() {
        register_setting(
            $this->option_group(),
            $this->plugin->settings::OPTION_NAME,
            array(
                'type' => 'array',
                'sanitize_callback' => array( $this, 'validate' ),
            )
        );

        foreach ( $this->sections as $section ) {
            $section->register( $this->page() );
        }
    }

    /**
     * Validates and/or sanitizes this section's option(s).
     *
     * @param array|null $data Initial data.
     * @return array
     */
    public function validate( ?array $data ): array {
        if ( is_null( $data ) ) {
            $data = array();
        }
        $original = $data;
        foreach ( $this->sections as $section ) {
            $section->validate( $data );
        }

        $errors = get_settings_errors( Admin::SLUG );
        return empty( $errors ) ? $data : $original;
    }
}
