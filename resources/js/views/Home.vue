<template>
    <div>
        <v-card
            class="rounded-md shadow-sm sm:-mt-10 mt-0  px-4"
            :loading="loading"
            :disabled="loading"
        >
            <div class="sm:flex sm:flex-row flex-col py-4 justify-space-around">
                <div>
                    <apexchart
                        width="380"
                        height="200px"
                        type="donut"
                        :options="options"
                        :series="series"
                    ></apexchart>
                    <apexchart
                        class="ml-10"
                        width="380"
                        height="200px"
                        type="bar"
                        ref="seriesBar"
                        :options="optionsBar"
                        :series="seriesBar"
                    ></apexchart>
                </div>
                <v-date-picker
                    v-model="picker"
                    @change="getData()"
                ></v-date-picker>
            </div>
            <v-data-table
                :headers="headers"
                :items="data"
                :loading="loading"
                :items-per-page="5"
                class="elevation-0 mt-5"
                :search="search"
            >
                <template v-slot:[`item.id`]="{ item }">
                    <span>{{ item.employee.nim }}</span>
                </template>
                <template v-slot:[`item.employee`]="{ item }">
                    <span>{{ item.employee.name }}</span>
                </template>
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            options: {
                colors: ["#0e9f6e", "#f05252"],
                labels: ["On time", "Late"]
            },
            series: [],
            optionsBar: {
                legend: {
                    show: true,
                    showForSingleSeries: true
                },
                xaxis: {
                    categories: ["00:00"]
                }
            },
            seriesBar: [
                {
                    name: "Arrival time",
                    data: [0]
                }
            ],
            loading: true,
            search: "",
            date: new Date(), // Or the date you'd like converted.
            picker: new Date().toISOString().substr(0, 10),
            headers: [
                {
                    text: "Id",
                    align: "start",
                    value: "id"
                },
                { text: "Name", value: "employee" },
                { text: "Arrival time", value: "arrival" },
                { text: "Waktu pulang", value: "waktu_pulang" }
            ],
            data: []
        };
    },
    methods: {
        getData() {
            this.loading = true;
            axios
                .get("/api/abcent?date=" + this.picker)
                .then(response => {
                    this.data = response.data.table;
                    this.series = response.data.pie;
                    this.optionsBar.xaxis.categories = response.data.bar_label;
                    this.seriesBar[0].data = response.data.bar_value;
                    this.$refs.seriesBar.updateOptions(this.optionsBar);
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    alert("error");
                    console.error(error);
                });
        }
    },
    mounted() {
        this.getData();
        let date = new Date(); // Or the date you'd like converted.
        this.picker = new Date(
            date.getTime() - date.getTimezoneOffset() * 60000
        )
            .toISOString()
            .substr(0, 10);
    }
};
</script>
