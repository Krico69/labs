<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Ласкаво просимо</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; border-radius: 10px; padding: 40px 44px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); width: 100%; max-width: 480px; text-align: center; }
        .avatar { width: 72px; height: 72px; background: #4a90e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #fff; margin: 0 auto 20px; }
        h2 { color: #27ae60; margin: 0 0 8px; }
        p { color: #666; margin: 6px 0; }
        .info-box { background: #f8f9fa; border-radius: 8px; padding: 16px 20px; margin: 20px 0; text-align: left; }
        .info-box p { margin: 6px 0; font-size: 0.95rem; }
        .info-box span { color: #333; font-weight: bold; }
        .btn-logout { display: inline-block; margin-top: 8px; padding: 10px 28px; background: #e74c3c; color: #fff; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; text-decoration: none; }
        .btn-logout:hover { background: #c0392b; }
    </style>
</head>
<body>
<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$username = htmlspecialchars($_SESSION['username']);
$email    = htmlspecialchars($_SESSION['email']);
$userId   = (int)$_SESSION['user_id'];
?>
<div class="card">
    <div class="avatar"><?= mb_strtoupper(mb_substr($username, 0, 1)) ?></div>

    <h2>Ласкаво просимо!</h2>
    <p>Ви успішно авторизувались у системі.</p>

    <div class="info-box">
        <p>👤 Ім'я користувача: <span><?= $username ?></span></p>
        <p>📧 Email: <span><?= $email ?></span></p>
        <p>🆔 ID: <span><?= $userId ?></span></p>
    </div>

    <a href="logout.php" class="btn-logout">Вийти</a>
</div>
</body>
</html>
