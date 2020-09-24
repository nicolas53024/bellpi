<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light  bg-secondary">
            <img alt="Vue logo" src="../assets/park.svg" width="40px" />
            <router-link to="/" class="navbar-brand"> Home</router-link>
            <router-link to="/" class="navbar-brand text-white"><u>Registro</u> </router-link>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" @click.prevent="logout()"><u>salir <i class="fas fa-sign-out-alt"></i></u></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
    import {
        mapActions
    } from 'vuex'
    export default {
        props: {
            currentPage: String
        },
        methods: {
            ...mapActions({
                logoutAction: 'logout'
            }),
            async logout() {
                await this.logoutAction();
                 this.$router.replace({ name: 'Home' });
            }
        },
    }
</script>

