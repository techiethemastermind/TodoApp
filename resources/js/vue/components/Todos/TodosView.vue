<template>
    <ul class="todo-view">
        <li v-for="(todo, index) in todos" :key="index" class="todo-item mt-4">
            <todo-item :todo="todo" v-on:todoChange="$emit('reloadTodos')"></todo-item>
        </li>
    </ul>
</template>

<script>
import TodoItem from './TodoItem.vue';

export default {
    props: ['todos'],  
    components: {
        TodoItem
    }
}
</script>