<?php
include "../../assets/conn.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents("php://input"), true);

    // var_dump($requestData);

    if (isset($requestData['type']) && isset($requestData['group_id'])) {
        $type = $requestData['type'];
        $groupID = $requestData['group_id'];
    }
    
    if ($type === 'totalscores') {
        $sql = "SELECT * FROM punten LEFT JOIN kandidaten ON punten.kandidaten_id = kandidaten.id WHERE Groepen_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $groupID);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $result = [];

        foreach ($data as $entry) {
            $kandidaten_id = $entry["naam"];
            $score = $entry["d_score"] + $entry["e_score"] - $entry["n_score"];
            $naam = $entry["naam"];

            if (isset($result[$kandidaten_id])) {
                $result[$kandidaten_id] += $score;
            }       else {
                $result[$kandidaten_id] = $score;
            }
        }
        arsort($result);
        echo json_encode($result);
    } elseif ($type === 'recentscore') {
        $query = "SELECT * FROM punten LEFT JOIN kandidaten ON punten.kandidaten_id= kandidaten.id WHERE Groepen_id = ? ORDER BY punten.id DESC LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $groupID);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($data);
    }
    elseif ($type === 'getName') {
        $query = "SELECT * FROM kandidaten WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $userid);
        $stmt->execute();
    } else {
        $response = array('error' => 'Invalid request type');
        echo json_encode($response);
        exit;
    }
}
    
?>