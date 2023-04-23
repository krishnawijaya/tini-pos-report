<template>
    <v-container>
        <v-row>
            <v-col>
                <v-card title="Pendapatan Hari Ini">
                    <template #text>
                        <div class="text-h6 text-right">Rp. 575.000</div>
                    </template>
                </v-card>
            </v-col>

            <v-col>
                <v-card title="Jumlah Transaksi">
                    <template #text>
                        <div class="text-h6 text-right">12</div>
                    </template>
                </v-card>
            </v-col>

            <v-col>
                <v-card title="Laba Rugi">
                    <template #text>
                        <div class="text-h6 text-right">Rp. 55.000</div>
                    </template>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "Report",
}
</script>