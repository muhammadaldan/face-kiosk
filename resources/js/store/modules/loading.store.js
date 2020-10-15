const state = {
    spinner: false,
}

const mutations = {
    SET_SPINNER(state, paramState) {
        if (typeof paramState == 'boolean') state.spinner = paramState;
    },
}

export default {
    namespaced: true,
    state,
    mutations
}
