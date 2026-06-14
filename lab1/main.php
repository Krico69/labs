<?php

// Лабораторна робота №1 — Ознайомлення із синтаксисом PHP

// 1. Базовий PHP-скрипт
echo "Hello, World!";
echo "\n";

//2. Змінні та типи даних

$name = "Микола";
$age = 20;

$gpa = 4.75;

$isStudent = true;

echo "Ім'я: $name\n";
echo "Вік: $age\n";
echo "Середній бал: $gpa\n";
echo "Є студентом: " . ($isStudent ? "так" : "ні") . "\n";

echo "\n--- var_dump змінних ---\n";
var_dump($name);     
var_dump($age);       
var_dump($gpa);       
var_dump($isStudent); 

// 3. Конкатенація рядків

$firstName = "Іван";
$lastName  = "Петренко";

$fullName = $firstName . " " . $lastName;
echo "\n--- Конкатенація рядків ---\n";
echo "Повне ім'я: $fullName\n";

// 4. Умовні конструкції

$number = 17;

echo "\n--- Умовні конструкції ---\n";

if ($number % 2 === 0) {
    echo "Число $number є парним.\n";
} else {
    
    echo "Число $number є непарним.\n";
}

// 5. Цикли

echo "\n--- Цикл for (від 1 до 10) ---\n";
for ($i = 1; $i <= 10; $i++) {
    echo "$i ";
}
echo "\n";
echo "\n--- Цикл while (від 10 до 1) ---\n";
$j = 10;
while ($j >= 1) {
    echo "$j ";
    $j--; 
}
echo "\n";

// 6. Масиви


echo "\n--- Асоціативний масив ---\n";

$student = [
    "ім'я"        => "Олена",
    "прізвище"    => "Коваль",
    "вік"         => 19,
    "спеціальність" => "Комп'ютерна інженерія",
];

echo "Ім'я: "          . $student["ім'я"]          . "\n";
echo "Прізвище: "      . $student["прізвище"]      . "\n";
echo "Вік: "           . $student["вік"]            . "\n";
echo "Спеціальність: " . $student["спеціальність"] . "\n";

$student["середній бал"] = 4.9;

echo "\n--- Оновлений масив (з середнім балом) ---\n";

print_r($student);
