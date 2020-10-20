import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";
// import store from "./../store";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes
});

// router.replace({ path: "/", redirect: "/" });

router.beforeEach((to, from, next) => {
    if (to.name === "user" && user.id !== 1) {
        router.replace({ path: "/", redirect: "/" });
    }
    next();
});

// router.afterEach((to, from) => {
//     store.commit("Loading/SET_SPINNER", false);
// });

export default router;
