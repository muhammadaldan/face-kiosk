const state = {
    data: [],
    department: []
};

const mutations = {
    SET_DATA(state, payload) {
        state.data = payload;
    },
    SET_DEPARTMENT(state, payload) {
        state.department = payload;
    },
    ADD_DATA(state, payload) {
        state.data.unshift(payload);
    },
    UPDATE_DATA(state, payload) {
        const dataIndex = state.data.findIndex(p => p.id === payload.id);
        Object.assign(state.data[dataIndex], payload);
    },
    DELETE_DATA(state, itemId) {
        const dataIndex = state.data.findIndex(p => p.id === itemId);
        state.data.splice(dataIndex, 1);
    }
};

const getters = {
    getGeneration: state => {
        return state.data;
    }
};

const actions = {
    async getData({ commit }) {
        return new Promise((resolve, reject) => {
            axios
                .get("/departments")
                .then(response => {
                    commit("SET_DATA", response.data.data);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        });
    },
    async addData({ commit }, data) {
        return new Promise((resolve, reject) => {
            let formData = new FormData();
            formData.append("name", data.name);
            axios
                .post("/departments", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    if (response.data.status) {
                        commit("ADD_DATA", response.data.data);
                    }
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        });
    },
    async updateData({ commit }, data) {
        return new Promise((resolve, reject) => {
            axios
                .put(`/departments/${data.id}`, { name: data.name })
                .then(response => {
                    if (response.data.status) {
                        commit("UPDATE_DATA", response.data.data);
                    }
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        });
    },
    async deleteData({ commit }, data) {
        return new Promise((resolve, reject) => {
            axios
                .delete(`/departments/${data.id}`)
                .then(response => {
                    commit("DELETE_DATA", data.id);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
};
