<?php
session_start();
require_once 'database.php';

function is_logged_in()
{
    // Debugging: Check if the session variable is set
    if (isset($_SESSION['user_id'])) {
        echo "<!-- User is logged in with ID: {$_SESSION['user_id']} -->";
        return true;
    } else {
        echo "<!-- User is not logged in -->";
        return false;
    }
}

function login($username, $password)
{
    global $db;
    $user = $db->login($username, $password);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        // Debugging: Confirm session variables are set
        echo "<!-- Login successful: User ID {$_SESSION['user_id']} -->";
        return true;
    }
    echo "<!-- Login failed: Invalid credentials -->";
    return false;
}

function register($username, $password, $email)
{
    global $db;
    return $db->register($username, $password, $email);
}

function logout()
{
    session_unset();
    session_destroy();
    // Debugging: Confirm logout
    echo "<!-- User logged out -->";
}
