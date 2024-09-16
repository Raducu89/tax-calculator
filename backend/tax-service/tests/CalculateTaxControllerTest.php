<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\TaxController;
use App\Services\TaxService;
use Core\Request;
use Core\Response;
use Core\Validator;

class CalculateTaxControllerTest extends TestCase
{
    protected $taxServiceMock;
    protected $validatorMock;
    protected $controller;

    protected function setUp(): void
    {
        $this->taxServiceMock = $this->createMock(TaxService::class);
        $this->validatorMock = $this->createMock(Validator::class);
        $this->controller = new TaxController($this->taxServiceMock, $this->validatorMock);
    }

    public function testCalculateTaxWithValidInput()
    {
        // Mock valid salary input
        $request = $this->createMock(Request::class);
        $request->method('getBody')->willReturn(['salary' => 40000]);

        $response = $this->createMock(Response::class);

        // Expect that validator checks the salary without errors
        $this->validatorMock->expects($this->exactly(2))
            ->method('validateRequired');
        $this->validatorMock->expects($this->once())
            ->method('validateNumber');

        $this->validatorMock->method('hasErrors')->willReturn(false);

        // Mock the tax calculation service to return a tax breakdown
        $this->taxServiceMock->method('calculateTax')->willReturn([
            'grossSalary' => 40000,
            'grossMonthlySalary' => 3333.33,
            'netAnnualSalary' => 29000,
            'netMonthlySalary' => 2416.67,
            'totalTax' => 11000,
            'monthlyTaxPaid' => 916.67
        ]);

        // Expect the response to return a JSON with a 200 status code
        $response->expects($this->once())
            ->method('json')
            ->with($this->equalTo([
                'grossSalary' => 40000,
                'grossMonthlySalary' => 3333.33,
                'netAnnualSalary' => 29000,
                'netMonthlySalary' => 2416.67,
                'totalTax' => 11000,
                'monthlyTaxPaid' => 916.67
            ]), 200);

        $this->controller->calculateTax($request, $response);
    }

    public function testCalculateTaxWithInvalidInput()
    {
        // Mock invalid salary input
        $request = $this->createMock(Request::class);
        $request->method('getBody')->willReturn(['salary' => null]);

        $response = $this->createMock(Response::class);

        // Expect validation to fail
        $this->validatorMock->expects($this->once())
            ->method('validateRequired');
        $this->validatorMock->expects($this->once())
            ->method('validateNumber');

        $this->validatorMock->method('hasErrors')->willReturn(true);
        $this->validatorMock->method('getErrors')->willReturn(['salary' => 'Salary is required and must be a number.']);

        // Expect the response to return a JSON error message with a 400 status code
        $response->expects($this->once())
            ->method('json')
            ->with($this->equalTo(['errors' => ['salary' => 'Salary is required and must be a number.']]), 400);

        $this->controller->calculateTax($request, $response);
    }
}
