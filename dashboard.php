<?php

require 'auth.php';
requireLogin();

require 'db.php';

$query = "";

if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
}

if ($query != "") {

    $sql = "SELECT voters.id,
                   voters.ime,
                   voters.prezime,
                   voters.oib,
                   voters.legalna_adresa,
                   polling_places.naziv AS biracko_mjesto
            FROM voters
            INNER JOIN polling_places
            ON polling_places.id = voters.polling_place_id
            WHERE voters.ime LIKE ?
            OR voters.prezime LIKE ?
            OR voters.oib LIKE ?
            OR voters.legalna_adresa LIKE ?
            OR polling_places.naziv LIKE ?
            ORDER BY voters.prezime, voters.ime";

    $stmt = mysqli_prepare($spoj, $sql);

    $search = "%" . $query . "%";

    mysqli_stmt_bind_param(
        $stmt,
        "sssss",
        $search,
        $search,
        $search,
        $search,
        $search
    );

    mysqli_stmt_execute($stmt);

    $voters = mysqli_stmt_get_result($stmt);

} else {

    $sql = "SELECT voters.id,
                   voters.ime,
                   voters.prezime,
                   voters.oib,
                   voters.legalna_adresa,
                   polling_places.naziv AS biracko_mjesto
            FROM voters
            INNER JOIN polling_places
            ON polling_places.id = voters.polling_place_id
            ORDER BY voters.prezime, voters.ime";

    $voters = mysqli_query($spoj, $sql);

}

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

    <div class="dashboard-wrapper">

        <div class="dashboard-card">

            <div class="dashboard-header">

                <div>
                    <h1>Popis birača</h1>

                    <p>
                        Prijavljeni korisnik:
                        <strong>
                            <?php echo $_SESSION['username']; ?>
                        </strong>
                    </p>
                </div>

                <a class="button-link" href="logout.php">
                    Odjava
                </a>

            </div>

            <?php

                if (isAdmin()) {

                    echo '<a class="button-link" href="add_voter.php">';
                    echo 'Dodaj birača';
                    echo '</a>';

                }

                ?>

            <form class="search-form" method="get" action="dashboard.php">

                <input
                    type="text"
                    name="query"
                    placeholder="Pretraži birače..."
                    value="<?php echo htmlspecialchars($query); ?>"
                >

                <button type="submit">
                    Pretraži
                </button>

            </form>

            <div class="table-container">

                <table>

                    <thead>

                        <tr>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>OIB</th>
                            <th>Adresa</th>
                            <th>Biračko mjesto</th>
                            <th>Akcije</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        if (mysqli_num_rows($voters) > 0) {

                            while ($voter = mysqli_fetch_assoc($voters)) {

                                echo "<tr>";

                                echo "<td>" . htmlspecialchars($voter['ime']) . "</td>";
                                echo "<td>" . htmlspecialchars($voter['prezime']) . "</td>";
                                echo "<td>" . htmlspecialchars($voter['oib']) . "</td>";
                                echo "<td>" . htmlspecialchars($voter['legalna_adresa']) . "</td>";
                                echo "<td>" . htmlspecialchars($voter['biracko_mjesto']) . "</td>";
                                echo "<td>";

                                    if (isAdmin()) {

                                        echo '<a class="table-link" href="edit_voter.php?id=' . $voter['id'] . '">';
                                        echo 'Uredi';
                                        echo '</a>';

                                        echo '<a class="table-link delete-link" href="delete_voter.php?id=' . $voter['id'] . '">';
                                        echo 'Obriši';
                                        echo '</a>';

                                    } else {

                                        echo "-";

                                    }

                                    echo "</td>";
                                echo "</tr>";

                            }

                        } else {

                            echo "<tr>";
                            echo "<td colspan='6'>Nema pronađenih birača.</td>";
                            echo "</tr>";

                        }

                        ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>