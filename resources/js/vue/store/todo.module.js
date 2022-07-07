import { defaultsDeep } from "lodash";
import todoService from "../services/todo.service";
const initialState = false;

export const todo = {
    namespaced: true,
    state: initialState,
    actions: {
        async store({ commit }, name) {
            const todo = await todoService.store(name);
            commit('storeSuccess', todo);
            return await Promise.resolve(todo);
        },
        async all({ commit }) {
            const response = await todoService.all();
            if (response.status === 'success') {
                commit('getSuccess', response.data);
                return await Promise.resolve(response.data);
            } else {
                commit('getFailure', response.data);
                return await Promise.resolve(response.data);
            }
        },
        async update({ commit }, id) {
            const todo = await todoService.update(id);
            commit('updateSuccess', todo);
            return await Promise.resolve(todo);
        },
        async delete({ commit }, id) {
            const response = await todoService.delete(id);
            return await Promise.resolve(response);
        },
        async edit({ commit }, todo) {
            const response = await todoService.edit(todo);
            commit('updateSuccess', response.data);
            return await Promise.resolve(response);
        }
    },
    mutations: {
        storeSuccess(state, todo) {
            state.todo = todo;
        },
        getSuccess(state, todos) {
            state.todos = todos;
        },
        getFailure(state, data) {
            state.todos = null;
        },
        updateSuccess(state, todo) {
            state.todo = todo;
        }
    }
}