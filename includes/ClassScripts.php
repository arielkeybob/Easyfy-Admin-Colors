<?php

/**
 * Classe responsável por gerenciar scripts e estilos do plugin Easyfy Admin Colors.
 */
class ClassScripts {
    /**
     * Construtor que pode ser usado para inicializar configurações ou ações relacionadas a scripts e estilos.
     */
    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Enfileira os estilos necessários para o painel administrativo.
     */
    public function enqueue_styles() {
        wp_enqueue_style('easyfy-admin-colors-css', plugin_dir_url(__FILE__) . '../admin/admin.css', array(), '1.0', 'all');
    }

    /**
     * Enfileira os scripts necessários para o painel administrativo, incluindo a lógica para passar as configurações de cor para o JavaScript.
     */
    public function enqueue_scripts() {
        wp_enqueue_script('easyfy-live-preview', plugin_dir_url(__FILE__) . '../js/live-preview.js', array('jquery', 'wp-color-picker'), null, true);
        $colors = get_option('easyfy_admin_colors_settings');
        wp_localize_script('easyfy-live-preview', 'easyfy_admin_colors_settings', $colors);
    }
    
    
}
