<?php

namespace App\Services;

use App\Interfaces\TaxRepositoryInterface;
use Exception;

class TaxService
{
    protected TaxRepositoryInterface $taxRepository;

    /**
     * TaxService constructor.
     * 
     * @param TaxRepositoryInterface $taxRepository
     */
    public function __construct(TaxRepositoryInterface $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * Get all taxes.
     * 
     * @return array
     * @throws Exception
     */
    public function getAllTaxes(): array
    {
        try {
            return $this->taxRepository->getAll();
        } catch (Exception $e) {
            throw new Exception("Failed to fetch taxes from the repository");
        }
    }

    /**
     * Calculate tax based on salary.
     * 
     * @param float $salary
     * @return array
     */
    public function calculateTax(float $salary): array
    {
    $bands = $this->taxRepository->getAll(); // Fetch all tax bands from DB, ordered by min_amount
    $totalTax = 0;
    $taxPerBand = [];

    foreach ($bands as $band) {
        // Tax Band limits and rate
        $min = $band->lower_limit;
        $max = $band->upper_limit; // null or 0 means no upper limit
        $rate = $band->tax_rate;

        // If the salary is below the current band's minimum, no tax applies to this band
        if ($salary <= $min) {
            continue;
        }

        // Determine the taxable amount in this band
        $taxableAmount = $salary > $max && $max > 0 ? $max - $min : $salary - $min;
        
        // Cap the taxable amount to stay within the band's range
        if ($max && $salary > $max) {
            $taxableAmount = $max - $min;
        }

        // Calculate the tax for this band
        $taxForBand = $taxableAmount * ($rate / 100);
        $taxPerBand[] = [
            'band' => $band->band_name,
            'taxableAmount' => round($taxableAmount, 2),
            'taxForBand' => round($taxForBand, 2),
            'rate' => $rate,
        ];

        // Add to the total tax
        $totalTax += $taxForBand;

        // If the salary is less than the maximum for this band, stop further calculations
        if ($max && $salary <= $max) {
            break;
        }
    }

    // Calculate the net salary (gross salary minus total tax)
    $netSalary = $salary - $totalTax;

    // Monthly calculations
    $grossMonthlySalary = $salary / 12;
    $netMonthlySalary = $netSalary / 12;
    $monthlyTaxPaid = $totalTax / 12;

    // Return all the details
    return [
        'grossSalary' => $salary,
        'grossMonthlySalary' => round($grossMonthlySalary, 2),
        'netAnnualSalary' => round($netSalary, 2),
        'netMonthlySalary' => round($netMonthlySalary, 2),
        'totalTax' => round($totalTax, 2),
        'monthlyTaxPaid' => round($monthlyTaxPaid, 2),
        'taxPerBand' => $taxPerBand
    ];
}


}
