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
                    v-on="on"
                >
                    Add
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
                                        label="Name"
                                        outlined
                                        v-model="name"
                                        :rules="required"
                                        dense
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
    </v-row>
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
            valid: true,
            required: [v => !!v || "Cannot empty"],
            name: "",
            disabled: true,
            loading: false
        };
    },
    methods: {
        validate() {
            const vm = this;
            if (this.$refs.form.validate()) {
                vm.loading = true;
                const obj = {
                    name: this.name
                };

                this.$store
                    .dispatch("Department/addData", obj)
                    .then(response => {
                        if (response.data.status) {
                            vm.name = "";
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
        }
    },
    mounted() {}
};
</script>
