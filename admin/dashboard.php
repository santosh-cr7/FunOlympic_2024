<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$username = $_SESSION['username'];

// Fetch counts from the database
$query_users = "SELECT COUNT(id) AS total_users FROM users";
$result_users = mysqli_query($conn, $query_users);
$total_users = mysqli_fetch_assoc($result_users)['total_users'];

$query_posts = "SELECT COUNT(id) AS total_posts FROM posts";
$result_posts = mysqli_query($conn, $query_posts);
$total_posts = mysqli_fetch_assoc($result_posts)['total_posts'];

$query_reservations = "SELECT COUNT(id) AS total_reservations FROM reservation";
$result_reservations = mysqli_query($conn, $query_reservations);
$total_reservations = mysqli_fetch_assoc($result_reservations)['total_reservations'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fun Olympic Paris 2024 - Dashboard</title>
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php include "sidebar.php" ?>

    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-solid rounded-lg dark:border-gray-700">
            <h2 class="text-3xl font-semibold mb-10" > Welcome to the Dashboard, <?php echo $username; ?> <i class="bi bi-person-circle"></i></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Widget 1: Total Users -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2">Total Users</h3>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-full p-3">
                            <i class="bi bi-people text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500">Total registered users on the platform.</p>
                            <p class="text-gray-700 font-semibold mt-1"><?php echo $total_users; ?></p>
                        </div>
                    </div>
                </div>
                <!-- Widget 2: Total Posts -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2">Total Posts</h3>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-full p-3">
                            <i class="bi bi-journal-text text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500">Total posts published on the website.</p>
                            <p class="text-gray-700 font-semibold mt-1"><?php echo $total_posts; ?></p>
                        </div>
                    </div>
                </div>
                <!-- Widget 3: Total Reservations -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2">Total Reservations</h3>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-full p-3">
                            <i class="bi bi-calendar-check text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500">Total reservations made by users.</p>
                            <p class="text-gray-700 font-semibold mt-1"><?php echo $total_reservations; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
