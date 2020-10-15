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
            :headers="headers"
            :items="$store.state.Employee.data"
            :loading="loading"
            :items-per-page="5"
            class="elevation-1"
            :search="search"
        >
            <template v-slot:[`item.photo`]="{ item }">
                <v-avatar>
                    <img :src="item.photo" :alt="item.name" />
                </v-avatar>
            </template>
            <template v-slot:[`item.department`]="{ item }">
                <span>{{ item.department.name }}</span>
            </template>
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
                    text: "Id",
                    align: "start",
                    value: "nim"
                },
                { text: "Name", value: "name" },
                { text: "Department", value: "department" },
                { text: "Email", value: "email" },
                { text: "phone_number", value: "phone_number" },
                { text: "Gender", value: "gender" },
                { text: "Photo", value: "photo" },
                { text: "Action", sortable: false, value: "id" }
            ],
            data: []
        };
    },
    mounted() {
        const vm = this;
        this.$store.dispatch("Employee/getData").then(result => {
            vm.loading = false;
        });
    }
};
</script>
