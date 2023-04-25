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
                        <div class="text-h4 text-right">Rp. 575.000</div>
                    </template>
                </v-card>
            </v-col>

            <v-col>
                <v-card title="Jumlah Transaksi">
                    <template #text>
                        <div class="text-h4 text-right">12</div>
                    </template>
                </v-card>
            </v-col>

            <v-col>
                <v-card title="Laba Rugi">
                    <template #text>
                        <div class="text-h4 text-right">Rp. 55.000</div>
                    </template>
                </v-card>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <div class="mt-8 text-h6 text-grey-darken-3 d-flex">
                    <i class="voyager-bar-chart d-flex align-center mr-2" />
                    <span>Grafik Transaksi</span>
                </div>
            </v-col>

            <v-col cols="12">
                <bar :data="chartData"
                     :title="TEst"
                     :options="chartOptions" />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { Bar } from "vue-chartjs";
import { Chart as ChartJS, Tooltip, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Tooltip, BarElement, CategoryScale, LinearScale)

export default {
    name: "Dashboard",
    components: { Bar },
    data: () => ({
        chartData: {
            labels: ['January', 'February', 'March'],
            datasets: [{ data: [40, 20, 12] }]
        },
        chartOptions: {
            responsive: true,
        }
    }),
}
</script>