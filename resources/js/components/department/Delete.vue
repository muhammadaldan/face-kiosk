<template>
    <div class="inline">
        <v-btn
            color="danger white--text"
            depressed
            small
            dark
            @click.stop="dialog = true"
        >
            Delete
        </v-btn>

        <v-dialog v-model="dialog" max-width="290">
            <v-card>
                <v-card-title class="headline">
                    Delete data ?
                </v-card-title>

                <v-card-text>
                    You cannot prevent this action
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn color="green darken-1" text @click="dialog = false">
                        Disagree
                    </v-btn>

                    <v-btn
                        color="red darken-1"
                        text
                        @click="deleteData()"
                        :loading="loading"
                    >
                        Agree
                    </v-btn>
                </v-card-actions>
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
            loading: false,
            alertColor: "warning",
            messages: ""
        };
    },
    methods: {
        deleteData() {
            const vm = this;
            vm.loading = true;
            const obj = {
                id: this.data.id
            };

            this.$store
                .dispatch("Department/deleteData", obj)
                .then(response => {
                    if (response.data.status) {
                        vm.alert = true;
                        vm.messages = "Success";
                        vm.alertColor = "success";
                    } else {
                        vm.messages = response.data.message[0];
                        vm.alertColor = "warning";
                        vm.alert = true;
                    }
                    vm.dialog = false;
                    vm.loading = false;
                })
                .catch(err => {
                    vm.loading = false;
                    vm.dialog = false;
                    alert("error");
                    console.log(err);
                });
        }
    }
};
</script>
