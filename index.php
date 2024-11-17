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
    <title>Your Professional Agenda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }

        h2 {
            color: #333;
            font-size: 36px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            background-image: linear-gradient(to left, #ff5c8d, #6a82fb);
            -webkit-background-clip: text;
            color: transparent;
            animation: textAnimate 2s ease-out infinite;
        }

        @keyframes textAnimate {
            0% { background-position: -500% 0; }
            50% { background-position: 500% 0; }
            100% { background-position: -500% 0; }
        }

        .btn-primary, .btn-danger {
            font-size: 16px;
            padding: 14px;
            width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #6a82fb;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ff5c8d;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .table {
            background-color: white;
            margin-top: 20px;
        }

        .table th, .table td {
            text-align: center;
        }

        .table th {
            background-color: #6a82fb;
            color: white;
        }

        .table td {
            font-size: 14px;
            color: #333;
        }

        .sign-out-btn {
            text-align: center;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Your Agenda</h2>

        <a href="add_event.php" class="btn btn-primary">Add New Event</a> <!-- Link to add new event -->

        <h3 class="text-center">Events Calendar</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['title']); ?></td>
                        <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                        <td><?php echo htmlspecialchars($event['description']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Sign Out Button below the table -->
        <div class="sign-out-btn">
            <a href="logout.php" class="btn btn-primary">Sign Out</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
