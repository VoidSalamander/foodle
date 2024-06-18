import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'https://c398-106-250-181-114.ngrok-free.app/foodle_db'
});

export default axiosInstance;
