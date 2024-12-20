<?php
include('connecter.php');

// Fetch all players and their ages
$query = "SELECT id, name, age FROM joueurs";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    // Initialize group arrays
    $groupA = [];
    $groupB = [];
    $groupD = [];

    // Loop through players and assign them to groups based on age
    while ($row = $result->fetch_assoc()) {
        if ($row['age'] >= 8 && $row['age'] <= 11) {
            $groupA[] = $row;
        } elseif ($row['age'] >= 12 && $row['age'] <= 15) {
            $groupB[] = $row;
        } elseif ($row['age'] >= 16 && $row['age'] <= 18) {
            $groupD[] = $row;
        }
    }

    // Now you can insert players into groups
    // Example for Group A (similar for Group B and Group D)
    foreach ($groupA as $player) {
        $group_name = 'A'; // Group A
        $player_id = $player['id'];

        // Insert into groups table
        $stmt = $mysqli->prepare("INSERT INTO groups (joueur_id, group_name) VALUES (?, ?)");
        $stmt->bind_param("is", $player_id, $group_name);

        if ($stmt->execute()) {
            echo "Player " . $player['name'] . " assigned to Group A.<br>";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
    }

    // Repeat the same for Group B and Group D
    foreach ($groupB as $player) {
        $group_name = 'B'; // Group B
        $player_id = $player['id'];

        $stmt = $mysqli->prepare("INSERT INTO groups (joueur_id, group_name) VALUES (?, ?)");
        $stmt->bind_param("is", $player_id, $group_name);

        if ($stmt->execute()) {
            echo "Player " . $player['name'] . " assigned to Group B.<br>";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
    }

    foreach ($groupD as $player) {
        $group_name = 'D'; // Group D
        $player_id = $player['id'];

        $stmt = $mysqli->prepare("INSERT INTO groups (joueur_id, group_name) VALUES (?, ?)");
        $stmt->bind_param("is", $player_id, $group_name);

        if ($stmt->execute()) {
            echo "Player " . $player['name'] . " assigned to Group D.<br>";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
    }
} else {
    echo "No players found.";
}

$mysqli->close();
?>
