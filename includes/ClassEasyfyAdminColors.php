<?php

class ClassEasyfyAdminColors {
    /**
     * Construtor para inicializar o plugin.
     */
    public function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    /**
     * Carrega as dependências necessárias para o plugin.
     */
    private function load_dependencies() {
        require_once plugin_dir_path(__FILE__) . 'ClassScripts.php';
        require_once plugin_dir_path(__FILE__) . 'ClassAdminSettings.php';
        require_once plugin_dir_path(__FILE__) . 'ClassUserProfile.php';
        require_once plugin_dir_path(__FILE__) . 'ClassUtilities.php';
    }

    /**
     * Define e registra todos os hooks necessários para a administração.
     */
    private function define_admin_hooks() {
        $scripts = new ClassScripts();
        $admin_settings = new ClassAdminSettings();
        $user_profile = new ClassUserProfile();

        // Registra os hooks para enfileirar scripts e estilos
        add_action('admin_enqueue_scripts', array($scripts, 'enqueue_styles_and_scripts'));

        // Adiciona páginas de configuração no painel administrativo
        add_action('admin_menu', array($admin_settings, 'add_settings_page'));

        // Adiciona campos personalizados nos perfis dos usuários
        add_action('show_user_profile', array($user_profile, 'add_custom_user_profile_fields'));
        add_action('edit_user_profile', array($user_profile, 'add_custom_user_profile_fields'));

        // Salva os campos personalizados nos perfis dos usuários
        add_action('personal_options_update', array($user_profile, 'save_custom_user_profile_fields'));
        add_action('edit_user_profile_update', array($user_profile, 'save_custom_user_profile_fields'));
    }

    /**
     * Executa o plugin.
     */
    public function run() {
        // Este método pode ser expandido para incluir funcionalidades executadas durante a inicialização do plugin.
    }
}

