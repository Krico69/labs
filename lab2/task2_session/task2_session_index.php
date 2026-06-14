<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 2 — $_SESSION</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 60px auto; background: #f5f5f5; }
        .card { background: #fff; border-radius: 8px; padding: 28px 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        h2 { margin-top: 0; color: #333; }
        label { display: block; font-size: 0.875rem; color: #555; margin-top: 14px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; box-sizing: border-box; margin-top: 6px; }
        button { margin-top: 20px; padding: 10px 24px; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; }
        .btn-primary { background: #4a90e2; color: #fff; }
        .btn-danger  { background: #e74c3c; color: #fff; }
        .greeting { color: #27ae60; font-size: 1.2rem; }
        .error { color: #c0392b; background: #fdecea; border: 1px solid #f5c6c6; border-radius: 6px; padding: 10px 14px; margin-bottom: 12px; }
    </style>
</head>
<body>
<div class="card">
<?php

session_start();

$validLogin    = 'admin';
$validPassword = '1234';

if (isset($_POST['login'])) {
    $login    = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($login === $validLogin && $password === $validPassword) {
        $_SESSION['user']       = $login;
        $_SESSION['logged_in']  = true;
        $_SESSION['login_time'] = date('H:i:s');
    } else {
        $error = "Невірний логін або пароль.";
    }
}

if (!empty($_SESSION['logged_in'])) {
    $user = htmlspecialchars($_SESSION['user']);
    $time = htmlspecialchars($_SESSION['login_time']);
    echo "<h2 class='greeting'>Ласкаво просимо, {$user}! 🎉</h2>";
    echo "<p>Ви увійшли о <strong>{$time}</strong>.</p>";
    echo "<form method='POST' action='logout.php'><button class='btn-danger'>Вийти</button></form>";
} else {
    if (!empty($error)) {
        echo "<div class='error'>" . htmlspecialchars($error) . "</div>";
    }
    echo "<h2>Вхід у систему</h2>";
    echo "
    <form method='POST'>
        <label>Логін</label>
        <input type='text' name='username' placeholder='admin'>
        <label>Пароль</label>
        <input type='password' name='password' placeholder='1234'>
        <button class='btn-primary' name='login'>Увійти</button>
    </form>
    <p style='color:#888;font-size:0.85rem;margin-top:16px;'>Тестові дані: логін <b>admin</b>, пароль <b>1234</b></p>";
}
?>
</div>
</body>
</html>
