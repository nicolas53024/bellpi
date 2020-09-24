import Vue from "vue";
import App from "./App.vue";
import "./registerServiceWorker";
import router from "./router/router.js";
import store from "./store";
import Vuelidate from 'vuelidate';
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);
Vue.use(Vuelidate)


new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app");