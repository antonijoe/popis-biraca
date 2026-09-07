<?php

session_start();

require 'db.php';

$greska = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, role
            FROM users
            WHERE username = ?
            LIMIT 1";

    $stmt = mysqli_prepare($spoj, $sql);

    mysqli_stmt_bind_param($stmt, "s", $username);

    mysqli_stmt_execute($stmt);

    $rezultat = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($rezultat);

    if ($user) {

        if ($password == $user['password']) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header('Location: dashboard.php');
            exit;

        } else {

            $greska = "Pogrešno korisničko ime ili lozinka.";

        }

    } else {

        $greska = "Pogrešno korisničko ime ili lozinka.";

    }

}

?>

<!DOCTYPE html>
<html lang="hr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Prijava - Popis birača</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="page-wrapper">

        <div class="card">

            <h1>Popis birača</h1>

            <p class="subtitle">
                Prijava u sustav
            </p>

            <?php

            if ($greska != "") {
                echo '<div class="error-box">' . $greska . '</div>';
            }

            ?>

            <form method="post" action="index.php">

                <div class="form-group">

                    <label for="username">Korisničko ime</label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="password">Lozinka</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                    >

                </div>

                <button type="submit">
                    Prijavi se
                </button>

            </form>

        </div>

    </div>

</body>

</html>