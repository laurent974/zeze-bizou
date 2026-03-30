<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Timber\Timber;

Timber::$dirname = ['views'];

// Register theme defaults.
add_action('after_setup_theme', function () {
    show_admin_bar(false);

    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');

    load_theme_textdomain('zeze-bizou', get_template_directory() . '/languages');

    register_nav_menus([
        'primary' => __('Primary'),
        'shop' => __('Shop'),
        'footer' => __('Footer')
    ]);
});

// Register scripts and styles.
/* add_action('wp_enqueue_scripts', function () { */
/*     $manifestPath = get_theme_file_path('assets/.vite/manifest.json'); */
/**/
/*     if ( */
/*         wp_get_environment_type() === 'local' */
/*         && is_array(wp_remote_get('http://localhost:5173/')) // is Vite.js running */
/*     ) { */
/*         wp_enqueue_script('vite', 'http://localhost:5173/@vite/client'); */
/*         wp_enqueue_script('wordplate', 'http://localhost:5173/resources/js/index.js'); */
/*     } elseif (file_exists($manifestPath)) { */
/*         $manifest = json_decode(file_get_contents($manifestPath), true); */
/*         wp_enqueue_script('wordplate', get_theme_file_uri('dist/' . $manifest['resources/js/index.js']['file'])); */
/*         wp_enqueue_style('wordplate', get_theme_file_uri('dist/' . $manifest['resources/js/index.js']['css'][0])); */
/*     } */
/* }); */

// Load scripts as modules.
add_filter('script_loader_tag', function (string $tag, string $handle, string $src) {
    if (in_array($handle, ['vite', 'wordplate', 'vite-client', 'main-js'])) {
        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }

    return $tag;
}, 10, 3);

// Remove admin menu items.
add_action('admin_init', function () {
    remove_menu_page('edit-comments.php'); // Comments
    // remove_menu_page('edit.php?post_type=page'); // Pages
    remove_menu_page('edit.php'); // Posts
    remove_menu_page('index.php'); // Dashboard
    // remove_menu_page('upload.php'); // Media
});

// Remove admin toolbar menu items.
add_action('admin_bar_menu', function (WP_Admin_Bar $menu) {
    $menu->remove_node('archive'); // Archive
    $menu->remove_node('comments'); // Comments
    $menu->remove_node('customize'); // Customize
    $menu->remove_node('dashboard'); // Dashboard
    $menu->remove_node('edit'); // Edit
    $menu->remove_node('menus'); // Menus
    $menu->remove_node('new-content'); // New Content
    $menu->remove_node('search'); // Search
    // $menu->remove_node('site-name'); // Site Name
    $menu->remove_node('themes'); // Themes
    $menu->remove_node('updates'); // Updates
    $menu->remove_node('view-site'); // Visit Site
    $menu->remove_node('view'); // View
    $menu->remove_node('widgets'); // Widgets
    $menu->remove_node('wp-logo'); // WordPress Logo
}, 999);

// Remove admin dashboard widgets.
add_action('wp_dashboard_setup', function () {
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Activity
    // remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // At a Glance
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal'); // Site Health Status
    remove_meta_box('dashboard_primary', 'dashboard', 'side'); // WordPress Events and News
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Quick Draft
});

// Add custom login form logo.
add_action('login_head', function () {
    $url = get_theme_file_uri('favicon.svg');

    $styles = [
        sprintf('background-image: url(%s)', $url),
        'width: 200px',
        'background-position: center',
        'background-size: contain',
    ];

    printf(
        '<style> .login .wp-login-logo a { %s } </style>',
        implode(';', $styles),
    );
});

// Register custom SMTP credentials.
add_action('phpmailer_init', function (PHPMailer $mailer) {
    $mailer->isSMTP();
    $mailer->SMTPAutoTLS = false;
    $mailer->SMTPAuth = env('MAIL_USERNAME') && env('MAIL_PASSWORD');
    $mailer->SMTPDebug = env('WP_DEBUG') ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF;
    $mailer->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
    $mailer->Debugoutput = 'error_log';
    $mailer->Host = env('MAIL_HOST');
    $mailer->Port = env('MAIL_PORT', 587);
    $mailer->Username = env('MAIL_USERNAME');
    $mailer->Password = env('MAIL_PASSWORD');
    return $mailer;
});

add_filter('wp_mail_from', fn() => env('MAIL_FROM_ADDRESS', 'hello@example.com'));
add_filter('wp_mail_from_name', fn() => env('MAIL_FROM_NAME', 'Example'));

// Update permalink structure.
add_action('after_setup_theme', function () {
    if (get_option('permalink_structure') !== '/%postname%/') {
        update_option('permalink_structure', '/%postname%/');
        flush_rewrite_rules();
    }
});

function vite_asset($filename, $type = 'js') {
    static $manifest;

    if (!$manifest) {
        $manifestPath = get_template_directory() . '/dist/.vite/manifest.json'; // manifest généré par Vite
        if (!file_exists($manifestPath)) return '';
        $manifest = json_decode(file_get_contents($manifestPath), true);
    }

    foreach ($manifest as $key => $value) {
        if (str_ends_with($key, $filename)) {
            if ($type === 'js') {
                return get_template_directory_uri() . '/dist/' . $value['file'];
            } elseif ($type === 'css' && !empty($value['css'][0])) {
                return get_template_directory_uri() . '/dist/' . $value['css'][0];
            }
        }
    }

    return '';
}

function theme_enqueue_scripts() {
    $js = vite_asset('main.js', 'js');
    $css = vite_asset('main.js', 'css');

    if ($css) wp_enqueue_style('main-css', $css, [], null);
    if ($js) wp_enqueue_script('main-js', $js, [], null, true);

    if (wp_get_environment_type() === 'local') {
        // Vite dev server
        wp_enqueue_script('main-js', 'http://localhost:5173/js/main.js', [], null, true);
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

add_filter('timber/context', 'add_to_context');
/**
 * Global Timber context.
 *
 * @param array $context Global context variables.
 */
function add_to_context($context)
{
    // So here you are adding data to Timber's context object, i.e...
    $context['foo'] = 'I am some other typical value set in your functions.php file, unrelated to the menu';

    // Now, in similar fashion, you add a Timber Menu and send it along to the context.
    $context['menu'] = Timber::get_menu('primary');
    $context['menu_shop'] = Timber::get_menu('shop');
    $context['menu_footer'] = Timber::get_menu('footer');

    return $context;
}
