<?php

function isLogedIn() {
    return isset($_SESSION['UserId']);
}

function isAdmin() {
    return isLogedIn() && $_SESSION['UserRole'] === 'admin';
}

function isSuperAdmin() {
    return isLogedIn() && $_SESSION['UserRole'] === 'superadmin';
}

function isLangSet() {
    return isset($_SESSION['Lang']) ? true : false;
}

function getLanguage() {
    return isset($_SESSION['Lang']) ? $_SESSION['Lang'] : null;
}
