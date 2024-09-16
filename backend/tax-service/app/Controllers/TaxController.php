<?php

namespace App\Controllers;

use App\Services\TaxService;
use Core\Request;
use Core\Response;
use Core\Validator;
use Exception;

class TaxController
{
    protected TaxService $taxService;
    protected Validator $validator;

    /**
     * TaxController constructor.
     * 
     * @param TaxService $taxService
     * @param Validator $validator
     */
    public function __construct(TaxService $taxService, Validator $validator)
    {
        $this->taxService = $taxService;
        $this->validator = $validator;
    }

    /**
     * Get all taxes.
     * 
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function taxes(Request $request, Response $response)
    {
        try {
            $taxes = $this->taxService->getAllTaxes();
            return $response->json($taxes, 200);
        } catch (Exception $e) {
            return $response->json(['error' => 'Unable to fetch taxes at the moment. Please try again later.'], 503);
        }
    }

    /**
     * Calculate tax based on salary.
     * 
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function calculateTax(Request $request, Response $response)
    {
        $data = $request->getBody();
        $grossSalary = $data['salary'] ?? null;

        // Validate inputs
        $this->validator->validateRequired('salary', $grossSalary ?? null);
        $this->validator->validateNumber('salary', $grossSalary ?? null);

        // Check for validation errors
        if ($this->validator->hasErrors()) {
            return $response->json([
                'errors' => $this->validator->getErrors()
            ], 400);
        }   

        // If validation passes, calculate the tax based on bands
        $taxDetails = $this->taxService->calculateTax($grossSalary);

        return $response->json($taxDetails, 200);
    }
}
