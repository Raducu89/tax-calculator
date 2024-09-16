import React, { useEffect, useState } from 'react';
import { getReports } from '../services/api';

const Reports = () => {
  const [reports, setReports] = useState([]);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchReports = async () => {
      try {
        const data = await getReports();
        setReports(data);
      } catch (error) {
        setError("Error fetching reports");
      }
    };

    fetchReports();
  }, []);

  return (
    <div className="min-h-screen bg-gray-100 flex items-center justify-center">
      <div className="bg-white p-8 rounded-lg shadow-md max-w-4xl w-full">
        <h2 className="text-3xl font-bold text-gray-800 mb-6">Tax Reports |-Work in Progress-|</h2>
        {error ? (
          <p className="text-red-500">{error}</p>
        ) : (
          <table className="min-w-full border-collapse block md:table">
            <thead className="block md:table-header-group">
              <tr className="border border-gray-200 md:table-row">
                <th className="p-3 text-left text-sm font-medium text-gray-500 block md:table-cell">
                  Month
                </th>
                <th className="p-3 text-left text-sm font-medium text-gray-500 block md:table-cell">
                  Tax Collected
                </th>
              </tr>
            </thead>
            <tbody className="block md:table-row-group">
              {reports.length > 0 ? (
                reports.map((report, index) => (
                  <tr
                    key={index}
                    className="bg-white border border-gray-200 md:border-none block md:table-row hover:bg-gray-50 transition"
                  >
                    <td className="p-3 text-gray-700 block md:table-cell">{report.month}</td>
                    <td className="p-3 text-gray-700 block md:table-cell">{report.taxCollected}</td>
                  </tr>
                ))
              ) : (
                <tr className="block md:table-row">
                  <td
                    className="p-3 text-gray-700 text-center block md:table-cell"
                    colSpan="2"
                  >
                    No reports available
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        )}
      </div>
    </div>
  );
};

export default Reports;
