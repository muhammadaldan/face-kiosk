<template>
    <v-card class="shadow-sm">
        <v-tabs vertical>
            <v-tab>
                <v-icon left>
                    mdi-account
                </v-icon>
                Account
            </v-tab>
            <v-tab>
                <v-icon left>
                    mdi-lock
                </v-icon>
                Password
            </v-tab>

            <v-tab-item>
                <v-card flat>
                    <v-card-text>
                        <v-form
                            ref="formAccount"
                            v-model="valid1"
                            lazy-validation
                        >
                            <v-text-field
                                label="Name"
                                outlined
                                v-model="name"
                                :rules="required"
                                dense
                            ></v-text-field>
                            <v-text-field
                                label="Email"
                                outlined
                                v-model="email"
                                :rules="emailRules"
                                dense
                            ></v-text-field>
                            <v-btn
                                :disabled="!valid1"
                                color="success"
                                class="mr-4"
                                :loading="loading"
                                @click="updateAccount"
                            >
                                Update
                            </v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item>
                <v-card flat>
                    <v-card-text>
                        <v-form
                            ref="formPassword"
                            v-model="valid2"
                            lazy-validation
                        >
                            <v-text-field
                                v-model="current_password"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :rules="required"
                                :type="show1 ? 'text' : 'password'"
                                label="Current password"
                                outlined
                                dense
                                @click:append="show1 = !show1"
                            ></v-text-field>
                            <v-text-field
                                v-model="password"
                                :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                                :rules="required"
                                :type="show2 ? 'text' : 'password'"
                                label="New password"
                                outlined
                                dense
                                @click:append="show2 = !show2"
                            ></v-text-field>
                            <v-text-field
                                v-model="password_confirmation"
                                :append-icon="show3 ? 'mdi-eye' : 'mdi-eye-off'"
                                :rules="required"
                                :type="show3 ? 'text' : 'password'"
                                label="Password confirmation"
                                outlined
                                dense
                                @click:append="show3 = !show3"
                            ></v-text-field>
                            <v-btn
                                :disabled="!valid2"
                                color="success"
                                class="mr-4"
                                :loading="loading"
                                @click="updatePassword"
                            >
                                Update
                            </v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-tab-item>
        </v-tabs>

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
    </v-card>
</template>

<script>
export default {
    data() {
        return {
            dialog: false,
            alert: false,
            alertColor: "warning",
            notifications: false,
            messages: "",
            valid1: true,
            valid2: true,
            show1: false,
            show2: false,
            show3: false,
            current_password: "",
            password: "",
            password_confirmation: "",
            required: [v => !!v || "Cannot empty"],
            name: "",
            email: "",
            emailRules: [
                v => !!v || "E-mail is required",
                v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            ],

            disabled: true,
            loading: false
        };
    },
    methods: {
        updateAccount() {
            const vm = this;
            if (this.$refs.formAccount.validate()) {
                vm.loading = true;

                axios
                    .post("/setting-user", {
                        name: this.name,
                        email: this.email
                    })
                    .then(response => {
                        if (response.data.status) {
                            user.name = vm.name;
                            user.email = vm.email;
                            vm.alert = true;
                            vm.messages = "Success";
                            vm.alertColor = "success";
                        } else {
                            vm.messages = response.data.message[0];
                            vm.alertColor = "warning";
                            vm.alert = true;
                        }
                        vm.loading = false;
                    })
                    .catch(error => {
                        vm.loading = false;
                        alert("error");
                        console.error(error);
                    });
            }
        },
        updatePassword() {
            const vm = this;
            if (this.$refs.formAccount.validate()) {
                vm.loading = true;

                axios
                    .post("/setting-password", {
                        current_password: this.current_password,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    })
                    .then(response => {
                        if (response.data.status) {
                            vm.current_password = "";
                            vm.password = "";
                            vm.password_confirmation = "";
                            vm.alert = true;
                            vm.messages = "Success";
                            vm.alertColor = "success";
                            vm.$refs.formPassword.resetValidation();
                        } else {
                            vm.messages = response.data.message[0];
                            vm.alertColor = "warning";
                            vm.alert = true;
                        }
                        vm.loading = false;
                    })
                    .catch(error => {
                        vm.loading = false;
                        alert("error");
                        console.error(error);
                    });
            }
        }
    },
    mounted() {
        this.name = user.name;
        this.email = user.email;
    }
};
</script>
