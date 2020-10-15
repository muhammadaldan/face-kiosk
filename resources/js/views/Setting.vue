<template>
    <div>
        <v-card>
            <v-row class="p-6">
                <v-col cols="12">
                    <v-form ref="form" v-model="valid" lazy-validation>
                        <v-row>
                            <v-col cols="6" class="p-0">
                                <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    :return-value.sync="time"
                                    transition="scale-transition"
                                    offset-y
                                    max-width="290px"
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="time"
                                            label="Jam masuk"
                                            prepend-icon="mdi-clock-time-four-outline"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-time-picker
                                        v-if="menu"
                                        v-model="time"
                                        full-width
                                        @click:minute="$refs.menu.save(time)"
                                    ></v-time-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="6" class="p-0">
                                <v-menu
                                    ref="menu2"
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    :return-value.sync="time2"
                                    transition="scale-transition"
                                    offset-y
                                    max-width="290px"
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="time2"
                                            label="Jam pulang"
                                            prepend-icon="mdi-clock-time-four-outline"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-time-picker
                                        v-if="menu2"
                                        v-model="time2"
                                        full-width
                                        @click:minute="$refs.menu2.save(time2)"
                                    ></v-time-picker>
                                </v-menu>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            menu: false,
            menu2: false,
            alert: false,
            alertColor: "warning",
            notifications: false,
            messages: "",
            valid: true,
            required: [v => !!v || "Cannot empty"],
            id: "",
            time: "",
            time2: "",
            disabled: true,
            loading: false
        };
    },
    methods: {
        getData() {
            const vm = this;
            axios
                .get("/settings")
                .then(response => {
                    vm.id = response.data.data.id;
                    vm.time = response.data.data.arrival_time;
                    vm.time2 = response.data.data.waktu_pulang;
                })
                .catch(error => {
                    alert("error");
                    console.log(error);
                });
        },
        validate() {
            const vm = this;
            if (this.$refs.form.validate()) {
                vm.loading = true;
                axios
                    .put(`/settings/${vm.id}`, {
                        arrival_time: vm.time,
                        waktu_pulang: vm.time2
                    })
                    .then(response => {
                        if (response) {
                            vm.alert = true;
                            vm.messages = "success";
                            vm.alertColor = "success";
                        } else {
                            vm.alert = true;
                            vm.messages = response.data.message[0];
                            vm.alertColor = "danger";
                        }

                        vm.loading = false;
                    })
                    .catch(error => {
                        vm.loading = false;
                        console.log(error);
                        alert(error);
                    });
            }
        }
    },
    mounted() {
        this.getData();
    }
};
</script>
