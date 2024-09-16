import React from 'react';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import Homepage from './components/Homepage';
import TaxForm from './components/TaxForm';
import Reports from './components/Reports';

function App() {
  return (
    <Router>
      <div className="min-h-screen bg-gray-100">
        <nav className="bg-white shadow-md">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex justify-between items-center h-16">
              <div className="flex space-x-4">
                <Link to="/" className="text-gray-800 font-semibold hover:text-blue-500 transition">
                  Home
                </Link>
                <Link to="/tax-form" className="text-gray-800 font-semibold hover:text-blue-500 transition">
                  Tax Form
                </Link>
                <Link to="/reports" className="text-gray-800 font-semibold hover:text-blue-500 transition">
                  Reports
                </Link>
              </div>
            </div>
          </div>
        </nav>

        <div className="py-8">
          <Routes>
            <Route path="/" element={<Homepage />} />
            <Route path="/tax-form" element={<TaxForm />} />
            <Route path="/reports" element={<Reports />} />
          </Routes>
        </div>
      </div>
    </Router>
  );
}

export default App;
