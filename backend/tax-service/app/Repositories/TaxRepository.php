<?php

namespace App\Repositories;

use App\Models\Tax;
use App\Interfaces\TaxRepositoryInterface;
use Core\Database;
use PDO;

class TaxRepository implements TaxRepositoryInterface
{
    protected PDO $db;
    protected string $table;

    /**
     * TaxRepository constructor.
     */
    public function __construct()
    {   
        $this->table = (new Tax())->getTableName();
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Find a tax band by name.
     * 
     * @param string $name
     * @return Tax|null
     */
    public function findByName(string $name): ?Tax
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE name = :name");
        $stmt->execute(['name' => $name]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Tax::class);
        return $stmt->fetch();
    }

    /**
     * Calculate tax based on amount.
     * 
     * @param float $amount
     * @return float
     */
    public function calculateTax(float $amount): float
    {
        $stmt = $this->db->query("SELECT * FROM $this->table ORDER BY min_amount ASC");
        $stmt->setFetchMode(PDO::FETCH_CLASS, Tax::class);
        $bands = $stmt->fetchAll();

        $tax = 0;
        foreach ($bands as $band) {
            if ($amount > $band->max_amount) {
                $tax += ($band->max_amount - $band->min_amount) * $band->rate;
            } else {
                $tax += ($amount - $band->min_amount) * $band->rate;
                break;
            }
        }
        return $tax;
    }

    /**
     * Create a new tax band.
     * 
     * @param object $tax
     * @return bool
     */
    public function create(object $tax): bool
    {
        $stmt = $this->db->prepare("INSERT INTO $this->table (name, rate, min_amount, max_amount) VALUES (:name, :rate, :min_amount, :max_amount)");
        return $stmt->execute([
            'name' => $tax->name,
            'rate' => $tax->rate,
            'min_amount' => $tax->min_amount,
            'max_amount' => $tax->max_amount
        ]);
    }

    /**
     * Update a tax band.
     * 
     * @param int $id
     * @param object $tax
     * @return bool
     */
    public function update(int $id ,object $tax): bool
    {
        $stmt = $this->db->prepare("UPDATE $this->table SET rate = :rate, min_amount = :min_amount, max_amount = :max_amount WHERE id = :id");
        return $stmt->execute([
            'name' => $tax->name,
            'rate' => $tax->rate,
            'min_amount' => $tax->min_amount,
            'max_amount' => $tax->max_amount
        ]);
    }

    /**
     * Delete a tax band.
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Get a tax band by ID.
     * 
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Tax::class);
        return $stmt->fetch();
    }

    /**
     * Get all tax bands.
     * 
     * @return array
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM $this->table");
        $stmt->setFetchMode(PDO::FETCH_CLASS, Tax::class);
        return $stmt->fetchAll();
    }
}
