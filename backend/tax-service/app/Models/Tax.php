<?php

namespace App\Models;

class Tax
{
    public string $table = 'tax_bands';

    /**
     * Get the table name.
     * 
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table;
    }
}
