import axios from 'axios';
import authHeader from './auth-header';
const API_URL = 'http://localhost:8000/api/todo/';

class TodoService {
    async all() {
        const response = await axios
            .get(API_URL + 'all', { headers: authHeader() });

        if (response.status === 200 && response.data.success) {
            return {
                status: 'success',
                data: response.data
            }
        }

        return {
            status: 'false',
            data: response.data
        }
    }
    async store(name) {
        const response = await axios
            .post(API_URL + 'store',
                { name: name },
                { headers: authHeader() }
            );

        if (response.status === 200 && response.data.success) {
            return response.data;
        }
    }
    async update(todo) {
        const response = await axios
            .put(API_URL + todo.id, 
                { todo: todo },
                { headers: authHeader() }
            );

        if (response.status === 200 && response.data.success) {
            return response.data;
        }
    }
    async delete(id) {
        const response = await axios
            .delete(API_URL + id, { headers: authHeader() })

        if (response.status === 200 && response.data.success) {
            return response.data;
        }
    }
    async edit(todo) {
        const response = await axios
            .post(API_URL + 'edit', todo, { headers: authHeader() });

        if (response.status === 200 && response.data.success) {
            return response.data;
        }
    }
}
export default new TodoService();