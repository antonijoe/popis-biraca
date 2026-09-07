<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {

        header('Location: index.php');
        exit;

    }
}

function requireAdmin()
{
    requireLogin();

    if (!isset($_SESSION['role'])) {

        http_response_code(403);
        exit('Nemate dopuštenje za pristup ovoj stranici.');

    }

    if ($_SESSION['role'] != 'admin') {

        http_response_code(403);
        exit('Nemate dopuštenje za pristup ovoj stranici.');

    }
}

function isAdmin()
{
    if (isset($_SESSION['role'])) {

        if ($_SESSION['role'] == 'admin') {
            return true;
        }

    }

    return false;
}