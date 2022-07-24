<?php
/**
 *  Template for the default landing page.
 *
 * @description: Place this template file within your theme directory under /my-theme/spn_templates/
 *
 * @copyright  : http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

?>
<!DOCTYPE html>
<html lang="<?php bloginfo( 'language' ); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
</head>
<body class="spn-page">
<div class="spn-container">
    <h1>Private Site</h1>
    <p class="lead">This site is currently private. Please log in for access.</p>
</div>
<a href="<?php echo esc_attr( wp_login_url() ); ?>" class="button button-primary spn-button">Log In</a>
</body>
</html>
