<?php

require 'auth.php';
requireAdmin();

require 'db.php';

if (!isset($_GET['id'])) {
    die("Nije odabran birač.");
}

$id = $_GET['id'];

$sql = "SELECT id, ime, prezime
        FROM voters
        WHERE id = ?";

$stmt = mysqli_prepare($spoj, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$rezultat = mysqli_stmt_get_result($stmt);

$voter = mysqli_fetch_assoc($rezultat);

if (!$voter) {
    die("Birač nije pronađen.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "DELETE FROM voters
            WHERE id = ?";

    $stmt = mysqli_prepare($spoj, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {

        header('Location: dashboard.php');
        exit;

    } else {

        die("Greška pri brisanju birača.");

    }

}

?>

<!DOCTYPE html>
<html lang="hr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Obriši birača</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="page-wrapper">

        <div class="card">

            <h1>Obriši birača</h1>

            <p>
                Jeste li sigurni da želite obrisati birača:
            </p>

            <p>
                <strong>
                    <?php echo htmlspecialchars($voter['ime']); ?>
                    <?php echo htmlspecialchars($voter['prezime']); ?>
                </strong>
            </p>

            <form method="post" action="delete_voter.php?id=<?php echo $id; ?>">

                <button type="submit">
                    Potvrdi brisanje
                </button>

            </form>

            <a class="button-link" href="dashboard.php">
                Odustani
            </a>

        </div>

    </div>

</body>

</html>