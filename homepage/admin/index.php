<?php
include "../../assets/conn.php";
include "../../assets/header.php";  


if(isset($_POST['submit'])) {
  $succesfull = true;
  
  // Groepsinformatie
  $groepsnaam = isset($_POST['groupName']) ? htmlspecialchars($_POST['groupName']) : '';
  $onderdeel = isset($_POST['onderdeel']) ? htmlspecialchars($_POST['onderdeel']) : '';

  // Voeg de groep toe aan de Groepen-tabel
  $stmt = $conn->prepare("INSERT INTO groepen (groep, onderdeel) VALUES (?, ?)");
  $stmt->bind_param("ss", $groepsnaam, $onderdeel);
  if ($stmt->execute()) {
      $succesfull = true;
      $groeps_id = mysqli_insert_id($conn);
  } else {
      $succesfull = false;
  }

  // Spelerinformatie
  $playerCount = count($_POST['player']);
  $latest_id_array = array(); // Initialiseer de array buiten de loop
  for ($i = 0; $i <= $playerCount - 1; $i++) {
      $spelersnaam = isset($_POST['player'][$i]) ? htmlspecialchars($_POST['player'][$i]) : '';
      $stmt = $conn->prepare("INSERT INTO kandidaten (naam) VALUES (?)");
      $stmt->bind_param("s", $spelersnaam);
      if ($stmt->execute()) {
          $latest_id_array[] = mysqli_insert_id($conn);
      } else {
          $succesfull = false;
      }
  }

  // Koppel speler aan groep
  foreach ($latest_id_array as $kandidaten_id) {
      $stmt = $conn->prepare("INSERT INTO kandidaten_has_groepen (Kandidaten_id, Groepen_id) VALUES (?, ?)");
      $stmt->bind_param("ii", $kandidaten_id, $groeps_id);
      if ($stmt->execute()) {
          echo "true";
      } else {
          echo "false";
      }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 30px;
      margin-top: 50px;
    }

    h2 {
      color: #007bff;
      text-align: center;
    }

    form {
      margin-top: 20px;
    }

    label {
      font-weight: bold;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .btn-primary {
      width: 100%;
    }
  </style>
  <title>Team Information</title>
</head>
<body>

<div class="container">
  <h2>Team Informatie</h2>
  <form method='post'>
    <div class="form-group">
      <label for="groupName">Groep Naam:</label>
      <input type="text" class="form-control" name="groupName" placeholder="Vul groep naam in">
    </div>

    <div class="form-group">
      <label for="onderdeel">Onderdeel:</label>
      <input type="text" class="form-control" name="onderdeel" placeholder="Vul het onderdeel in">
    </div>

    <div id="playersContainer">
  <!-- Player fields will be dynamically added here -->
  <div class="form-group">
    <label for="player1">Speler 1:</label>
    <input type="text" class="form-control" name="player[]" placeholder="Vul naam in">
  </div>
</div>

<button type="button" id="addPlayer" class="btn btn-success">Voeg Speler Toe</button>
<button type="submit" name="submit" class="btn btn-primary">Submit</button>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
  $(document).ready(function () {
    var maxPlayers = 10; // Set the maximum number of players
    var playerCount = 1;

    $("#addPlayer").click(function () {
      // Check if the maximum number of players is reached
      if (playerCount < maxPlayers) {
        playerCount++;
        var newPlayerField = '<div class="form-group">' +
                              '<label for="player' + playerCount + '">Speler ' + playerCount + ':</label>' +
                              '<input type="text" class="form-control" name="player[]" placeholder="Vul naam in">' +
                              '</div>';
        $("#playersContainer").append(newPlayerField);
      } else {
        alert("Je kunt niet meer spelers toevoegen.");
      }
    });
  });
</script>
</div>

