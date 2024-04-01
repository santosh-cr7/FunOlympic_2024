<?php
session_start();
include "connection.php";

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to index.php if already logged in
    exit();
}

// Authentication logic for login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['g-recaptcha-response'])) {
    $secretkey = "6Leei2AoAAAAAIhxCM6r-o5TquBrZyHWQyLYAQtg";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = $_POST['g-recaptcha-response'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$response&remoteip=$ip";
    $request = file_get_contents($url);
    $data = json_decode($request);
    $a = $_POST['username'];
    $b = md5($_POST['password']);

    if ($data->success == false) {
        echo "<script>alert('Please complete the reCAPTCHA verification.');</script>";
    } elseif ($a == '' || $b == '') {
        echo "<script>alert('Some fields are empty!');</script>";
    } else {
        $query = "SELECT * FROM users WHERE username='$a' AND password='$b'";
        $run = mysqli_query($conn, $query);
        if (mysqli_num_rows($run) > 0) {
            $_SESSION['username'] = $a;
            // Redirect to index.php after successful login
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Invalid User!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fun Olympic Paris 2024</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg form-container">
            <!-- Your inherited form code -->
            <form class="space-y-4" action="login.php" method="post">
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your username</label>
                    <input type="username" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="username" required />
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                </div>
                <div class="flex justify-between">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required />
                        </div>
                        <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                    </div>
                    <a href="forgot-password.php" class="text-sm text-blue-700 hover:underline dark:text-blue-500">Lost Password?</a>
                </div>
                <div class="g-recaptcha" data-sitekey="6Leei2AoAAAAAFcQOfwIcx4kCHg8FbHdMOKexmZB"></div>
                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login to your account</button>
                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                    Not registered? <a href="signup.php" class="cursor-pointer text-blue-700 hover:underline dark:text-blue-500">Create account</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
