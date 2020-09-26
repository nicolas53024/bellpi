import Vue from "vue";
Vue.mixin({
    data() {
        return {
            baseUrl: "http://localhost:8000"
        }
    },
    filters: {
        lower(string) {
            return string.toLowerCase();
        },
    },
    methods: {
        getTypeVehicle(type) {
            let retorno = 0;
            switch (type) {
                case "car":
                    retorno = 1;
                    break;
                case "motor":
                    retorno = 2;
                    break;
                case "bicycle":
                    retorno = 3;
                    break;
            };
            return retorno;
        },
    },
})