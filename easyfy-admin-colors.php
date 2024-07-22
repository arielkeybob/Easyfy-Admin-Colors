<?php
/**
 * Plugin Name: Easyfy Admin Colors
 * Description: Plugin para personalizar as cores do painel administrativo do WordPress.
 * Version: 1.0
 * Author: Ariel Souza
 */

// Inclui corretamente a classe principal do plugin.
require_once __DIR__ . '/includes/ClassEasyfyAdminColors.php';

// Executa o plugin.
function run_easyfy_admin_colors() {
    $plugin = new ClassEasyfyAdminColors();
    $plugin->run();
}

run_easyfy_admin_colors();
