<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 480px;
            margin: 60px auto;
            padding: 0 20px;
            background: #f5f5f5;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            padding: 28px 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .card h2 {
            margin-top: 0;
            color: #333;
        }

        .error {
            color: #c0392b;
            background: #fdecea;
            border: 1px solid #f5c6c6;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 12px;
        }

        .success {
            color: #27ae60;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #4a90e2;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="card">
<?php

// Перевіряємо, чи запит прийшов методом POST (тобто форма була відправлена)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Отримуємо дані з форми та очищаємо їх від зайвих пробілів
    $firstName = trim($_POST["firstName"] ?? "");
    $lastName  = trim($_POST["lastName"]  ?? "");

    // Масив для накопичення помилок валідації
    $errors = [];

    // --- Перевірка імені ---

    // Поле не може бути порожнім
    if ($firstName === "") {
        $errors[] = "Поле «Ім'я» не може бути порожнім.";
    }
    // Ім'я має складатись лише з літер (підтримка кирилиці та латиниці)
    elseif (!preg_match('/^[\p{L}\s\-]+$/u', $firstName)) {
        $errors[] = "Поле «Ім'я» повинно містити лише літери.";
    }

    // --- Перевірка прізвища ---

    if ($lastName === "") {
        $errors[] = "Поле «Прізвище» не може бути порожнім.";
    } elseif (!preg_match('/^[\p{L}\s\-]+$/u', $lastName)) {
        $errors[] = "Поле «Прізвище» повинно містити лише літери.";
    }

    // --- Вивід результату ---

    if (!empty($errors)) {
        // Якщо є помилки — показуємо їх
        echo "<h2>Помилка введення</h2>";
        foreach ($errors as $error) {
            // htmlspecialchars захищає від XSS-атак
            echo "<div class='error'>" . htmlspecialchars($error) . "</div>";
        }
        echo "<a href='index.html'>← Повернутися до форми</a>";
    } else {
        // Екрануємо дані перед виводом для безпеки
        $safeFirst = htmlspecialchars($firstName);
        $safeLast  = htmlspecialchars($lastName);

        // Виводимо привітання
        echo "<p class='success'>Вітаємо, {$safeFirst} {$safeLast}!</p>";
        echo "<p>Ваші дані успішно отримано та оброблено.</p>";
        echo "<a href='index.html'>← Повернутися до форми</a>";
    }

} else {
    // Якщо хтось відкрив process.php напряму (не через форму)
    echo "<p>Будь ласка, заповніть форму.</p>";
    echo "<a href='index.html'>← До форми</a>";
}
?>
</div>
</body>
</html>
