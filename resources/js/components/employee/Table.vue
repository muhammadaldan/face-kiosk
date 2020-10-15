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
                { text: "Phone number", value: "phone_number" },
                { text: "Gender", value: "gender" },
                { text: "Photo", value: "photo" },
                { text: "Action", sortable: false, value: "id" }
            ],
            data: []
        };
    },
    methods: {
        loadModels() {
            const vm = this;
            Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri(
                    "/face-recognition/models"
                ),
                faceapi.nets.faceLandmark68Net.loadFromUri(
                    "/face-recognition/models"
                ),
                faceapi.nets.faceRecognitionNet.loadFromUri(
                    "/face-recognition/models"
                ),
                faceapi.nets.faceExpressionNet.loadFromUri(
                    "/face-recognition/models"
                ),
                // faceapi.nets.ageGenderNet.loadFromUri("/face-recognition/models"),
                faceapi.nets.ssdMobilenetv1.loadFromUri(
                    "/face-recognition/models"
                )
            ]).then(e => {
                this.$store.dispatch("Employee/getData").then(result => {
                    vm.loading = false;
                });
            });
        }
    },
    created() {
        this.$loadScript("/face-recognition/face-api.min.js")
            .then(() => {
                this.loadModels();
            })
            .catch(() => {
                // Failed to fetch script
            });
    }
};
</script>
