<?php
include "../../../assets/conn.php";
include "../../../assets/header.php";
include "../../../assets/bootstrap.php";

// Get the group ID from the URL
$groupId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$groupId) {
    die("Group ID not provided.");
}

// Fetching candidates for the specified group from the database
$query = "SELECT k.* 
          FROM Kandidaten k
          JOIN Kandidaten_has_Groepen kg ON k.id = kg.Kandidaten_id
          WHERE kg.Groepen_id = $groupId";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
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

        <form action="process_scores.php" method="post">

            <!-- Hidden input field to store the initially selected group ID -->
            <input type="hidden" name="group_id" id="group_id" value="<?php echo $groupId; ?>">

            <!-- Player selection dropdown -->
            <div class="form-group">
                <label for="player">Select Player:</label>
                <select class="form-control" name="player" id="player">
                    <?php
                    // Populate player options
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['naam']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Additional D E N score inputs and submit button -->
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
                <button type="submit" name="vulin" class="btn btn-success">Submit</button>
            </div>

        </form>
    </div>

    <!-- Bootstrap JS and Popper.js scripts (if needed) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>




