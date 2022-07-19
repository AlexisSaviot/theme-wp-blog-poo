<?php
if (!defined('ABSPATH')) exit;

$core_env = 'dev';

require_once __DIR__ . '/ThemeManager.php';
require_once __DIR__ . '/MetasManager.php';

$core_theme = new ThemeManager($core_env);
$core_metas = new MetasManager;

foreach (glob($core_theme->template_dir . '/core/helpers/*.php') as $file) {
    // var_dump($file);
    require_once $file;
}

require_once __DIR__ . '/../Model.php';
require_once __DIR__ . '/../Controller.php';

foreach (glob($core_theme->template_dir . '/core/controllers/*.php') as $file) {
    require_once $file;
}
foreach (glob($core_theme->template_dir . '/core/controllers/*/*.php') as $file) {
    require_once $file;
}

foreach (glob($core_theme->template_dir . '/core/models/*.php') as $file) {
    require_once $file;
}
foreach (glob($core_theme->template_dir . '/core/models/*/*.php') as $file) {
    require_once $file;
}

$core_metas->registerMetas();