<?php

/**
 * Classe de utilitários para o plugin Easyfy Admin Colors.
 * Contém funções utilitárias gerais que podem ser usadas em várias partes do plugin.
 */
class ClassUtilities {
    /**
     * Sanitiza os valores de entrada para garantir a segurança.
     * 
     * @param mixed $input O valor de entrada a ser sanitizado.
     * @return mixed O valor sanitizado.
     */
    public static function sanitize_input($input) {
        // Exemplo: sanitizar texto para evitar problemas de segurança como XSS.
        return sanitize_text_field($input);
    }

    /**
     * Verifica se o usuário atual tem permissão para executar uma ação.
     * 
     * @param string $capability A capacidade que está sendo verificada.
     * @return bool Verdadeiro se o usuário atual tem a capacidade, falso caso contrário.
     */
    public static function check_user_capability($capability) {
        return current_user_can($capability);
    }

    /**
     * Gera um log de depuração para ajudar no desenvolvimento e na manutenção do plugin.
     * 
     * @param string $message A mensagem a ser registrada.
     */
    public static function debug_log($message) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log($message);
        }
    }
}
