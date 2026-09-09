<?php

require 'auth.php';
requireAdmin();

require 'db.php';

$greska = "";

if (!isset($_GET['id'])) {
    die("Nije odabran birač.");
}

$id = $_GET['id'];

$sql = "SELECT id,
               ime,
               prezime,
               oib,
               legalna_adresa,
               polling_place_id
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

$sql = "SELECT id, naziv
        FROM polling_places
        ORDER BY naziv";

$polling_places = mysqli_query($spoj, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ime = trim($_POST['ime']);
    $prezime = trim($_POST['prezime']);
    $oib = trim($_POST['oib']);
    $legalna_adresa = trim($_POST['legalna_adresa']);
    $polling_place_id = $_POST['polling_place_id'];

    if (
        $ime == "" ||
        $prezime == "" ||
        $oib == "" ||
        $legalna_adresa == "" ||
        $polling_place_id == ""
    ) {

        $greska = "Sva polja su obavezna.";

    } else {

        $sql = "UPDATE voters
                SET ime = ?,
                    prezime = ?,
                    oib = ?,
                    legalna_adresa = ?,
                    polling_place_id = ?
                WHERE id = ?";

        $stmt = mysqli_prepare($spoj, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "ssssii",
            $ime,
            $prezime,
            $oib,
            $legalna_adresa,
            $polling_place_id,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {

            header('Location: dashboard.php');
            exit;

        } else {

            $greska = "Greška pri uređivanju birača.";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="hr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Uredi birača</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="page-wrapper">

        <div class="card">

            <h1>Uredi birača</h1>

            <?php

            if ($greska != "") {
                echo '<div class="error-box">' . $greska . '</div>';
            }

            ?>

            <form method="post" action="edit_voter.php?id=<?php echo $id; ?>">

                <div class="form-group">

                    <label for="ime">Ime</label>

                    <input
                        type="text"
                        id="ime"
                        name="ime"
                        value="<?php echo htmlspecialchars($voter['ime']); ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="prezime">Prezime</label>

                    <input
                        type="text"
                        id="prezime"
                        name="prezime"
                        value="<?php echo htmlspecialchars($voter['prezime']); ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="oib">OIB</label>

                    <input
                        type="text"
                        id="oib"
                        name="oib"
                        maxlength="11"
                        value="<?php echo htmlspecialchars($voter['oib']); ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="legalna_adresa">Adresa</label>

                    <input
                        type="text"
                        id="legalna_adresa"
                        name="legalna_adresa"
                        value="<?php echo htmlspecialchars($voter['legalna_adresa']); ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="polling_place_id">Biračko mjesto</label>

                    <select
                        id="polling_place_id"
                        name="polling_place_id"
                        required
                    >

                        <?php

                        while ($polling_place = mysqli_fetch_assoc($polling_places)) {

                            if ($polling_place['id'] == $voter['polling_place_id']) {

                                echo '<option value="' . $polling_place['id'] . '" selected>';

                            } else {

                                echo '<option value="' . $polling_place['id'] . '">';

                            }

                            echo htmlspecialchars($polling_place['naziv']);

                            echo '</option>';

                        }

                        ?>

                    </select>

                </div>

                <button type="submit">
                    Spremi promjene
                </button>

            </form>

            <a class="button-link" href="dashboard.php">
                Natrag
            </a>

        </div>

    </div>

</body>

</html>