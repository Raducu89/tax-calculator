import React, { useState } from 'react';
import { calculateTax } from '../services/api';

const TaxForm = () => {
  const [salary, setSalary] = useState('');
  const [taxDetails, setTaxDetails] = useState(null);
  const [error, setError] = useState(null);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError(null);

    if (!salary) {
      setError("Please enter your salary");
      return;
    }

    try {
      const result = await calculateTax({ salary });
      setTaxDetails(result); // Backend returns detailed tax info
    } catch (error) {
      setError("An error occurred while calculating tax");
    }
  };

  return (
    <div className="min-h-screen bg-gray-100 flex items-center justify-center">
      <div className="bg-white p-8 rounded-lg shadow-md max-w-2xl w-full">
        <h2 className="text-3xl font-bold text-gray-800 mb-6">Calculate Tax</h2>
        <form onSubmit={handleSubmit} className="space-y-6">
          <div>
            <label className="block text-sm font-medium text-gray-700">Salary:</label>
            <input
              type="number"
              value={salary}
              onChange={(e) => setSalary(e.target.value)}
              className="mt-1 p-3 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
              required
            />
          </div>
          <button
            type="submit"
            className="w-full py-3 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition"
          >
            Calculate
          </button>
        </form>

        {error && <p className="mt-4 text-red-500">{error}</p>}
        
        {taxDetails && (
          <div className="mt-6 text-lg font-semibold text-gray-800">
            <p>Gross Annual Salary: £{taxDetails.grossSalary}</p>
            <p>Gross Monthly Salary: £{taxDetails.grossMonthlySalary}</p>
            <p>Net Annual Salary: £{taxDetails.netAnnualSalary}</p>
            <p>Net Monthly Salary: £{taxDetails.netMonthlySalary}</p>
            <p>Annual Tax Paid: £{taxDetails.totalTax}</p>
            <p>Monthly Tax Paid: £{taxDetails.monthlyTaxPaid}</p>
            <p className="mt-4">Tax Breakdown by Band:</p>
            <ul>
              {taxDetails.taxPerBand.map((band, index) => (
                <li key={index} className="mt-2">
                  <span>Band {band.band}: Taxable Amount: £{band.taxableAmount} at {band.rate}% => Tax: £{band.taxForBand}</span>
                </li>
              ))}
            </ul>
          </div>
        )}

      </div>
    </div>
  );
};

export default TaxForm;
