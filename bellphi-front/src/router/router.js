import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store/index.js";
import Home from "../views/Home.vue";
import Register from "../views/Register.vue";
import Stored from "../views/Stored.vue";
import Rates from "../views/Rates.vue";
import Discount from "../views/Discount.vue";
import Exit from "../views/Exit.vue";
import Place from "../views/PlaceReport.vue";
import Vehicle from "../views/VehicleReport.vue";
import Count from "../views/CountReport.vue";
import Earning from "../views/EarningReport.vue";

Vue.use(VueRouter);

const routes = [{
        path: "/",
        name: "Home",
        component: Home
    },
    {
        path: "/register",
        name: "Register",
        meta: {
            requiresAuth: true
        },
        component: Register
    },
    {
        path: "/stored/:type",
        name: "Stored",
        meta: {
            requiresAuth: true
        },
        component: Stored
    },
    {
        path: "/tarifas",
        name: "Rates",
        meta: {
            requiresAuth: true
        },
        component: Rates
    },
    {
        path: "/descuentos",
        name: "Discount",
        meta: {
            requiresAuth: true
        },
        component: Discount
    },
    {
        path: "/exit",
        name: "Exit",
        meta: {
            requiresAuth: true
        },
        component: Exit
    },
    {
        path: "/place-report",
        name: "Place",
        meta: {
            requiresAuth: true
        },
        component: Place
    },
    {
        path: "/vehicle-report",
        name: "Vehicle",
        meta: {
            requiresAuth: true
        },
        component: Vehicle
    },
    {
        path: "/count-report",
        name: "Count",
        meta: {
            requiresAuth: true
        },
        component: Count
    },
    {
        path: "/earning-report",
        name: "Earning",
        meta: {
            requiresAuth: true
        },
        component: Earning
    },
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.state.authenticated) {
            next();
        } else {

            next({ name: "Home" });
        }
    } else {
        next();
    }

});
export default router;