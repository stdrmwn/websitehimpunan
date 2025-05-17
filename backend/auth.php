<?php
session_start();

function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login.php");
        exit;
    }
}

function require_role($required_role) {
    require_login();

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $required_role) {
        header("Location: /login.php");
        exit;
    }
}

function get_current_user() {
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'role' => $_SESSION['role'] ?? null
    ];
}
