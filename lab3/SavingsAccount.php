<?php

require_once 'BankAccount.php';

/**
 * Клас SavingsAccount — накопичувальний рахунок.
 *
 * Успадковує BankAccount та додає підтримку відсоткової ставки.
 * Метод applyInterest() нараховує відсотки на поточний баланс.
 */
class SavingsAccount extends BankAccount
{
    /**
     * Відсоткова ставка для всіх накопичувальних рахунків.
     * Статична — спільна для всіх екземплярів класу.
     * Значення: 5% (0.05)
     */
    private static float $interestRate = 0.05;

    /**
     * Конструктор накопичувального рахунку.
     * Викликає конструктор батьківського класу через parent::__construct().
     *
     * @param float  $initialBalance Початковий баланс
     * @param string $currency       Валюта рахунку
     * @throws Exception Якщо початковий баланс від'ємний
     */
    public function __construct(float $initialBalance = 0, string $currency = 'UAH')
    {
        // Передаємо параметри батьківському класу
        parent::__construct($initialBalance, $currency);
    }

    /**
     * Нараховує відсотки на поточний баланс.
     *
     * Формула: баланс += баланс * відсоткова_ставка
     * При ставці 5% та балансі 1000 — нарахується 50.
     */
    public function applyInterest(): void
    {
        // Розраховуємо суму відсотків
        $interest = $this->balance * self::$interestRate;

        // Додаємо відсотки до балансу
        $this->balance += $interest;
    }

    /**
     * Повертає поточну відсоткову ставку.
     * Статичний метод — викликається без створення об'єкта.
     *
     * @return float Відсоткова ставка (наприклад 0.05 = 5%)
     */
    public static function getInterestRate(): float
    {
        return self::$interestRate;
    }

    /**
     * Встановлює нову відсоткову ставку для всіх рахунків.
     *
     * @param float $rate Нова ставка (наприклад 0.07 = 7%)
     * @throws Exception Якщо ставка від'ємна
     */
    public static function setInterestRate(float $rate): void
    {
        if ($rate < 0) {
            throw new Exception("Відсоткова ставка не може бути від'ємною.");
        }
        self::$interestRate = $rate;
    }

    /**
     * Рядкове представлення накопичувального рахунку.
     */
    public function __toString(): string
    {
        $rate = self::$interestRate * 100;
        return "SavingsAccount | Баланс: {$this->balance} {$this->currency} | Ставка: {$rate}%";
    }
}
