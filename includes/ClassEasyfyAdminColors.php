<?php
Class ClassEasyfyAdminColors {
    public function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    private function load_dependencies() {
        require_once plugin_dir_path(__FILE__) . 'ClassScripts.php';
        require_once plugin_dir_path(__FILE__) . 'ClassAdminSettings.php';
        require_once plugin_dir_path(__FILE__) . 'ClassUserProfile.php';
        require_once plugin_dir_path(__FILE__) . 'ClassUtilities.php';
    }

    private function define_admin_hooks() {
        $scripts = new ClassScripts();
        $admin_settings = new ClassAdminSettings();
        $user_profile = new ClassUserProfile();

        add_action('admin_enqueue_scripts', array($scripts, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($scripts, 'enqueue_scripts'));
    }

    public function run() {
        // Não há necessidade de adicionar código aqui no momento, pois os hooks já foram definidos no construtor.
    }
}
