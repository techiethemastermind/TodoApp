<template>
    <div id="nav" class="flex items-center justify-between flex-wrap p-6 my-bg-gradiant">
        <div class="flex items-center flex-shrink-0 text-white mr-6">
            <svg class="fill-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z" />
            </svg>
            <span class="font-semibold text-xl tracking-tight xs-hide">Todo List</span>
        </div>
        <div class="flex-grow flex items-right w-auto">
            <div class="text-sm flex-grow"></div>
            <div class="text-right">
                <router-link to="/login" v-if="!isLogined" class="inline-block text-sm px-4 py-2 leading-none border 
                    rounded text-white border-white hover:border-transparent 
                    hover:text-teal-500 hover:bg-white lg:mt-0 mr-3">Login</router-link>
                <router-link to="/register" v-if="!isLogined" class="inline-block text-sm px-4 py-2 leading-none border 
                    rounded text-white border-white hover:border-transparent 
                    hover:text-teal-500 hover:bg-white lg:mt-0">Register</router-link>

                <router-link to="/todo" v-if="isLogined" class="inline-block text-sm px-4 py-2 leading-none border 
                    rounded text-white border-white hover:border-transparent 
                    hover:text-teal-500 hover:bg-white lg:mt-0 mr-3">Todo</router-link>
                <router-link to="/profile" v-if="isLogined" class="inline-block text-sm px-4 py-2 leading-none border 
                    rounded text-white border-white hover:border-transparent 
                    hover:text-teal-500 hover:bg-white lg:mt-0 mr-3">Profile</router-link>
                <button v-if="isLogined" class="inline-block text-sm px-4 py-2 leading-none border 
                    rounded text-white border-white hover:border-transparent 
                    hover:text-teal-500 hover:bg-white lg:mt-0" @click="handleLogout">Logout</button>
            </div>
        </div>
    </div>
    <router-view v-on:loginStatus="checkLogins()" />
</template>

<script>
export default {
    data () {
        return {
            isLogined: false
        }
    },
    computed: {
        loggedIn() {
            return this.$store.state.auth.status.loggedIn;
        },
    },
    created() {
        if (this.loggedIn) {
            this.isLogined = true;
            this.$router.push("/todo");
        }
    },
    methods: {
        handleLogout() {
            this.$store.dispatch("auth/logout").then(
                (res) => {
                    this.isLogined = false;
                    this.$router.push("/login");
                }
            )
        },
        checkLogins() {
            this.isLogined = this.$store.state.auth.status.loggedIn;
        }
    }
}
</script>