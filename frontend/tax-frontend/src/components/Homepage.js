import React from 'react';
import { Link } from 'react-router-dom';

const Homepage = () => {
  return (
    <div className="min-h-screen bg-gray-100 flex items-center justify-center">
      <div className="bg-white p-8 rounded-lg shadow-md max-w-lg text-center">
        <h1 className="text-4xl font-bold text-gray-800 mb-6">Tax Service App</h1>
        <p className="text-gray-600 mb-8">Manage your taxes easily with our tool</p>
        <div className="space-y-4">
          <Link
            to="/tax-form"
            className="block w-full py-3 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition"
          >
            Calculate Tax
          </Link>
          <Link
            to="/reports"
            className="block w-full py-3 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600 transition"
          >
            View Reports
          </Link>
        </div>
      </div>
    </div>
  );
};

export default Homepage;
