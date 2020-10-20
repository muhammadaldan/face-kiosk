<template>
    <div class="inline">
        <v-dialog
            v-model="dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="success"
                    depressed
                    class="mr-4"
                    dark
                    small
                    v-bind="attrs"
                    v-on="on"
                >
                    Update
                </v-btn>
            </template>
            <v-card>
                <v-toolbar dark color="primary">
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Add</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-row class="p-6">
                    <v-col cols="12" md="6">
                        <v-form ref="form" v-model="valid" lazy-validation>
                            <v-row>
                                <v-col cols="10" class="p-0">
                                    <v-text-field
                                        label="ID"
                                        outlined
                                        v-model="nim"
                                        :rules="required"
                                        dense
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="10" class="p-0">
                                    <v-text-field
                                        label="Name"
                                        outlined
                                        v-model="name"
                                        :rules="required"
                                        dense
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="10" class="p-0 ">
                                    <v-radio-group
                                        v-model="gender"
                                        class="mt-0"
                                    >
                                        <v-radio
                                            label="Male"
                                            value="Male"
                                        ></v-radio>
                                        <v-radio
                                            label="Female"
                                            value="Female"
                                        ></v-radio>
                                    </v-radio-group>
                                </v-col>
                                <v-col cols="10" class="p-0">
                                    <v-text-field
                                        label="Phone number"
                                        outlined
                                        dense
                                        v-model="phone_number"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="10" class="p-0">
                                    <v-select
                                        label="Deparmtent"
                                        outlined
                                        dense
                                        :items="
                                            $store.state.Employee.department
                                        "
                                        v-model="department_id"
                                    ></v-select>
                                </v-col>
                                <v-col cols="10" class="p-0">
                                    <v-text-field
                                        label="Email"
                                        type="email"
                                        outlined
                                        dense
                                        v-model="email"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="10" class="p-0">
                                    <v-btn
                                        :disabled="!valid"
                                        color="success"
                                        class="mr-4"
                                        :loading="loading"
                                        @click="validate"
                                    >
                                        Submit
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-col>
                    <v-col cols="12" md="6" class="p-0">
                        <v-btn class="warning" @click="startVideo()"
                            >Open Cam</v-btn
                        >
                        <v-btn
                            class="success"
                            @click="snapshot()"
                            :disabled="disabled"
                            >Take picture</v-btn
                        >
                        <div class="w-full relative">
                            <video id="take-picture2" autoplay muted></video>
                            <h1
                                class="transition-all absolute text-6xl text-white"
                                style="top: 50%;left: 50%;transform: translate(-50%, -50%);"
                            >
                                {{ timer }}
                            </h1>
                            <canvas
                                id="picture"
                                class="w-full hidden mb-3"
                            ></canvas>
                            <img
                                :src="imageShow"
                                id="image"
                                width="180"
                                class="my-2"
                            />
                        </div>
                    </v-col>
                </v-row>
            </v-card>
        </v-dialog>

        <v-dialog v-model="alert" max-width="350">
            <v-card :color="alertColor">
                <v-card-title></v-card-title>
                <v-card-text class="white--text">
                    {{ messages }}
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="white" text @click="alert = false">
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="processingImage" hide-overlay persistent width="300">
            <v-card color="primary" dark>
                <v-card-text>
                    Processing image
                    <v-progress-linear
                        indeterminate
                        color="white"
                        class="mb-0"
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: {
        data: Object
    },
    data() {
        return {
            dialog: false,
            alert: false,
            alertColor: "warning",
            gender: this.data.gender,
            processingImage: false,
            valid: true,
            required: [v => !!v || "Cannot empty"],
            timer: null,
            image: "",
            imageShow: this.data.photo,
            nim: this.data.nim,
            email: this.data.email,
            name: this.data.name,
            phone_number: this.data.phone_number,
            department_id: this.data.department_id,
            disabled: true,
            messages: "",
            loading: false
        };
    },
    methods: {
        validate() {
            const vm = this;
            if (this.$refs.form.validate()) {
                vm.loading = true;
                const obj = {
                    name: this.name,
                    gender: this.gender,
                    email: this.email,
                    phone_number: this.phone_number,
                    department_id: this.department_id,
                    nim: this.nim,
                    image: this.image,
                    id: this.data.id
                };

                this.$store
                    .dispatch("Employee/updateData", obj)
                    .then(response => {
                        if (response.data.status) {
                            vm.alert = true;
                            vm.messages = "Success";
                            vm.alertColor = "success";
                            vm.$refs.form.resetValidation();
                        } else {
                            vm.messages = response.data.message[0];
                            vm.alertColor = "warning";
                            vm.alert = true;
                        }
                        vm.loading = false;
                    })
                    .catch(err => {
                        vm.loading = false;
                        alert("error");
                        console.log(err);
                    });
            }
        },
        startVideo() {
            const video = document.getElementById("take-picture2");
            const hdConstraints = {
                audio: false,
                video: {
                    facingMode: "user",
                    width: { ideal: 4096 },
                    height: { ideal: 2160 }
                }
            };
            navigator.mediaDevices.getUserMedia(hdConstraints).then(
                stream => (video.srcObject = stream),

                err => console.log(err)
            );
            this.disabled = false;
        },
        init() {
            var canvas, ctx;
            // Get the canvas and obtain a context for
            // drawing in it
            canvas = document.getElementById("picture");
            ctx = canvas.getContext("2d");
        },
        async check_image(img) {
            const check_image = await faceapi.fetchImage(img);
            const detections = await faceapi
                .detectSingleFace(check_image)
                .withFaceLandmarks()
                .withFaceDescriptor();

            return detections;
        },
        timeCountDown() {
            if (this.timer > 0) {
                setTimeout(() => {
                    this.timer -= 1;
                    this.timeCountDown();
                }, 1000);
            } else {
                this.timer = null;
                this.processingImage = true;
                const video = document.getElementById("take-picture2");
                // const canvas = document.getElementById("picture");
                const canvas = document.createElement("canvas");

                const img = document.querySelector("#image");
                const ctx = canvas.getContext("2d");
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext("2d").drawImage(video, 0, 0);
                // Other browsers will fall back to image/png
                const imgData = canvas.toDataURL("image/png");
                img.src = imgData;
                // // Draws current image from the video element into the canvas
                // ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                // ctx.style.transform = "scale3d(0.5,0.5,0)";
                // const image = canvas.toDataURL({ pixelRatio: 2 });
                this.check_image(imgData).then(response => {
                    if (response) {
                        this.image = imgData;
                    } else {
                        this.alert = true;
                        this.alertColor = "warning";
                        this.messages =
                            "Gagal memverifikasi wajah, mohon tunjunkan dahi, dan muka";
                        this.image = "";
                    }
                    this.processingImage = false;
                });
            }
        },
        snapshot() {
            this.timer = 3;
            console.log(this.timer);
            this.timeCountDown();
        }
    },
    mounted() {}
};
</script>

<style>
video {
    height: 70vh;
    object-fit: cover;
    transform: scaleX(-1);
}
</style>
