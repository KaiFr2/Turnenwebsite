<?php
//header('location: ./Admin/');
include "../../assets/conn.php";
include "../../assets/textstyling.php";
$sql = "SELECT * FROM groepen";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        if ($count % 4 == 0) {
            echo '</div><div class="row">';
        }

        echo '<div class="col-md-3">
                <div class="card">
                  <div class="card-body text-center">';
        echo '<a href="scorelist.php?groep=' . $row['id'] . '" class="btn btn-primary">' . $row['groep'] . '</a>';

    }
    }