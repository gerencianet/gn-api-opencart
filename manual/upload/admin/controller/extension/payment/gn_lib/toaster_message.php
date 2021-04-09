<?php

/**
 * Classe para gerenciar mensagens de alerta 
 * Tipos: success, warning, danger
 */
class ToasterMessage {

    private static $instance;

    // Enums
    public const SUCCESS = 'success';
    public const WARNING = 'warning';
    public const DANGER = 'danger';

    private function __construct() {
        session_start();
        if(!isset($_SESSION['messages'])) {
            $this->clear();
        }
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Retorna lista de mensagens
     * 
     * Mensagens da central de notificação do plugin
     * @return Array messages list
     */
    public function getMessages() {
        return $_SESSION['messages'];
    }

    /**
     * Retorna lista de mensagens e limpa lista
     * 
     * Mensagens da central de notificação do plugin
     * @return Array lista de mensagens
     */
    public function getMessagesAndClear() {
        $messages = $this->getMessage();
        $this->clear();

        return $messages;
    }

    /**
     * Adiciona mensagem a lista
     * 
     * @param String $type Tipo da mensagem: success, warning, danger
     * @param String $message Mensagem para ser exibida no toaster
     */
    public function add($type, $message) {
        if(!isset($_SESSION['messages'][$type])) {
            $_SESSION['messages'][$type] = array();
        }
        
        $_SESSION['messages'][$type][] = $message;
    }

    /**
     * Limpa lista de mensagens
     */
    public function clear() {
        $_SESSION['messages'] = array();
    }
}
