<?php
include "../../../assets/conn.php";

$groupId = isset($_GET['id']) ? $_GET['id'] : null;
$onderdeel = isset($_GET['onderdeel']) ? $_GET['onderdeel'] : null;

if (!$groupId || !$onderdeel) {
    die("Group ID or Onderdeel not provided.");
}

$query = "SELECT k.* 
          FROM Kandidaten k
          JOIN Kandidaten_has_Groepen kg ON k.id = kg.Kandidaten_id
          WHERE kg.Groepen_id = $groupId";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

// Verwerken van het formulier
if (isset($_POST['vulin'])) {
    print_r($_POST);
    $playerId = $_POST['player'];
    echo $playerId;
    $dscore = $_POST['dscore'];
    $escore = $_POST['escore'];
    $nscore = $_POST['nscore'];

    // Bereken de totale score (D + E - N)
    $totalScore = $dscore + $escore - $nscore;

    $insertQuery = "INSERT INTO Punten (d_score, e_score, n_score, onderdeel, Groepen_id, kandidaten_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iiisii", $dscore, $escore, $nscore, $onderdeel, $groupId, $playerId);

    if ($stmt->execute()) {
        $lastInsertId = $stmt->insert_id;

        $relationQuery = "INSERT INTO Punten_has_Kandidaten (Punten_id, Kandidaten_id) VALUES (?, ?)";
        $relationStmt = $conn->prepare($relationQuery);
        $relationStmt->bind_param("ii", $lastInsertId, $playerId);

        if ($relationStmt->execute()) {
            echo "Scores succesvol toegevoegd aan de database.";
        } else {
            echo "Fout bij het toevoegen van de relatie aan Punten_has_Kandidaten: " . $relationStmt->error;
        }

        $relationStmt->close();
    } else {
        echo "Fout bij het toevoegen van scores aan de database: " . $stmt->error;
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnen Scoring</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Turnen Scoring</h2>
        <form method="post">
            <input type="hidden" name="group_id" id="group_id" value="<?php echo $groupId; ?>">
            <?php
            // Fetch onderdeel from the database based on $groupId
            $onderdeelQuery = "SELECT onderdeel FROM punten WHERE Groepen_id = $groupId";
            $onderdeelResult = mysqli_query($conn, $onderdeelQuery);

            if ($onderdeelResult && $onderdeelRow = mysqli_fetch_assoc($onderdeelResult)) {
                $onderdeel = $onderdeelRow['onderdeel'];
            }
            ?>
            <div class="form-group">
                <label for="onderdeel">Onderdeel:</label>
                <input type="text" class="form-control" name="onderdeel" value="<?php echo $onderdeel; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="player">Select Kandidaat:</label>
                <select class="form-control" name="player" id="player">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['naam']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="green-background">
                <div class="form-group">
                    <input type="text" required autofocus name="dscore" placeholder="Vul D score in" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" required name="escore" placeholder="Vul E score in" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" required name="nscore" placeholder="Vul N score in" class="form-control">
                </div>
                <button type="submit" name="vulin" class="btn btn-success" onclick="submitForm()">Submit</button>
                <button onclick="goToHomepage()" class="btn btn-danger">Back</button>
            </div>
        </form>
    </div>
</body>
</html>





