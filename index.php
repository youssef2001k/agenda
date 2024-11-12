<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user events
$stmt = $pdo->prepare("SELECT * FROM events WHERE user_id = :user_id ORDER BY event_date");
$stmt->execute(['user_id' => $user_id]);
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Agenda</title>
    <style>
        /* Simple styles for the calendar */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Your Agenda</h2>
    <a href="logout.php">Sign Out</a>

    <!-- Display Events in Calendar Format -->
    <h3>Events Calendar</h3>
    <table>
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Description</th>
        </tr>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?php echo htmlspecialchars($event['title']); ?></td>
                <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                <td><?php echo htmlspecialchars($event['description']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Add New Event</h3>
    <form action="index.php" method="POST">
        <input type="text" name="title" placeholder="Event Title" required><br>
        <input type="date" name="event_date" required><br>
        <textarea name="description" placeholder="Event Description"></textarea><br>
        <button type="submit">Add Event</button>
    </form>

    <?php
    // Handle adding new events
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $event_date = $_POST['event_date'];

        $stmt = $pdo->prepare("INSERT INTO events (user_id, title, description, event_date) VALUES (:user_id, :title, :description, :event_date)");
        $stmt->execute(['user_id' => $user_id, 'title' => $title, 'description' => $description, 'event_date' => $event_date]);

        header('Location: index.php');
    }
    ?>
</body>

</html>