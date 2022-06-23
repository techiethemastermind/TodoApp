<template>
    <section class="main-content gradient-form bg-gray-200">
        <div class="container py-10 px-6 h-full mx-auto">
            <div class="flex justify-center items-center flex-wrap g-6 text-gray-800">
                <div class="lg:w-6/12 w-full">
                    <div class="block bg-white shadow-lg rounded-lg">
                        <div class="p-6 md:p-12 md:mx-6">
                            <div class="text-center block">
                                <h3 class="text-2xl font-semibold mt-1 mb-12 pb-1">Your Profile</h3>
                            </div>

                            <div v-if="message.success" class="bg-teal-100 border border-teal-400 rounded text-teal-900 px-4 py-2 relative mb-4" role="alert">
                                <p>{{ message.success }}</p>
                                <span class="absolute top-0 bottom-0 right-0 px-4 py-2" @click="message.success = ''">
                                    <svg class="fill-current h-6 w-6 text-red-500" role="button" 
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <title>Close</title>
                                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                                </span>
                            </div>

                            <div v-if="message.error" class="border border-red-400 bg-red-100 px-4 py-2 text-red-700 rounded relative mb-4" role="alert">
                                <p>{{ message.error }}</p>
                                <span class="absolute top-0 bottom-0 right-0 px-4 py-2" @click="message.error = ''">
                                    <svg class="fill-current h-6 w-6 text-red-500" role="button" 
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <title>Close</title>
                                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                                </span>
                            </div>

                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 font-bold mb-2">Name: </label>
                                <input
                                    type="text"
                                    class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 
                                    bg-white bg-clip-padding border border-solid border-gray-300 rounded transition 
                                    ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    id="name"
                                    placeholder="Name"
                                    v-model="user.name"
                                />
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-bold mb-2">Email: </label>
                                <input
                                    type="text"
                                    class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 
                                    bg-white bg-clip-padding border border-solid border-gray-300 rounded transition 
                                    ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    id="email"
                                    placeholder="Email"
                                    v-model="user.email"
                                />
                            </div>

                            <div class="text-center pt-1 mb-12 pb-1">
                                <button
                                    class="inline-block px-6 py-2.5 text-white font-medium text-xs leading-tight uppercase 
                                    rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:shadow-lg focus:outline-none 
                                    focus:ring-0 active:shadow-lg transition duration-150 ease-in-out w-full mb-3 my-bg-gradiant"
                                    type="button"
                                    data-mdb-ripple="true"
                                    data-mdb-ripple-color="light"
                                    @click="handleUpdate"
                                >
                                    <span>Update</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    export default {
        data() {
            return {
                user: {
                    id: '',
                    email: '',
                    name: ''
                },
                message: {
                    error: '',
                    success: ''
                }
            }
        },
        created() {
            this.getUserInfo();
        },
        methods: {
            getUserInfo() {
                this.$store.dispatch('auth/userInfo').
                    then(
                        res => {
                            this.user.id = res.id;
                            this.user.email = res.email;
                            this.user.name = res.name;
                        },
                        error => {
                            this.message.error = error.toString();
                        }
                    )
            },
            handleUpdate() {
                this.$store.dispatch('auth/update', this.user)
                    .then(
                        (res) => {
                            if (res.error && res.error.email) {
                                this.message.error = res.error.email.toString();
                            }

                            if (res.error && res.error.name) {
                                this.message.error = res.error.name.toString();
                            }
                            
                            if (!res.error && res.success) {
                                this.message.success = 'Successfully Updated';
                            }
                        },
                        error => {
                            this.message.error = error.toString();
                        }
                    )
            }
        }
    }
</script>