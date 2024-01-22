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
      overflow-y: auto;
      /* Add scroll if content exceeds viewport height */
    }

    h2 {
      color: #007bff;
      font-size: 2.5em;
      margin-bottom: 20px;
    }

    table {
      background-color: #fff;
    }

    th,
    td {
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

<script>

</script>

<body>

  <?php
  $groepsid = $_GET['groep'];

  ?>


  <div id="recent_score" class="container-fluid">
    <h2>Turning Sport Highscore</h2>
    <table class="table table-bordered table-striped" id="resultTable">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Athlete</th>
          <th scope="col">D</th>
          <th scope="col">E</th>
          <th scope="col">N</th>
          <th scope="col">Score</th>
          <th scope="col">Onderdeel</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td id='name'>John Doe</td>
          <td id='dScore'>3.0</td>
          <td id='eScore'>6.75</td>
          <td id='nScore'>9.0</td>
          <td id='totalScore'>18.75</td>
          <td id="onderdeel">Onderdeel</td>
        </tr>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>


  <div id="total_score" class="container mt-5">
    <h1 class="mb-4">Highscores</h1>

    <table id="scoreTable" class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Total Score</th>
        </tr>
      </thead>
      <tbody>
        <!-- Rows will be dynamically added here -->
      </tbody>
    </table>
  </div>

  <script>
    
    var currentUrl = window.location.href;
    var groepValue = currentUrl.split('=')

    function getHighScores1(groep) {
      const requestData = {
        type: 'totalscores',
        group_id: groep
      };

      return fetch('catch.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(requestData),
        })
        .then(response => response.json())
        .then(data => {
          console.log('API Response:', data);
          return data; 
        })
        .catch(error => {
          console.error('Error:', error);
          throw error; 
        });
    }
    var responseData;

    function getLatestScore1(groep) {
      const requestData = {
        type: 'recentscore',
        group_id: groep
      };

      return new Promise((resolve, reject) => {
        fetch('catch.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestData),
          })
          .then(response => response.json())
          .then(data => {
            console.log('API Response:', data);
            responseData = data;
            resolve();
          })
          .catch(error => {
            console.error('Error:', error);
            reject(error);
          });
      });
    }

  


    let screens = false;
    switchScreens();
    function updateTable(apiResponse) {
      const tableBody = document.getElementById('scoreTable').getElementsByTagName('tbody')[0];

      tableBody.innerHTML = '';

      let index = 1;
      for (const playerId in apiResponse) {
        if (apiResponse.hasOwnProperty(playerId)) {
          const playerName = 'Player ' + playerId; 
          const playerScore = apiResponse[playerId];

          const newRow = tableBody.insertRow();

          const cellNumber = newRow.insertCell(0);
          const cellName = newRow.insertCell(1);
          const cellScore = newRow.insertCell(2);

          cellNumber.textContent = index++;
          cellName.textContent = playerName;
          cellScore.textContent = playerScore;
        }
      }
    }


    function switchScreens() {
      if (screens) {
        getLatestScore1(groepValue[1])
          .then(() => {
            document.getElementById("name").innerHTML = responseData[0]['naam'];
            document.getElementById("dScore").innerHTML = responseData[0]['d_score'];
            document.getElementById("eScore").innerHTML = responseData[0]['e_score'];
            document.getElementById("nScore").innerHTML = responseData[0]['n_score'];
            document.getElementById("onderdeel").innerHTML = responseData[0]['onderdeel']
            document.getElementById("totalScore").innerHTML = responseData[0]['d_score'] + responseData[0]['e_score'] - responseData[0]['n_score'];
            document.getElementById('recent_score').style.display = '';
            document.getElementById('total_score').style.display = 'none';
            screens = false;
          })
      } else {
        getHighScores1(groepValue[1]).then(apiResponse => {
          updateTable(apiResponse);
          document.getElementById('recent_score').style.display = 'none';
          document.getElementById('total_score').style.display = '';
          screens = true;
        })
        .catch(error => {
          console.error('Error during API request:', error);
        })
      }
    }

    setInterval(switchScreens, 5000);
  </script>



</body>

</html>