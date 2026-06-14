<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лабораторна робота №3 — ООП у PHP</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 40px auto; background: #f5f5f5; padding: 0 16px; }
        h1 { color: #333; font-size: 1.4rem; }
        h2 { color: #444; font-size: 1.1rem; margin-top: 28px; border-bottom: 2px solid #e0e0e0; padding-bottom: 6px; }
        .card { background: #fff; border-radius: 8px; padding: 20px 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); margin-bottom: 16px; }
        .ok      { color: #27ae60; }
        .error   { color: #c0392b; background: #fdecea; border-radius: 5px; padding: 6px 12px; display: inline-block; }
        .balance { font-weight: bold; color: #2c3e50; }
        .op      { margin: 6px 0; font-size: 0.95rem; }
        .label   { color: #888; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }
    </style>
</head>
<body>

<h1>Лабораторна робота №3 — ООП: Банківські рахунки</h1>

<?php

require_once 'BankAccount.php';
require_once 'SavingsAccount.php';


// 1. Тестування BankAccount

?>
<h2>1. Базовий рахунок (BankAccount)</h2>
<div class="card">
<p class="label">Операції зі звичайним рахунком</p>
<?php

try {
    $account = new BankAccount(1000, 'UAH');
    echo "<p class='op'>✅ Рахунок створено. <span class='balance'>" . $account . "</span></p>";

    $account->deposit(500);
    echo "<p class='op ok'>➕ Поповнення на 500 UAH. Баланс: <span class='balance'>{$account->getBalance()} UAH</span></p>";

    $account->withdraw(300);
    echo "<p class='op ok'>➖ Зняття 300 UAH. Баланс: <span class='balance'>{$account->getBalance()} UAH</span></p>";

} catch (Exception $e) {
    echo "<p class='error'>❌ Помилка: " . $e->getMessage() . "</p>";
}

?>
</div>

<!-- 2. Тестування винятків BankAccount                      -->

<h2>2. Обробка винятків (BankAccount)</h2>
<div class="card">
<p class="label">Некоректні операції — очікуємо винятки</p>
<?php

// --- Тест 1. зняття більше ніж є на рахунку ---
try {
    $acc = new BankAccount(200, 'UAH');
    echo "<p class='op'>Рахунок: <span class='balance'>" . $acc . "</span></p>";
    $acc->withdraw(500); // має кинути виняток
} catch (Exception $e) {
    echo "<p class='op'><span class='error'>❌ Зняття 500 UAH → {$e->getMessage()}</span></p>";
}

// --- Тест 2. поповнення від'ємною сумою ---
try {
    $acc2 = new BankAccount(100, 'UAH');
    $acc2->deposit(-50); // має кинути виняток
} catch (Exception $e) {
    echo "<p class='op'><span class='error'>❌ Поповнення -50 UAH → {$e->getMessage()}</span></p>";
}

// --- Тест 3. зняття від'ємної суми ---
try {
    $acc3 = new BankAccount(100, 'UAH');
    $acc3->withdraw(-10); // має кинути виняток
} catch (Exception $e) {
    echo "<p class='op'><span class='error'>❌ Зняття -10 UAH → {$e->getMessage()}</span></p>";
}

// --- Тест 4. від'ємний початковий баланс ---
try {
    $acc4 = new BankAccount(-500, 'UAH'); // має кинути виняток
} catch (Exception $e) {
    echo "<p class='op'><span class='error'>❌ Початковий баланс -500 → {$e->getMessage()}</span></p>";
}

?>
</div>

<!-- КРОК 3. Тестування SavingsAccount                            -->

<h2>3. Накопичувальний рахунок (SavingsAccount)</h2>
<div class="card">
<p class="label">Спадкування + статична відсоткова ставка</p>
<?php

try {

    $rate = SavingsAccount::getInterestRate() * 100;
    echo "<p class='op'>📊 Поточна відсоткова ставка: <span class='balance'>{$rate}%</span></p>";

    $savings = new SavingsAccount(2000, 'UAH');
    echo "<p class='op'>✅ Рахунок створено. <span class='balance'>" . $savings . "</span></p>";

    $savings->deposit(1000);
    echo "<p class='op ok'>➕ Поповнення на 1000 UAH. Баланс: <span class='balance'>{$savings->getBalance()} UAH</span></p>";

    $savings->applyInterest();
    echo "<p class='op ok'>💰 Нараховано відсотки ({$rate}%). Баланс: <span class='balance'>{$savings->getBalance()} UAH</span></p>";

    $savings->withdraw(500);
    echo "<p class='op ok'>➖ Зняття 500 UAH. Баланс: <span class='balance'>{$savings->getBalance()} UAH</span></p>";

} catch (Exception $e) {
    echo "<p class='error'>❌ Помилка: " . $e->getMessage() . "</p>";
}

?>
</div>


<!-- КРОК 4. Зміна відсоткової ставки (статична властивість)      -->

<h2>4. Статична властивість — зміна ставки для всіх рахунків</h2>
<div class="card">
<p class="label">Демонстрація що static впливає на всі екземпляри</p>
<?php

try {
    $s1 = new SavingsAccount(1000, 'USD');
    $s2 = new SavingsAccount(5000, 'EUR');

    echo "<p class='op'>Рахунок 1: <span class='balance'>" . $s1 . "</span></p>";
    echo "<p class='op'>Рахунок 2: <span class='balance'>" . $s2 . "</span></p>";

    SavingsAccount::setInterestRate(0.10); // 10%
    $newRate = SavingsAccount::getInterestRate() * 100;
    echo "<p class='op ok'>🔧 Ставку змінено на <strong>{$newRate}%</strong> для всіх рахунків.</p>";

    $s1->applyInterest();
    $s2->applyInterest();

    echo "<p class='op'>Рахунок 1 після нарахування: <span class='balance'>" . $s1 . "</span></p>";
    echo "<p class='op'>Рахунок 2 після нарахування: <span class='balance'>" . $s2 . "</span></p>";

} catch (Exception $e) {
    echo "<p class='error'>❌ Помилка: " . $e->getMessage() . "</p>";
}

?>
</div>

<!-- КРОК 5. Константа MIN_BALANCE                                -->

<h2>5. Константа MIN_BALANCE</h2>
<div class="card">
<?php

echo "<p class='op'>Мінімальний баланс рахунку: <span class='balance'>" . BankAccount::MIN_BALANCE . " (константа MIN_BALANCE)</span></p>";

?>
</div>

</body>
</html>
