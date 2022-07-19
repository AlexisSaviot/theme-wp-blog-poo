<?php
if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/../../widgets/SliderWidget.php';

/**
 * The register and action/filter needed on the custom theme //
 * 
 *  PARAMETERS :    
 * - $core_env allow to add function which require a development's environment
 * 
 *  METHODS :       
 * - template_dir to get_template_directory() function
 * 
 * - template_url to get_template_directory_uri() function
 * 
 * - assets_url give the template_url . '/assets'
 * 
 * - lang allows to define a language by a string
 * 
 */
class ThemeManager
{

    public function __construct(string $core_env)
    {
        $this->template_dir = get_template_directory();
        $this->template_url = get_template_directory_uri();
        $this->assets_url = $this->template_url . '/assets';
        $this->lang = '';

        if ($core_env === 'dev') {
            $this->initDevEnvironment();
        }

        add_action('widgets_init', [$this, 'initWidgets']);

        add_action('wp_enqueue_scripts', [$this, 'initStyles']);

        add_action('wp_enqueue_scripts', [$this, 'initScripts']);

        add_action('after_setup_theme', [$this, 'initThemeSupport']);
        
        add_action('admin_menu', [$this, 'removeFromAdmin']);

        remove_action("wp_head", "wp_generator");

        add_filter('login_errors','Erreur lors de la connexion, contactez votre administrateur.');

        define('DISALLOW_FILE_EDIT',true);

        $this->addNavMenuClasses();
    }

    /**
     * Execute if we are in dev environment
     * @return void
     */
    private function initDevEnvironment(): void
    {
        // add_filter('jetpack_offline_mode', '__return_true');
    }
    
    /**
     * Remove the unnecessary editing's item from the admin
     * @return void
     */
    function removeFromAdmin()
    {
        remove_menu_page('edit-comments.php');
        remove_menu_page('edit.php?post_type=page');
        remove_menu_page('meta-box');
    }

    /**
     * Initialize the sidebars
     * @return void
     */
    public function initWidgets(): void
    {
        register_widget(SliderWidget::class);
        register_sidebar(array(
            'name'          => __('blog-sidebar'),
            'id'            => 'sidebar-1',
            'description'   => __('Add widgets for your blog here.'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title h5">',
            'after_title'   => '</h2>',
        ));
        register_sidebar(array(
            'name'          => __('single-sidebar'),
            'id'            => 'sidebar-2',
            'description'   => __('Add widgets for your blog here.'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title h5">',
            'after_title'   => '</h2>',
        ));
    }

    /**
     * Add css
     * @return void
     */
    public function initStyles(): void
    {
        wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css');
        wp_enqueue_style('bootstrap');
        wp_enqueue_style('mycss', $this->assets_url . "/scss/" .  "style.css");

    }

    /**
     * Add js
     * @return void
     */
    public function initScripts(): void
    {
        wp_register_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js', ['popper', 'jquery'], false, true);
        wp_register_script('popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', [], false, true);
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://code.jquery.com/jquery-3.5.1.slim.min.js', [], false, true);
        wp_enqueue_script('bootstrap');
    }

    /**
     * Add new features to the theme
     * @return void
     */
    public function initThemeSupport(): void
    {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails', ['post']);
        add_theme_support('custom-logo', array(
            'flex-height' => true,
            'flex-width'  => true,
        ));
        register_nav_menu('header', 'header-menu');
        register_nav_menu('footer', 'footer-menu');
    }

    private function addNavMenuClasses(): void
    {
        add_filter('nav_menu_css_class', [$this, 'themeMenuCls']);

        add_filter('nav_menu_link_attributes', [$this, 'themeMenuAttrs']);
    }

    public function themeMenuCls(array $classes)
    {
        $classes[] = 'nav-item active';
        return $classes;
    }

    public function themeMenuAttrs(array $attrs)
    {
        $attrs['class'] = 'nav-link';
        return $attrs;
    }

    public function loadAngularApp(string $app_name, array $attributes = [], bool $load_script = false): string
    {
        $html = '<app-root';
        foreach ($attributes as $attribute_name => $attribute_value) {
            $html .= ' ' . $attribute_name . "='" . $attribute_value . "'";
        }
        $html .= '></app-root>';
        if ($load_script) {
            wp_register_script('main', $this->assets_url . "/angular/" . $app_name . "/main.js");
            wp_register_script('polyfills', $this->assets_url . "/angular/" . $app_name . "/polyfills.js");
            wp_register_script('runtime', $this->assets_url . "/angular/" . $app_name . "/runtime.js");
            wp_enqueue_script('main');
            wp_enqueue_script('polyfills');
            wp_enqueue_script('runtime');
        }
        return $html;
    }
}
