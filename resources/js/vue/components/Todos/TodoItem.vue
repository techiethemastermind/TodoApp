<template>
    <div class="flex gap-2">
        <div class="block w-full">
            <div class="flex h-12 bg-slate-200 rounded-[6px] justify-start items-center px-3">
                <span class="w-7 h-7 bg-white rounded-full border border-white transition-all cursor-pointer
                    flex justify-center items-center lg:mr-3" @click="updateCheck()">
                    <CheckIcon class="h6 w-6" v-if="todo.completed == 1" />
                </span>
                <input :class="[todo.completed == 1 ? 'completed' : '', 'todo-name']"
                    class="w-full bg-slate-200 focus:border-none focus:outline-none"
                    v-model="todo.name" :readonly="current.status === 0" ref="name" />
            </div>
        </div>
        <button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 
            to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 
            dark:focus:ring-blue-800 font-medium rounded-lg text-sm p-2 text-center m-1 mr-0"
                @click="updateTodo()"
            >
            <PencilAltIcon v-if="current.status === 0" class="h-6 w-6 text-white" />
            <SaveIcon v-if="current.status === 1" class="h-6 w-6 text-white" />
        </button>
        <button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 
            to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none 
            focus:ring-red-300 dark:focus:ring-red-800 font-medium justify-end
            rounded-lg text-sm p-2 text-center m-1 mr-0"
            @click="removeTodo()"
        >
            <TrashIcon class="h-6 w-6 text-white" />
        </button>
    </div>
</template>

<script>
import { PencilAltIcon, CheckIcon, TrashIcon, SaveIcon } from '@heroicons/vue/outline'

export default {
    props: ['todo'],
    components: {
        PencilAltIcon, CheckIcon, TrashIcon, SaveIcon
    },
    data() {
        return {
            current: {
                status: 0
            }
        }
    },
    methods: {
        updateCheck() {
            this.todo.completed = this.todo.completed == 1 ? 0 : 1;
            this.$store.dispatch('todo/update', this.todo)
                .then(
                    (res) => {
                        this.$emit('todoChange');
                    },
                    error => {
                        console.log(error);
                    }
                )
        },
        removeTodo() {
            this.$store.dispatch('todo/delete', this.todo.id)
                .then(
                    (res) => {
                        this.$emit('todoChange');
                    },
                    error => {
                        console.log(error);
                    }
                )
        },
        updateTodo() {
            if (this.todo.completed == 1) return;

            // Edit status for selected Todo
            if (this.current.status === 0) {
                this.current.status = 1;
                this.$refs.name.focus();

            } else { // Save new todo
                let newTodo = {
                    id: this.todo.id,
                    name: this.todo.name,
                }

                // Name must not empty
                if (newTodo.name == '') {
                    alert('Name must not empty');
                    this.$refs.name.focus();
                    return false;
                }

                this.$store.dispatch('todo/edit', newTodo).then(
                    (res) => {
                        if (!res.error && res.success) {
                            this.current.status = 0;
                        }
                    },
                    (error) => {
                        console.log(error);
                    }
                )
            }
        }
    }
}
</script>

<style scoped>

    .completed {
        text-decoration: line-through;
        color: #999;
    }
</style>>