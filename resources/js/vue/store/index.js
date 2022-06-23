import { createStore } from "vuex";
import { auth } from "./auth.module";
import { todo } from "./todo.module";

const store = createStore({
    modules: {
        auth, todo
    },
});
export default store;