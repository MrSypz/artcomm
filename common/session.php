<?php
session_start();

function setUserSession($userId, $username) {
    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = $username;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getId() {
    return $_SESSION['user_id'];
}