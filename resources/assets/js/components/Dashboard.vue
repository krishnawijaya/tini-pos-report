<template>
    <v-container>
        <v-row>
            <v-col cols="2" />

            <v-col class="text-center text-black">
                <div class="text-h4">Tini POS</div>
                <div class="text-caption">
                    Sistem Informasi Point of Sales Berbasis Web
                </div>
            </v-col>

            <v-col cols="2">
                <v-select v-model="reportType"
                          :items="reportTypes"
                          variant="outlined"
                          density="compact"
                          base-color="#333"
                          color="#333" />
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12"
                   sm="4">
                <v-card :title="`Pendapatan ${titleReportType} Ini`">
                    <template #text>
                        <div class="text-h4 text-right">
                            {{ currencyFormat(topbarData.revenue) }}
                        </div>
                    </template>
                </v-card>
            </v-col>

            <v-col cols="12"
                   sm="4">
                <v-card :title="`Jumlah Transaksi ${titleReportType} Ini`">
                    <template #text>
                        <div class="text-h4 text-right">
                            {{ topbarData.total_transactions }}
                            Transaksi
                        </div>
                    </template>
                </v-card>
            </v-col>

            <v-col cols="12"
                   sm="4">
                <v-card :title="`Laba Rugi ${titleReportType} Ini`">
                    <template #text>
                        <div class="text-h4 text-right">
                            {{ currencyFormat(topbarData.profit_and_loss) }}
                        </div>
                    </template>
                </v-card>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <div class="mt-12 text-h6 text-grey-darken-3 d-flex">
                    <i class="voyager-bar-chart d-flex align-center mr-2" />
                    <span>Grafik Jumlah Transaksi</span>
                </div>
            </v-col>

            <v-col cols="12">

                <v-sheet class="pa-10 elevation-3"
                         rounded="lg">

                    <bar v-if="chartData.labels.length"
                         :data="chartData"
                         :options="chartOptions" />

                    <div v-else
                         class="text-h5">Tidak ada data</div>
                </v-sheet>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mixin } from "../helper"
import { Bar } from "vue-chartjs"
import { Chart as ChartJS, Tooltip, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Tooltip, BarElement, CategoryScale, LinearScale)

export default {
    name: "Dashboard",
    mixins: [mixin],
    components: { Bar },

    data: () => ({
        topbarData: {
            revenue: 0,
            total_transactions: 0,
            profit_and_loss: 0,
        },

        chartData: {
            labels: [],
            datasets: [{
                backgroundColor: "#5f4342",
                data: [],
            }],
        },

        chartOptions: {
            responsive: true,
        },

        reportTypes: [
            "Harian",
            "Bulanan",
            "Tahunan"
        ],

        reportType: "Bulanan",
    }),

    methods: {
        async getTopBarData() {
            const reportType = this.reportType.toLowerCase()
            const { data } = await this.axios().get(`/api/dashboard/topbar?report_type=${reportType}`)
            this.topbarData = data.data
        },

        async getChartData() {
            const reportType = this.reportType.toLowerCase()
            const { data } = await this.axios().get(`/api/dashboard/chart?report_type=${reportType}`)

            const chartData = {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: "#5f4342",
                }],
            }

            Object.keys(data.data).forEach(title => {
                chartData.labels.push(title)
                chartData.datasets[0].data.push(data.data[title])
            })

            this.chartData = chartData
        },

    },

    watch: {
        reportType() {
            this.getChartData()
            this.getTopBarData()
        },
    },

    computed: {
        titleReportType() {
            switch (this.reportType) {
                case "Harian":
                    return "Hari"

                case "Tahunan":
                    return "Tahun"

                default:
                    return "Bulan"
            }
        },
    },

    created() {
        this.getChartData()
        this.getTopBarData()
    },
}
</script>