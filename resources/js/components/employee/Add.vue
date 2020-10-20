<template>
    <v-row justify="end">
        <v-dialog
            v-model="dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="primary"
                    class="mr-4"
                    dark
                    v-bind="attrs"
                    :disabled="disabledWait"
                    v-on="on"
                >
                    Add
                </v-btn>
            </template>
            <v-card>
                <v-toolbar dark color="primary">
                    <v-btn icon dark @click="closeDialog()">
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
                                    <v-select
                                        label="Department"
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
                                        label="Phone number"
                                        outlined
                                        dense
                                        v-model="phone_number"
                                    ></v-text-field>
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
                            <video id="take-picture" autoplay muted></video>
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
                                src="/assets/images/no-image.png"
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
    </v-row>
</template>

<script>
export default {
    data() {
        return {
            dialog: false,
            alert: false,
            processingImage: false,
            alertColor: "warning",
            notifications: false,
            messages: "",
            sound: true,
            widgets: false,
            gender: "Male",
            valid: true,
            required: [v => !!v || "Cannot empty"],
            timer: null,
            image: "",
            nim: "",
            email: "",
            name: "",
            phone_number: "",
            department_id: "",
            messages: "",
            disabled: true,
            loading: false
        };
    },
    props: ["disabledWait"],
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
                    nim: this.nim,
                    department_id: this.department_id,
                    image: this.image
                };

                this.$store
                    .dispatch("Employee/addData", obj)
                    .then(response => {
                        if (response.data.status) {
                            vm.name = "";
                            vm.nim = "";
                            vm.department_id = "";
                            vm.image = "";
                            vm.phone_number = "";
                            vm.email = "";
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
            const video = document.getElementById("take-picture");
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
            const vm = this;
            if (this.timer > 0) {
                setTimeout(() => {
                    this.timer -= 1;
                    this.timeCountDown();
                }, 1000);
            } else {
                this.timer = null;
                this.processingImage = true;
                const video = document.getElementById("take-picture");
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
                        vm.alert = true;
                        vm.alertColor = "warning";
                        vm.messages =
                            "Gagal memverifikasi wajah, mohon tunjunkan dahi, dan muka";
                        this.image = "";
                    }
                    vm.processingImage = false;
                });
            }
        },
        snapshot() {
            this.timer = 3;
            console.log(this.timer);
            this.timeCountDown();
        },
        closeDialog() {
            this.dialog = false;
            this.image = "";
            const img = document.querySelector("#image");
            img.src = "/assets/images/no-image.png";
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
