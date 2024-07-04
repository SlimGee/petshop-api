<?php

namespace App\Enums;

enum PaymentType: string
{
    case CREDIT_CARD = 'credit_card';
    case CASH_ON_DELIVERY = 'cash_on_delivery';
    case BANK_TRANSFER = 'bank_transfer';

    /**
     * The validation rules for payment type
     *
     * @return array<string, string>
     */
    public function validation(): array
    {
        return match ($this) {
            self::CREDIT_CARD => [
                'details.holder_name' => 'required|string|max:255',
                'details.number' => 'required|numeric',
                'details.cvv' => 'required|integer|digits:3',
                'details.expire_date' => 'required|string',
            ],
            self::CASH_ON_DELIVERY => [
                'details.first_name' => 'required|string|max:255',
                'details.last_name' => 'required|string|max:255',
                'details.address' => 'required|string',
            ],
            self::BANK_TRANSFER => [
                'details.swift' => 'required|string|max:255',
                'details.iban' => 'required|string|max:255',
                'details.name' => 'required|string|max:255',
            ]
        };
    }

    /**
     * Fake data for factories
     *
     * @return array<string, string>
     */
    public function factory(): array
    {
        return match ($this) {
            self::CREDIT_CARD => [
                'holder_name' => fake()->name(),
                'number' => fake()->creditCardNumber,
                'cvv' => rand(100, 999),
                'expire_date' => fake()->creditCardExpirationDateString(),
            ],
            self::CASH_ON_DELIVERY => [
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'address' => fake()->address(),
            ],
            self::BANK_TRANSFER => [
                'swift' => fake()->swiftBicNumber(),
                'iban' => fake()->sentence(),
                'name' => fake()->sentence(),
            ]
        };
    }
}
