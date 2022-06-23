<template>
    <div class="todo-form">
        <div class="mb-12 flex">
            <input
                type="text"
                class="form-control block w-full px-3 py-1.5 text-base lg:mr-3
                    font-normal text-gray-700 bg-white bg-clip-padding border 
                    border-solid border-gray-300 rounded transition ease-in-out m-0 
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                id="todo"
                placeholder="Add new Todo item"
                v-model="todo.name"
            />
            <button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 
                to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none 
                focus:ring-red-300 dark:focus:ring-red-800 font-medium 
                rounded-lg text-sm p-2 text-center"
                @click="addTodo()"
            >
                <PlusIcon class="h-6 w-6 text-white" />
            </button>
        </div>
    </div>
</template>

<script>
import { PlusIcon } from "@heroicons/vue/outline";

export default {
    components: {
        PlusIcon
    },
    data() {
        return {
            todo: {
                name: ''
            },
            message: ''
        }
    },
    methods: {
        addTodo() {

            if (this.todo.name === '') {
                this.message = 'Name is required';
                return false;
            } else {
                this.$store.dispatch('todo/store', this.todo.name).then(
                    (res) => {
                        if (res && res.success) {
                            console.log(res.data);
                            this.todo.name = '';
                            this.$emit('reloadTodos');
                        }
                    },
                    error => {
                        console.log(error);
                        this.message = error.toString();
                    }
                )
            }
        }
    }
}
</script>