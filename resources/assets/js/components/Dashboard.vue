<template>
    <v-container>
        <v-row>
            <v-col class="text-center text-black">
                <div class="text-h4">Dodi Ukir</div>
                <div class="text-caption">
                    Sistem Informasi Penjualan Kesenian Patung Bali Berbasis Web
                </div>
            </v-col>
        </v-row>

        <v-row>
            <v-col>
                <v-card title="Pendapatan Hari Ini">
                    <template #text>
                        <div class="text-h4 text-right">
                            {{ currencyFormat(topbarData.revenue) }}
                        </div>
                    </template>
                </v-card>
            </v-col>

            <v-col>
                <v-card title="Jumlah Transaksi Hari Ini">
                    <template #text>
                        <div class="text-h4 text-right">
                            {{ topbarData.total_transactions }}
                            Transaksi
                        </div>
                    </template>
                </v-card>
            </v-col>

            <v-col>
                <v-card title="Laba Rugi Bulan Ini">
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

            <v-col v-if="chartData.labels.length"
                   cols="12">

                <v-sheet elevation="3"
                         class="pa-10"
                         rounded="lg">

                    <bar :data="chartData"
                         :options="chartOptions" />
                </v-sheet>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mixin } from "../helper";
import { Bar } from "vue-chartjs";
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
    }),

    methods: {

        async getTopBarData() {
            const { data } = await this.axios().get('/api/dashboard/topbar')
            this.topbarData = data.data
        },

        async getChartData() {
            const { data } = await this.axios().get('/api/dashboard/chart')
            const chartData = data.data

            for (const monthName in chartData) {
                this.chartData.labels.push(monthName)
                this.chartData.datasets[0].data.push(chartData[monthName])
            }
        },

    },

    created() {
        this.getChartData()
        this.getTopBarData()
    }
}
</script>