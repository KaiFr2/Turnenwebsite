<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('../assets/bootstrap.php'); ?>
    <?php include('../assets/textstyling.php'); ?>  
    <?php include('../assets/conn.php'); ?>  
</head>
<body>
<?php include('../assets/header.php'); ?> 
<div class="centered-form">
  <form method="post" action="">
  <div class="green-background">
    <input type="text" required autofocus="" name="dscore" placeholder="Vul D score in" class="form-control">
    <input type="text" required name="escore" placeholder="Vul E score in" class="form-control">
    <input type="text" required name="nscore" placeholder="Vul N score in" class="form-control">
    <button type="submit" name="vulin" class="btn btn-success">Submit</button>
  </form>
</body>
</html>