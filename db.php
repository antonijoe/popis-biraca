<?php

$env = parse_ini_file('.env');

$servername = $env['DB_HOST'];
$dbname = $env['DB_NAME'];
$username = $env['DB_USER'];
$password = $env['DB_PASSWORD'];

$spoj = mysqli_connect(
    $servername,
    $username,
    $password,
    $dbname
);

if (!$spoj) {
    die("Greška pri povezivanju s bazom podataka: " . mysqli_connect_error());
}

mysqli_set_charset($spoj, "utf8mb4");   