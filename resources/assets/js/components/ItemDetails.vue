<template>
    <v-container fluid>
        <v-row class="px-3">
            <v-data-table-virtual class="elevation-1 rounded-lg"
                                  :headers="headers"
                                  :items="listBarangInCart">
                <template #item.numbering="{ index }">
                    {{ index + 1 }}
                </template>

                <template #item.subtotal="{ item }">
                    {{ countSubtotal(item) }}
                </template>
            </v-data-table-virtual>
        </v-row>

        <v-row class="pt-4">
            <v-col cols="12"
                   sm="8">
                <v-sheet elevation="3"
                         class="pa-5"
                         rounded="lg">

                    <v-row v-if="modelName.toLowerCase() == 'penjualan'">
                        <v-col cols="6"
                               sm="2"
                               class="d-flex">
                            <div
                                 class="d-flex align-self-center text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                Pelanggan :
                            </div>
                        </v-col>

                        <v-col>
                            <div class="d-flex align-self-center text-h4 font-weight-regular text-medium-emphasis">
                                Krishna
                            </div>
                        </v-col>
                    </v-row>

                    <v-divider v-if="modelName.toLowerCase() == 'penjualan'"
                               class="border-opacity-50"
                               color="warning"
                               thickness="2" />

                    <v-row>
                        <v-col cols="6"
                               sm="2"
                               class="d-flex">
                            <div
                                 class="d-flex align-self-center text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                Grand Total :
                            </div>
                        </v-col>

                        <v-col>
                            <div class="d-flex align-self-center text-h4 font-weight-regular text-medium-emphasis">
                                {{ grandTotal }}
                            </div>
                        </v-col>
                    </v-row>

                    <v-divider class="border-opacity-50"
                               color="warning"
                               thickness="2" />

                    <v-row>
                        <v-col cols="6"
                               sm="2"
                               class="d-flex">
                            <div
                                 class="d-flex align-self-center text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                Jumlah Total :
                            </div>
                        </v-col>

                        <v-col>
                            <div class="d-flex align-self-center text-h4 font-weight-regular text-medium-emphasis">
                                {{ quantityTotal }}
                            </div>
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mixin } from "../helper";

export default {
    name: "ItemDetails",
    mixins: [mixin],

    props: {
        modelName: String,
    },

    data: () => ({
        headers: [
            { title: 'No.', key: 'numbering', align: 'center', sortable: false },
            { title: 'Barang', key: 'nama_barang', align: 'center', sortable: false },
            { title: 'Harga (unit)', key: 'harga', align: 'center', sortable: false },
            { title: 'Jumlah', key: 'jumlah', align: 'center', sortable: false },
            { title: 'Subtotal', key: 'subtotal', align: 'center', sortable: false },
            { title: '', key: 'action', align: 'center', sortable: false },
        ],

        selectedPelanggan: undefined,
        selectedBarangOnSelector: undefined,
        listPelangganAvailable: [],
        listBarangAvailable: [],
        listBarangInCart: [],
        selectedBarang: {
            uid: "",
            harga: 0,
            jumlah: "",
        }
    }),

    computed: {

        grandTotal() {
            let grandTotal = 0

            this.listBarangInCart.forEach(barang => {
                const subtotal = (Number(barang.harga) * Number(barang.jumlah)) ?? 0
                grandTotal += subtotal
            })

            return this.currencyFormat(grandTotal)
        },

        quantityTotal() {
            let quantityTotal = 0
            this.listBarangInCart.forEach(barang => quantityTotal += Number(barang.jumlah) ?? 0)

            return this.unitFormat(quantityTotal)
        },

        countSelectedBarangSubtotal() {
            return (Number(this.selectedBarang.harga) * Number(this.selectedBarang.jumlah)) ?? 0
        },

    },

    methods: {

        async getItemDetails() {
            const { data } = await this.axios().get('/api/barang')
            this.listBarangAvailable = data.data
        },

        countSubtotal({ value }) {
            return (Number(value.harga) * Number(value.jumlah)) ?? 0
        },

        backToBrowsePage() {
            const url = new URL(location)
            location.href = `/${url.pathname.split('/').find(path => path)}`
        }

    },

    created() {
        this.getItemDetails()
    }
}
</script>

<style lang="scss" scoped>
.read-only :deep(input):hover {
    cursor: not-allowed !important;
}
</style>