import Vue from "vue";
import App from "./App.vue";
import "./registerServiceWorker";
import router from "./router/router.js";
import store from "./store";
import Vuelidate from 'vuelidate';
import lodash from 'lodash';
import VueSweetalert2 from 'vue-sweetalert2';
const mixin = require('./assets/Mixin.js');
Vue.use(VueSweetalert2);
Vue.use(Vuelidate);
Vue.use(lodash);


new Vue({
    router,
    store,
    mixins: [mixin],
    render: h => h(App)
}).$mount("#app");