<?php

require_once 'AccountInterface.php';

/**
 * Клас BankAccount — базовий банківський рахунок.
 *
 * Реалізує інтерфейс AccountInterface.
 * Підтримує поповнення, зняття коштів та перевірку балансу.
 * Використовує винятки для обробки некоректних операцій.
 */
class BankAccount implements AccountInterface
{
    /**
     * Мінімально допустимий баланс рахунку.
     * Константа доступна через BankAccount::MIN_BALANCE.
     */
    const MIN_BALANCE = 0;

    /**
     * Поточний баланс рахунку.
     * Захищений (protected) — щоб дочірні класи мали до нього доступ.
     */
    protected float $balance;

    /**
     * Валюта рахунку (наприклад "USD", "UAH", "EUR").
     */
    protected string $currency;

    /**
     * Конструктор класу.
     *
     * @param float  $initialBalance Початковий баланс (за замовчуванням 0)
     * @param string $currency       Валюта рахунку (за замовчуванням "UAH")
     * @throws Exception Якщо початковий баланс від'ємний
     */
    public function __construct(float $initialBalance = 0, string $currency = 'UAH')
    {
        // Перевіряємо що початковий баланс не від'ємний
        if ($initialBalance < 0) {
            throw new Exception("Початковий баланс не може бути від'ємним.");
        }

        $this->balance  = $initialBalance;
        $this->currency = $currency;
    }

    /**
     * Поповнення рахунку.
     *
     * @param float $amount Сума поповнення
     * @throws Exception Якщо сума некоректна (від'ємна або нульова)
     */
    public function deposit(float $amount): void
    {
        // Перевірка: сума має бути більше нуля
        if ($amount <= 0) {
            throw new Exception("Сума поповнення має бути більше нуля.");
        }

        // Додаємо суму до балансу
        $this->balance += $amount;
    }

    /**
     * Зняття коштів з рахунку.
     *
     * @param float $amount Сума для зняття
     * @throws Exception Якщо сума некоректна або недостатньо коштів
     */
    public function withdraw(float $amount): void
    {
        // Перевірка: сума має бути більше нуля
        if ($amount <= 0) {
            throw new Exception("Сума для зняття має бути більше нуля.");
        }

        // Перевірка: баланс після зняття не може опуститись нижче MIN_BALANCE
        if ($this->balance - $amount < self::MIN_BALANCE) {
            throw new Exception("Недостатньо коштів. Доступно: {$this->balance} {$this->currency}.");
        }

        // Знімаємо кошти
        $this->balance -= $amount;
    }

    /**
     * Повертає поточний баланс.
     *
     * @return float Поточний баланс
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * Повертає валюту рахунку.
     *
     * @return string Код валюти
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Повертає рядкове представлення рахунку для виводу.
     */
    public function __toString(): string
    {
        return "BankAccount | Баланс: {$this->balance} {$this->currency}";
    }
}
