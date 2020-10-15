import Vue from "vue";
import App from "./layouts/App.vue";
import router from "./router/index.js";
import store from "./store";
import LoadScript from "vue-plugin-load-script";

// Vuetify Style
import vuetify from "./vuetify";

Vue.config.productionTip = false;

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios = require("axios");

window.axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
};

Vue.use(LoadScript);

new Vue({
    store,
    router,
    vuetify,
    render: h => h(App)
}).$mount("#app");
