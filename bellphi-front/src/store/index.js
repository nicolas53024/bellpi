import Vue from "vue";
import Vuex from "vuex";
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000';
Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        authenticated: false,
        user: null,
        placa: '',
        customer: '',
        idPlace: 0
    },
    mutations: {
        SET_USER(state, user) {
            state.user = user;
        },
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value;
        },
        SET_PLACA(state, value) {
            state.placa = value;
        },
        SET_CUSTOMER(state, value) {
            state.customer = value;
        },
        SET_PLACE(state, value) {
            state.idPlace = value;
        }
    },
    actions: {
        async login({ dispatch }, credentials) {
            await axios.get('/sanctum/csrf-cookie');
            await axios.post('/login', credentials);
            return dispatch("getUser");
        },
        async logout({ dispatch }) {
            await axios.get('/sanctum/csrf-cookie');
            await axios.post('/logout');
            return dispatch("getUser");
        },
        getUser({ commit }) {
            axios.get('api/user').then((res) => {
                commit('SET_USER', res.data);
                commit('SET_AUTHENTICATED', true);
            }).catch(() => {
                commit('SET_USER', null);
                commit('SET_AUTHENTICATED', false);
            })
        }

    },
    modules: {}
});