<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Вхід</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; border-radius: 10px; padding: 36px 40px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); width: 100%; max-width: 420px; }
        h2 { margin: 0 0 24px; color: #333; text-align: center; }
        label { display: block; font-size: 0.85rem; color: #555; margin-bottom: 5px; margin-top: 14px; }
        input[type="text"], input[type="password"] {
            width: 100%; padding: 10px 12px; border: 1px solid #ccc;
            border-radius: 6px; font-size: 1rem;
        }
        input:focus { outline: none; border-color: #4a90e2; }
        button { width: 100%; margin-top: 22px; padding: 11px; background: #4a90e2; color: #fff; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; }
        button:hover { background: #357abd; }
        .msg-error { background: #fdecea; color: #c0392b; border: 1px solid #f5c6c6; border-radius: 6px; padding: 10px 14px; margin-bottom: 14px; font-size: 0.9rem; }
        .link { text-align: center; margin-top: 18px; font-size: 0.9rem; color: #888; }
        .link a { color: #4a90e2; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h2>Вхід у систему</h2>

    <?php
    session_start();

    if (!empty($_SESSION['user_id'])) {
        header('Location: welcome.php');
        exit;
    }

    require_once 'db.php';

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            $error = "Будь ласка, заповніть всі поля.";
        } else {

            $stmt = $conn->prepare(
                "SELECT id, username, email, password FROM users WHERE username = ?"
            );
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();


                if (md5($password) === $user['password']) {
                    $_SESSION['user_id']  = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email']    = $user['email'];

                    header('Location: welcome.php');
                    exit;
                } else {
                    $error = "Невірний пароль.";
                }
            } else {
                $error = "Користувача з таким іменем не знайдено.";
            }

            $stmt->close();
        }
    }

    if ($error) echo "<div class='msg-error'>$error</div>";
    ?>

    <form method="POST" action="login.php">
        <label>Ім'я користувача</label>
        <input type="text" name="username" placeholder="Ваш логін"
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

        <label>Пароль</label>
        <input type="password" name="password" placeholder="Ваш пароль">

        <button type="submit">Увійти</button>
    </form>

    <p class="link">Немає акаунту? <a href="register.php">Зареєструватися</a></p>
</div>
</body>
</html>
