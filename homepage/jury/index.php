<?php
include "../../assets/conn.php";
include "../../assets/header.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <title>Jury Page</title>
  <style>
    body {
      background-color: #f8f9fa; /* Subtle background color */
    }

    .card {
      background-color: #fff; /* White background for cards */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Box shadow for a lifted effect */
      margin-bottom: 20px; /* Added margin to create space between cards */
    }

    .card-title {
      color: #007bff; /* Blue title color */
    }

    .btn-primary {
      background-color: #007bff; /* Blue button color */
      border-color: #007bff; /* Border color */
    }

    .btn-primary:hover {
      background-color: #0056b3; /* Darker blue on hover */
      border-color: #0056b3; /* Darker border on hover */
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2>Jury Page</h2>

  <div class="row">

  <?php
$sql = "SELECT * FROM groepen";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        if ($count % 4 == 0) {
            // Start a new row after every 4 cards
            echo '</div><div class="row">';
        }

        echo '<div class="col-md-3">
                <div class="card">
                  <div class="card-body text-center">
                    <h5 class="card-title mb-3">'.$row['groep'].'</h5>';

        // Voeg de knoppen toe voor de gewenste onderdelen
        $onderdelen = array('Vloer', 'Voltige', 'Ringen', 'Sprong', 'Brug', 'Rekstok');
        foreach ($onderdelen as $onderdeel) {
            echo '<a href="juryscore/?id='. $row['id'].'&onderdeel='.$onderdeel.'" class="btn btn-primary mt-1 mb-1">'.$onderdeel.'</a><br>';
        }

        echo '</div>
            </div>
          </div>';
        $count++;
    }
}
?>


</div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
