<?php

function isLogedIn() {
    return isset($_SESSION['UserId']) ? true : false;
}

function isAdmin() {
    return isLogedIn() && $_SESSION['UserRole'] === 'admin';
}

function isSuperAdmin() {
    return isLogedIn() && $_SESSION['UserRole'] === 'superadmin';
}
