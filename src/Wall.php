<?php
declare(strict_types=1);

namespace mindspun\wall;

/**
 * The actual wall functionality
 */
class Wall {

    const TEMPLATE_DIR = 'spn_templates';

    /**
     * The plugin.
     *
     * @var Plugin plugin
     */
    private Plugin $plugin;

    /**
     * Constructor.
     */
    public function __construct( Plugin $plugin ) {
        $this->plugin = $plugin;

        add_action( 'template_redirect', array( &$this, 'action' ) );
        add_filter( 'template_include', array( &$this, 'template_include' ) );

        add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_scripts' ), 5 );
    }

    /**
     * Add assets.
     */
    public function wp_enqueue_scripts() {
         wp_enqueue_style( 'wall-landing-page', $this->plugin->get_url() . 'assets/css/style.css', array(), $this->plugin->version );
    }

    /**
     * Redirect to the login page.
     */
    public function login_redirect() {
         global $wp;
        if ( wp_login_url() !== $GLOBALS['pagenow'] ) {
            wp_redirect( wp_login_url( $wp->request ) );
            exit;
        }
    }

    /**
     * Find the path for the given template.
     */
    public function template_path( $slug, $name = null ): ?string {
        $templates = array();
        if ( isset( $name ) ) {
            $templates[] = $slug . '-' . $name . '.php';
        }
        $templates[] = $slug . '.php';

        $dirs = array(
            trailingslashit( get_stylesheet_directory() ) . self::TEMPLATE_DIR,
            trailingslashit( get_template_directory() ) . self::TEMPLATE_DIR,
            trailingslashit( $this->plugin->get_directory() ) . 'templates',
        );

        foreach ( $templates as $template ) {
            foreach ( $dirs as $dir ) {
                $path = trailingslashit( $dir ) . $template;
                if ( file_exists( $path ) ) {
                    return $path;
                }
            }
        }
        return null;
    }

    /**
     * Redirect to a page (if not already there)
     */
    public function redirect_page( $page_id ) {
        if ( get_the_ID() !== $page_id ) {
            wp_redirect( get_permalink( $page_id ) );
        }
    }

    /**
     * Main entrypoint (can be attached to various actions)
     */
    public function action() {
        if ( ! is_user_logged_in() && $this->plugin->settings->enabled ) {
            $secret = sanitize_text_field( $_SERVER['HTTP_X_SECRET'] ?? null );
            if ( $secret && $secret === $this->plugin->settings->secret ) {
                return;
            }

            if ( wp_login_url() === $GLOBALS['pagenow'] ) {
                return;
            }

            $request_uri = sanitize_text_field( $_SERVER['REQUEST_URI'] );
            if ( false !== strpos( $request_uri, '.' ) ) {
                return;
            }

            if ( $this->plugin->settings->login_redirect ) {
                $this->login_redirect();
                return;
            }

            if ( 0 !== $this->plugin->settings->landing_page ) {
                $this->redirect_page( $this->plugin->settings->landing_page );
                return;
            }

            if ( '/' !== $request_uri ) {
                wp_redirect( '/' );
                die;
            }
        }
    }

    /**
     * Use this template
     */
    public function template_include( string $template ): string {
        if ( ! is_user_logged_in() && $this->plugin->settings->enabled ) {
            $secret = sanitize_text_field( $_SERVER['HTTP_X_SECRET'] ?? null );
            if ( $secret && $secret === $this->plugin->settings->secret ) {
                return $template;
            }
            if ( 0 === $this->plugin->settings->landing_page ) {
                return $this->template_path( 'wall', 'landing-page' );
            }
        }
        return $template;
    }
}
