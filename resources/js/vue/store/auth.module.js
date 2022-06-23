import AuthService from '../services/auth.service';
const user = JSON.parse(localStorage.getItem('user'));
const initialState = user
    ? { status: { loggedIn: true }, user }
    : { status: { loggedIn: false }, user: null };
export const auth = {
    namespaced: true,
    state: initialState,
    actions: {
        login({ commit }, user) {
            return AuthService.login(user).then(
                user => {
                    commit('loginSuccess', user);
                    return Promise.resolve(user);
                },
                error => {
                    commit('loginFailure');
                    return Promise.reject(error);
                }
            );
        },
        logout({ commit }) {
            AuthService.logout();
            commit('logout');
        },
        register({ commit }, user) {
            console.log(user, 'module');
            return AuthService.register(user).then(
                response => {
                    commit('registerSuccess');
                    return Promise.resolve(response.data);
                },
                error => {
                    commit('registerFailure');
                    return Promise.reject(error);
                }
            );
        },
        userInfo({ commit }) {
            return AuthService.getUser().then(
                response => {
                    commit('getUserSuccess', response.data);
                    return Promise.resolve(response.data);
                },
                error => {
                    commit('getUserFailure');
                    return Promise.reject(error);
                }
            )
        },
        update({ commit }, user) {
            return AuthService.update(user).then(
                response => {
                    commit('updateSuccess', response);
                    return Promise.resolve(response);
                },
                error => {
                    commit('updateFailure');
                    return Promise.reject(error);
                }
            )
        }
    },
    mutations: {
        loginSuccess(state, user) {
            state.status.loggedIn = true;
            state.user = user;
        },
        loginFailure(state) {
            state.status.loggedIn = false;
            state.user = null;
        },
        logout(state) {
            state.status.loggedIn = false;
            state.user = null;
        },
        registerSuccess(state) {
            state.status.loggedIn = false;
        },
        registerFailure(state) {
            state.status.loggedIn = false;
        },
        getUserSuccess(state, userInfo) {
            state.userInfo = userInfo;
        },
        getUserFailure(state) {
            state.userInfo = null;
        },
        updateSuccess(state, userInfo) {
            state.userInfo = userInfo;
        },
        updateFailure(state) {
            state.userInfo = null;
        }
    }
};