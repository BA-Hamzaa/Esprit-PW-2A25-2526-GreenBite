<?php
class User {
    private $id         = null;
    private $username   = null;
    private $email      = null;
    private $password   = null;
    private $role       = null;
    private $avatar     = null;
    private $is_active  = null;
    private $created_at = null;
    private $updated_at = null;

    function __construct($username, $email, $password, $role = 'USER', $avatar = null, $is_active = 1) {
        $this->username  = $username;
        $this->email     = $email;
        $this->password  = $password;
        $this->role      = $role;
        $this->avatar    = $avatar;
        $this->is_active = $is_active;
    }

    // ==================== GETTERS ====================

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getRole() {
        return $this->role;
    }

    function getAvatar() {
        return $this->avatar;
    }

    function getIsActive() {
        return $this->is_active;
    }

    function getCreatedAt() {
        return $this->created_at;
    }

    function getUpdatedAt() {
        return $this->updated_at;
    }

    // ==================== SETTERS ====================

    function setUsername(string $username) {
        $this->username = $username;
    }

    function setEmail(string $email) {
        $this->email = $email;
    }

    function setPassword(string $password) {
        $this->password = $password;
    }

    function setRole(string $role) {
        $this->role = $role;
    }

    function setAvatar(string $avatar) {
        $this->avatar = $avatar;
    }

    function setIsActive(int $is_active) {
        $this->is_active = $is_active;
    }
}
?>