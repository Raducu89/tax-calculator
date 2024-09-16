<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\TaxController;
use App\Services\TaxService;
use Core\Request;
use Core\Response;
use Core\Validator;

class TaxControllerTest extends TestCase
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

    public function testTaxesReturnsSuccess()
    {
        // Mock the tax service to return a predefined list of taxes
        $this->taxServiceMock->method('getAllTaxes')->willReturn([
            ['id' => 1, 'name' => 'Band A', 'rate' => 0],
            ['id' => 2, 'name' => 'Band B', 'rate' => 20]
        ]);

        // Create dummy request and response objects
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        // Expect the response to return JSON with a 200 status code
        $response->expects($this->once())
            ->method('json')
            ->with($this->equalTo([
                ['id' => 1, 'name' => 'Band A', 'rate' => 0],
                ['id' => 2, 'name' => 'Band B', 'rate' => 20]
            ]), 200);

        $this->controller->taxes($request, $response);
    }

    public function testTaxesReturnsErrorOnFailure()
    {
        // Simulate an exception in the service
        $this->taxServiceMock->method('getAllTaxes')->willThrowException(new Exception('Service unavailable'));

        // Create dummy request and response objects
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        // Expect the response to return a JSON error message with a 503 status code
        $response->expects($this->once())
            ->method('json')
            ->with($this->equalTo(['error' => 'Unable to fetch taxes at the moment. Please try again later.']), 503);

        $this->controller->taxes($request, $response);
    }
}
