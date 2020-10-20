<template>
    <v-card class="p-8">
        <v-row>
            <v-col cols="12" sm="4">
                <v-date-picker
                    v-model="dates"
                    range
                    color="blue"
                ></v-date-picker>
            </v-col>
            <v-col cols="12" sm="6">
                <v-text-field
                    v-model="dateRangeText"
                    label="Date range"
                    prepend-icon="mdi-calendar"
                    readonly
                ></v-text-field>
                <v-btn
                    color="success"
                    elevation="0"
                    @click="printExcel"
                    :loading="loading1"
                    >Excel</v-btn
                >
                <v-btn
                    color="warning"
                    elevation="0"
                    @click="printPdf"
                    :loading="loading2"
                    >PDF</v-btn
                >
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
export default {
    data() {
        return {
            dates: [new Date().toISOString().substr(0, 10)],
            loading1: false,
            loading2: false
        };
    },
    computed: {
        dateRangeText() {
            return this.dates.join(" ~ ");
        }
    },
    methods: {
        printExcel() {
            const vm = this;
            vm.loading1 = true;
            axios
                .post(
                    `/report/excel`,
                    { date: vm.dates },
                    {
                        responseType: "blob"
                    }
                )
                .then(response => {
                    vm.loading1 = false;

                    const url = URL.createObjectURL(
                        new Blob([response.data], {
                            type: "application/vnd.ms-excel"
                        })
                    );
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", "report " + vm.dateRangeText);
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(error => {
                    vm.loading1 = false;
                    console.log(error);
                    alert(error);
                });
        },
        printPdf() {
            const vm = this;
            vm.loading2 = true;
            axios
                .post(
                    `/report/pdf`,
                    { date: vm.dates },
                    {
                        responseType: "arraybuffer"
                    }
                )
                .then(response => {
                    vm.loading2 = false;

                    const url = URL.createObjectURL(
                        new Blob([response.data], {
                            type: "application/pdf"
                        })
                    );
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", "report " + vm.dateRangeText);
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(error => {
                    vm.loading2 = false;
                    console.log(error);
                    alert(error);
                });
        }
    },
    mounted() {
        let date = new Date(); // Or the date you'd like converted.
        this.dates = [
            new Date(date.getTime() - date.getTimezoneOffset() * 60000)
                .toISOString()
                .substr(0, 10)
        ];
    }
};
</script>
