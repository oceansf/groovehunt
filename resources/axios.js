import axios from 'axios';

// Create an Axios instance
const axiosInstance = axios.create({
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
  },
});

// Add a request interceptor to include the CSRF token
axiosInstance.interceptors.request.use((config) => {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  if (csrfToken) {
    config.headers['X-CSRF-TOKEN'] = csrfToken;
  }
  return config;
});

export default axiosInstance;