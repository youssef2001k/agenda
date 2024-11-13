<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle adding new events
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];

    $stmt = $pdo->prepare("INSERT INTO events (user_id, title, description, event_date) VALUES (:user_id, :title, :description, :event_date)");
    $stmt->execute(['user_id' => $user_id, 'title' => $title, 'description' => $description, 'event_date' => $event_date]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Event</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Add New Event</h2>
        <form action="add_event.php" method="POST">
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Event Title" required>
            </div>
            <div class="form-group">
                <input type="date" name="event_date" class="form-control" required>
            </div>
            <div class="form-group">
                <textarea name="description" class="form-control" placeholder="Event Description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Event</button>
            <a href<?php
