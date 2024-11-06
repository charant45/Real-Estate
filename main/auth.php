<?php
// auth.php
require_once 'database.php';

session_start();

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function login($username, $password)
{
    global $db;
    $user = $db->loginUser($username, $password);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    return false;
}

function register($username, $password, $email)
{
    global $db;
    if (empty($username) || empty($password) || empty($email)) {
        return false;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return $db->registerUser($username, $password, $email);
}

function logout()
{
    session_unset();
    session_destroy();
}

function require_login()
{
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
}

function generate_csrf_token()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function sanitize_input($input)
{
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}