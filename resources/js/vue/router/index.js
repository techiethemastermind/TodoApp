import { createWebHistory, createRouter } from "vue-router";
import LoginComponent from '../auth/LoginComponent'
import RegisterComponent from '../auth/RegisterComponent'
import ProfileComponent from '../components/ProfileComponent'
import TodoMainComponent from '../components/Todos/TodoMain'

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: LoginComponent,
    },
    {
        path: '/register',
        name: 'Register',
        component: RegisterComponent,
    },
    {
        path: '/profile',
        name: 'Profile',
        component: ProfileComponent
    },
    {
        path: '/todo',
        name: 'Todo',
        component: TodoMainComponent
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;