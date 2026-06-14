<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: redirect.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 3 — $_SERVER</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 60px auto; background: #f5f5f5; }
        .card { background: #fff; border-radius: 8px; padding: 28px 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        h2 { margin-top: 0; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { text-align: left; padding: 10px 12px; border-bottom: 1px solid #eee; font-size: 0.9rem; }
        th { background: #f0f4f8; color: #555; width: 40%; }
        td { color: #333; word-break: break-all; }
        a { display: inline-block; margin-top: 20px; color: #4a90e2; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h2>Інформація про сервер та запит</h2>
    <table>
        <tr>
            <th>IP-адреса клієнта</th>
            <td><?= htmlspecialchars($_SERVER['REMOTE_ADDR']) ?></td>
        </tr>
        <tr>
            <th>Браузер (User Agent)</th>
            <td><?= htmlspecialchars($_SERVER['HTTP_USER_AGENT']) ?></td>
        </tr>
        <tr>
            <th>Назва скрипта</th>
            <td><?= htmlspecialchars($_SERVER['PHP_SELF']) ?></td>
        </tr>
        <tr>
            <th>Метод запиту</th>
            <td><?= htmlspecialchars($_SERVER['REQUEST_METHOD']) ?></td>
        </tr>
        <tr>
            <th>Шлях до файлу на сервері</th>
            <td><?= htmlspecialchars($_SERVER['SCRIPT_FILENAME']) ?></td>
        </tr>
    </table>
    <a href="redirect.php">← Повернутися</a>
</div>
</body>
</html>
