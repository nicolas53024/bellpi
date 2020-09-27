import Vue from "vue";
import VueRouter from "vue-router";
// import store from "../store/index.js";
import Home from "../views/Home.vue";
import Register from "../views/Register.vue";
import Stored from "../views/Stored.vue";
import Rates from "../views/Rates.vue";
import Discount from "../views/Discount.vue";
import Exit from "../views/Exit.vue";

Vue.use(VueRouter);

const routes = [{
        path: "/",
        name: "Home",
        component: Home
    },
    {
        path: "/register",
        name: "Register",
        // meta: {
        //     requiresAuth: true
        // },
        component: Register
    },
    {
        path: "/stored/:type",
        name: "Stored",
        // meta: {
        //     requiresAuth: true
        // },
        component: Stored
    },
    {
        path: "/tarifas",
        name: "Rates",
        // meta: {
        //     requiresAuth: true
        // },
        component: Rates
    },
    {
        path: "/descuentos",
        name: "Discount",
        // meta: {
        //     requiresAuth: true
        // },
        component: Discount
    },
    {
        path: "/exit",
        name: "Exit",
        // meta: {
        //     requiresAuth: true
        // },
        component: Exit
    },
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});
//proteger rutas
// router.beforeEach((to, from, next) => {
//     if (to.matched.some(record => record.meta.requiresAuth)) {
//         if (store.state.authenticated) {
//             next();
//         } else {
//             next({ name: "Home" });
//         }
//     } else {
//         next();
//     }
// });
export default router;