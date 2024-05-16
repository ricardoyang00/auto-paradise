<?php
    class Session {
        private array $messages;

        public function __construct() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
            unset($_SESSION['messages']);
        }

        public function isLoggedIn() : bool {
            return isset($_SESSION['username']);    
        }

        public function logout() {
            session_destroy();
        }

        public function getUsername() : ?string {
            return isset($_SESSION['username']) ? $_SESSION['username'] : null;    
        }

        public function setUsername(string $username) {
            $_SESSION['username'] = $username;
        }

        public function addMessage(string $type, string $text) {
            $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
        }

        public function getMessages() {
            return $this->messages;
        }

        public function generateCsrfToken() {
            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
            }
        }

        public function getCsrfToken(): string {
            return $_SESSION['csrf_token'];
        }
    }
?>