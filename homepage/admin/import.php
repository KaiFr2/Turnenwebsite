<?php

include "../../assets/conn.php";
include "../../assets/header.php";

if ($_FILES["file"]["error"] > 0) {
    die("Error uploading file: " . $_FILES["file"]["error"]);
}

$fileName = $_FILES["file"]["name"];
$filePath = $_FILES["file"]["tmp_name"];

if (($handle = fopen($filePath, "r")) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        // Assuming the CSV has a single column named "name"
        $name = $data[0];

        // Insert data into MySQL database
        $sql = "INSERT INTO your_table_name (name) VALUES ('$name')";
        if ($conn->query($sql) !== true) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    fclose($handle);
    echo "Data inserted successfully!";
} else {
    echo "Error reading CSV file";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV File Upload</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Upload CSV</h2>
                </div>
                <div class="card-body">
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="group_name">Groep Naam:</label>
                            <input type="text" class="form-control" id="group_name" name="group_name" required>
                        </div>
                        <div class="form-group">
                            <label for="file">Kies uw CSV bestand:</label>
                            <input type="file" class="form-control-file" id="file" name="file" accept=".csv" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>