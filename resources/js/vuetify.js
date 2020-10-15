import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import "@mdi/font/css/materialdesignicons.css";

Vue.use(Vuetify);

const opts = {
    theme: {
        themes: {
            light: {
                primary: "#0096c7",
                error: "#E91D14",
                success: "#30CB00",
                warning: "#FBAF39",
                danger: "#E91D14"
            }
        }
    }
};

export default new Vuetify(opts);
