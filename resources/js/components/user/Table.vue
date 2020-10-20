<template>
    <v-card>
        <v-card-title>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                class="sm:w-1/3 w-2/3"
                single-line
                hide-details
            ></v-text-field>
            <div class="sm:w-2/3 w-1/3">
                <v-add></v-add>
            </div>
        </v-card-title>
        <v-data-table
            :loading="loading"
            :headers="headers"
            :items="$store.state.User.data"
            :items-per-page="5"
            class="elevation-1"
            :search="search"
        >
            <template v-slot:[`item.id`]="{ item }">
                <v-delete :data="item"></v-delete>
                <v-update :data="item"></v-update>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import VAdd from "./Add.vue";
import VUpdate from "./Update.vue";
import VDelete from "./Delete.vue";

export default {
    components: {
        VAdd,
        VUpdate,
        VDelete
    },
    data() {
        return {
            search: "",
            loading: true,
            headers: [
                {
                    text: "Name",
                    value: "name"
                },
                {
                    text: "Email",
                    value: "email"
                },
                { text: "Action", sortable: false, value: "id" }
            ],
            data: []
        };
    },
    methods: {},
    mounted() {
        const vm = this;
        this.$store.dispatch("User/getData").then(result => {
            vm.loading = false;
        });
    }
};
</script>
