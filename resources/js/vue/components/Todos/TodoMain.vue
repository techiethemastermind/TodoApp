<template>
    <section class="main-content gradient-form bg-gray-200">
        <div class="container py-10 px-6 h-full mx-auto">
            <div class="flex justify-center items-center flex-wrap g-6 text-gray-800">
                <div class="lg:w-6/12 w-full">
                    <div class="block bg-white shadow-lg rounded-lg">
                        <div class="p-6 md:p-12 md:mx-6">
                            <div class="text-center block">
                                <h3 class="text-2xl font-semibold mt-1 mb-12 pb-1">My TodoList</h3>
                            </div>
                            <add-todo-form v-on:reloadTodos="getTodos()"></add-todo-form>
                            <todos-view :todos="todos" v-on:reloadTodos="getTodos()"></todos-view>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import AddTodoForm from './AddTodoForm.vue'
import TodosView from './TodosView.vue'

export default {
    components: {
        AddTodoForm, TodosView
    },
    data() {
        return {
            todos: []
        }
    },
    created() {
        this.getTodos();
    },
    methods: {
        getTodos() {
            this.$store.dispatch('todo/all')
                .then( response => {
                    if (response.success) {
                        this.todos = response.data;
                    }

                    if (response.status && response.status == 'Token is Invalid') {
                        this.$store.state.auth.status.loggedIn = false;
                        this.$router.push("/login");
                    }
                })
                .catch( error => {
                    console.log(error);
                })
        }
    }
}
</script>