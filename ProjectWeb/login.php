<?php
session_start();
include 'koneksi.php';

// Proses login jika form disubmit
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (md5($password) === $user['password']) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #111;
            font-family: Arial, sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: #222;
            padding: 30px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        input[type="text"], input[type="password"], button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #333;
            border: none;
            color: white;
            font-size: 14px;
        }

        button {
            background-color: #555;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        button:hover {
            background-color: #111;
        }

        .error {
            color: #f44336;
            margin-top: 10px;
        }
    </style>

</head>
<body>
<div class="login-box">
    <h2>Login Admin</h2>
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</
