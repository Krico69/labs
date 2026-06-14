<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Реєстрація</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; border-radius: 10px; padding: 36px 40px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); width: 100%; max-width: 420px; }
        h2 { margin: 0 0 24px; color: #333; text-align: center; }
        label { display: block; font-size: 0.85rem; color: #555; margin-bottom: 5px; margin-top: 14px; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; padding: 10px 12px; border: 1px solid #ccc;
            border-radius: 6px; font-size: 1rem;
        }
        input:focus { outline: none; border-color: #4a90e2; }
        button { width: 100%; margin-top: 22px; padding: 11px; background: #4a90e2; color: #fff; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; }
        button:hover { background: #357abd; }
        .msg-error { background: #fdecea; color: #c0392b; border: 1px solid #f5c6c6; border-radius: 6px; padding: 10px 14px; margin-bottom: 14px; font-size: 0.9rem; }
        .msg-ok    { background: #eafaf1; color: #27ae60; border: 1px solid #a9dfbf; border-radius: 6px; padding: 10px 14px; margin-bottom: 14px; font-size: 0.9rem; }
        .link { text-align: center; margin-top: 18px; font-size: 0.9rem; color: #888; }
        .link a { color: #4a90e2; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h2>Реєстрація</h2>

    <?php
    session_start();
    require_once 'db.php';

    $error   = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($email) || empty($password)) {
            $error = "Будь ласка, заповніть всі поля.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Невірний формат електронної пошти.";
        } elseif (strlen($password) < 4) {
            $error = "Пароль має містити не менше 4 символів.";
        } else {

            $hashedPassword = md5($password);

            $stmt = $conn->prepare(
                "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
            );
            $stmt->bind_param('sss', $username, $email, $hashedPassword);

            if ($stmt->execute()) {
                $success = "Реєстрація успішна! <a href='login.php'>Увійти</a>";
            } else {)
                if ($conn->errno === 1062) {
                    $error = "Користувач з таким іменем або email вже існує.";
                } else {
                    $error = "Помилка при реєстрації: " . $stmt->error;
                }
            }
            $stmt->close();
        }
    }

    if ($error)   echo "<div class='msg-error'>$error</div>";
    if ($success) echo "<div class='msg-ok'>$success</div>";
    ?>

    <form method="POST" action="register.php">
        <label>Ім'я користувача</label>
        <input type="text" name="username" placeholder="Наприклад: ivan_petrov" maxlength="50"
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

        <label>Електронна пошта</label>
        <input type="email" name="email" placeholder="example@gmail.com" maxlength="100"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label>Пароль</label>
        <input type="password" name="password" placeholder="Мінімум 4 символи">

        <button type="submit">Зареєструватися</button>
    </form>

    <p class="link">Вже є акаунт? <a href="login.php">Увійти</a></p>
</div>
</body>
</html>
