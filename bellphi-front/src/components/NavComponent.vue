<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light  bg-secondary">
            <img alt="Vue logo" src="../assets/park.svg" width="40px" />
            <router-link :to="{name:'Register'}" class="navbar-brand"> Home</router-link>
            <router-link :to="{name:'Register'}" class="navbar-brand" :class="{'text-white':currentPage==0}">Registro </router-link>
            <router-link :to="{name:'Rates'}" class="navbar-brand" :class="{'text-white':currentPage==1}">Tarifas </router-link>
            <router-link :to="{name:'Discount'}" class="navbar-brand" :class="{'text-white':currentPage==2}">Descuentos </router-link>
            <router-link :to="{name:'Exit'}" class="navbar-brand" :class="{'text-white':currentPage==3}">Salida de vehículo </router-link>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" :class="{'text-white':currentPage==4}">
                  Reportes
                </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <router-link :to="{name:'Place'}" class="dropdown-item" >Puesto mas usado</router-link>
                        <router-link :to="{name:'Vehicle'}" class="dropdown-item" >Entrada y salida de vehiculos</router-link>
                        <router-link :to="{name:'Count'}" class="dropdown-item" >Ingresos por tipo de vehículo</router-link>
                        <router-link :to="{name:'Earning'}" class="dropdown-item" >Ganancias</router-link>
                    </div>
                </li>
                <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#" @click.prevent="logout()">salir <i class="fas fa-sign-out-alt"></i></a>
                        </li>
                    </ul>
                </div>
            </ul>
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
                this.$router.replace({
                    name: 'Home'
                });
            }
        },
    }
</script>

