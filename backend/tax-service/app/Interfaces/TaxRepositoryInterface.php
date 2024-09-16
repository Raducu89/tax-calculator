<?php

namespace App\Interfaces;

use App\Models\Tax;

interface TaxRepositoryInterface extends RepositoryInterface
{
    public function findByName(string $name): ?Tax;

    public function calculateTax(float $amount): float;
}
