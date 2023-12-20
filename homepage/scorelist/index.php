

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

    .container-fluid {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 30px;
      height: 100vh;
      overflow-y: auto; /* Add scroll if content exceeds viewport height */
    }

    h2 {
      color: #007bff;
      font-size: 2.5em;
      margin-bottom: 20px;
    }

    table {
      background-color: #fff;
    }

    th, td {
      text-align: center;
      font-size: 1.5em;
    }

    th {
      background-color: #007bff;
      color: #fff;
    }

    tbody tr:nth-child(odd) {
      background-color: #f2f2f2;
    }

    tbody tr:hover {
      background-color: #e2e6ea;
    }
  </style>
  <title>Highscore List</title>
</head>
<body>

<div class="container-fluid">
  <h2>Turning Sport Highscore</h2>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Athlete</th>
        <th scope="col">D</th>
        <th scope="col">E</th>
        <th scope="col">N</th>
        <th scope="col">Score</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
        <td>John Doe</td>
        <td>3.0</td>
        <td>6.75</td>
        <td>9.0</td>
        <td>18.75</td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Jane Smith</td>
        <td>3.0</td>
        <td>6.50</td>
        <td>8.5</td>
        <td>18.00</td>
      </tr>
      <tr>
        <th scope="row">3</th>
        <td>Alex Turner</td>
        <td>3.0</td>
        <td>6.25</td>
        <td>9.0</td>
        <td>18.25</td>
      </tr>
      <tr>
        <th scope="row">4</th>
        <td>Sarah Johnson</td>
        <td>3.0</td>
        <td>6.00</td>
        <td>7.5</td>
        <td>16.50</td>
      </tr>
      <tr>
        <th scope="row">5</th>
        <td>Michael Brown</td>
        <td>3.0</td>
        <td>5.75</td>
        <td>8.0</td>
        <td>16.75</td>
      </tr>
      <!-- Add more rows as needed -->
    </tbody>
  </table>
</div>

</body>
</html>
