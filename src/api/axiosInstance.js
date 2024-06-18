import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'http://localhost/foodle_db'
});

export default axiosInstance;
