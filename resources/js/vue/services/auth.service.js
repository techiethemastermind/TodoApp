import axios from 'axios';
import authHeader from './auth-header';
const API_URL = 'http://localhost:8000/api/auth/';
class AuthService {
    async login(user) {
        const response = await axios
            .post(API_URL + 'login', {
                email: user.email,
                password: user.password
            });
        if (response.data.accessToken) {
            localStorage.setItem('user', JSON.stringify(response.data));
        }
        return response.data;
    }
    logout() {
        localStorage.removeItem('user');
    }
    register(user) {
        return axios.post(API_URL + 'register', {
            name: user.name,
            email: user.email,
            password: user.password
        });
    }
    async getUser() {
        let user = JSON.parse(localStorage.getItem('user'));
        const response = await axios.get(API_URL + 'user/' + user.accessToken, 
            { headers: authHeader() });

        return response.data;
    }
    async update(user) {
        const response = await axios
            .post(API_URL + 'update', user, { headers: authHeader() });
            
        return response.data;
    }
}
export default new AuthService();