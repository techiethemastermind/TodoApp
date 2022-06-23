<template>
    <nav-component></nav-component>
</template>

<script>
import NavComponent from './components/NavComponent.vue'

export default {
    components: {
        NavComponent
    },
    computed: {
        loggedIn() {
            return this.$store.state.auth.status.loggedIn;
        },
    },
    created() {
        if (this.loggedIn) {
            this.$router.push("/todo");
        } else {
            this.$router.push("/login");
        }
    }
}
</script>