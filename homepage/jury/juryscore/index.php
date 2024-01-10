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
    $playerId = $_POST['player'];
    $dscore = $_POST['dscore'];
    $escore = $_POST['escore'];
    $nscore = $_POST['nscore'];

    // Bereken de totale score (D + E - N)
    $totalScore = $dscore + $escore - $nscore;

    $insertQuery = "INSERT INTO Punten (d_score, e_score, n_score, onderdeel, Groepen_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iiisi", $dscore, $escore, $nscore, $onderdeel, $groupId);

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
            <div class="form-group">
                <label for="player">Select Player:</label>
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

                <script>
                function goToHomepage() {
                    window.location.href = "/Turnen/turnenwebsite/homepage/admin";
                }

                function submitForm() {
                // Add your form validation logic if needed

                // Increment the selected player index
                var playerSelect = document.getElementById('player');
                var currentSelectedIndex = playerSelect.selectedIndex;

                // Select the next player (if available)
                if (currentSelectedIndex < playerSelect.options.length - 1) {
                    playerSelect.selectedIndex = currentSelectedIndex + 1;
                }

                // Submit the form
                document.forms[0].submit();
                }

                function goToHomepage() {
                    window.location.href = "/Turnen/turnenwebsite/homepage/admin";
                }
                </script>
            </div>
        </form>
    </div>
</body>
</html>




