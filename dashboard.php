<?php

require 'auth.php';

requireLogin();

?>

<!DOCTYPE html>
<html lang="hr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Popis birača</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="page-wrapper">

        <div class="card">

            <h1>Popis birača</h1>

            <p class="subtitle">
                Dobrodošli,
                <?php echo $_SESSION['username']; ?>
            </p>

            <div class="status-box">

                Uspješno ste prijavljeni u sustav.

            </div>

            <p>
                Uloga:
                <strong>
                    <?php echo $_SESSION['role']; ?>
                </strong>
            </p>

            <a class="button-link" href="logout.php">
                Odjava
            </a>

        </div>

    </div>

</body>

</html>