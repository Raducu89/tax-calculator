import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://localhost:8080/api', // URL for API Gateway
  headers: {
    'Content-Type': 'application/json',
  },
});

// Funcția pentru a obține taxe
export const getTaxes = async () => {
  try {
    const response = await apiClient.get('/tax-service/api/taxes');
    return response.data;
  } catch (error) {
    console.error("Error fetching taxes:", error);
    throw error;
  }
};

// Funcția pentru a calcula taxele
export const calculateTax = async (data) => {
  try {
    const response = await apiClient.post('/tax-service/api/taxes/calculate', data);
    return response.data;
  } catch (error) {
    console.error("Error calculating tax:", error);
    throw error;
  }
};

// Funcția pentru a obține rapoarte
export const getReports = async () => {
  try {
    const response = await apiClient.get('/tax-reports/api/reports');
    return response.data;
  } catch (error) {
    console.error("Error fetching reports:", error);
    throw error;
  }
};
