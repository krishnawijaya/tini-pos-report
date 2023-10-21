<template>
    <v-container v-if="!isPrintPage"
                 fluid>

        <v-row>
            <v-col cols="12"
                   sm="5">
                <v-data-table-virtual class="elevation-3 rounded-lg"
                                      :items="selectedListRawMaterial"
                                      :headers="headers">

                    <template #item.nama="{ item }">
                        {{ item.value.nama_barang }} ({{ item.value?.kategori?.nama_kategori }})
                    </template>

                    <template #item.jumlah="{ item }">
                        {{ item.value?.pivot?.jumlah }} {{ item.value.ukuran }}
                    </template>

                    <template #item.harga="{ item }">
                        {{ currencyFormat(item.value.harga) }} ({{ countSubtotal(item) }})
                    </template>
                </v-data-table-virtual>
            </v-col>

            <v-col cols="12"
                   sm="2">
                <div class="d-flex justify-center align-center h-75">
                    <v-icon size="x-large">mdi-equal</v-icon>
                </div>
            </v-col>

            <v-col cols="12"
                   sm="5">
                <v-data-table-virtual class="elevation-3 rounded-lg"
                                      :items="selectedListFinishedGoods"
                                      :headers="headers">

                    <template #item.nama="{ item }">
                        {{ item.value.nama_barang }} ({{ item.value?.kategori?.nama_kategori }})
                    </template>

                    <template #item.jumlah="{ item }">
                        {{ item.value?.pivot?.jumlah }} {{ item.value.ukuran }}
                    </template>

                    <template #item.harga="{ item }">
                        {{ currencyFormat(item.value.harga) }} ({{ countSubtotal(item) }})
                    </template>
                </v-data-table-virtual>
            </v-col>
        </v-row>

        <v-row class="pt-4">
            <v-col cols="12"
                   sm="8">
                <v-sheet class="pa-5 elevation-3"
                         rounded="lg">

                    <v-row>
                        <v-col class="d-flex">
                            <div
                                 class="d-flex align-self-center text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                Modal yang dibutuhkan :
                            </div>
                        </v-col>

                        <v-col>
                            <div class="d-flex align-self-center text-h4 font-weight-regular text-medium-emphasis">
                                {{ rawMaterialTotalValue }}
                            </div>
                        </v-col>
                    </v-row>

                    <v-divider class="border-opacity-50"
                               thickness="2" />

                    <v-row>
                        <v-col class="d-flex">
                            <div
                                 class="d-flex align-self-center text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                Nilai produk yang dihasilkan :
                            </div>
                        </v-col>

                        <v-col>
                            <div class="d-flex align-self-center text-h4 font-weight-regular text-medium-emphasis">
                                {{ finishedGoodsTotalValue }}
                            </div>
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-col>
        </v-row>
    </v-container>

    <v-dialog v-else
              transition="dialog-bottom-transition"
              v-model="isPrintPage"
              :z-index="9999"
              :scrim="false"
              persistent
              fullscreen>
        <v-card>
            <v-toolbar color="#5f4342">
                <v-spacer />

                <v-toolbar-title>
                    <div class="text-white text-uppercase text-center">
                        Tini POS
                    </div>
                </v-toolbar-title>

                <v-spacer />
            </v-toolbar>

            <v-container fluid>

                <v-row>
                    <v-col cols="12"
                           sm="5">
                        <v-data-table-virtual class="elevation-3 rounded-lg"
                                              :items="selectedListRawMaterial"
                                              :headers="headers">

                            <template #item.nama="{ item }">
                                {{ item.value.nama_barang }} ({{ item.value?.kategori?.nama_kategori }})
                            </template>

                            <template #item.jumlah="{ item }">
                                {{ item.value?.pivot?.jumlah }} {{ item.value.ukuran }}
                            </template>

                            <template #item.harga="{ item }">
                                {{ currencyFormat(item.value.harga) }} ({{ countSubtotal(item) }})
                            </template>
                        </v-data-table-virtual>
                    </v-col>

                    <v-col cols="12"
                           sm="2">
                        <div class="d-flex justify-center align-center h-75">
                            <v-icon size="x-large">mdi-equal</v-icon>
                        </div>
                    </v-col>

                    <v-col cols="12"
                           sm="5">
                        <v-data-table-virtual class="elevation-3 rounded-lg"
                                              :items="selectedListFinishedGoods"
                                              :headers="headers">

                            <template #item.nama="{ item }">
                                {{ item.value.nama_barang }} ({{ item.value?.kategori?.nama_kategori }})
                            </template>

                            <template #item.jumlah="{ item }">
                                {{ item.value?.pivot?.jumlah }} {{ item.value.ukuran }}
                            </template>

                            <template #item.harga="{ item }">
                                {{ currencyFormat(item.value.harga) }} ({{ countSubtotal(item) }})
                            </template>
                        </v-data-table-virtual>
                    </v-col>
                </v-row>

                <v-row class="pt-4">
                    <v-col cols="12"
                           sm="8">
                        <v-sheet class="pa-5 elevation-3"
                                 rounded="lg">

                            <v-row>
                                <v-col class="d-flex">
                                    <div
                                         class="d-flex align-self-center text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                        Modal yang dibutuhkan :
                                    </div>
                                </v-col>

                                <v-col>
                                    <div class="d-flex align-self-center text-h4 font-weight-regular text-medium-emphasis">
                                        {{ rawMaterialTotalValue }}
                                    </div>
                                </v-col>
                            </v-row>

                            <v-divider class="border-opacity-50"
                                       thickness="2" />

                            <v-row>
                                <v-col class="d-flex">
                                    <div
                                         class="d-flex align-self-center text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                        Nilai produk yang dihasilkan :
                                    </div>
                                </v-col>

                                <v-col>
                                    <div class="d-flex align-self-center text-h4 font-weight-regular text-medium-emphasis">
                                        {{ finishedGoodsTotalValue }}
                                    </div>
                                </v-col>
                            </v-row>
                        </v-sheet>
                    </v-col>
                </v-row>
            </v-container>

        </v-card>
    </v-dialog>
</template>

<script>
import { mixin } from "../helper";

export default {
    name: "PersediaanDetails",
    mixins: [mixin],

    props: {
        modelName: String,
    },

    data: () => ({
        isPrintPage: false,
        selectedListRawMaterial: [],
        selectedListFinishedGoods: [],

        headers: [
            { title: 'Barang (Kategori)', key: 'nama', align: 'center', sortable: false },
            { title: 'Jumlah', key: 'jumlah', align: 'center', sortable: false },
            { title: 'Harga (Subtotal)', key: 'harga', align: 'center', sortable: false },
        ],
    }),

    computed: {

        rawMaterialTotalValue() {
            let totalValue = 0

            this.selectedListRawMaterial.forEach(barang => {
                const subtotal = (Number(barang.harga) * Number(barang?.pivot?.jumlah)) ?? 0
                totalValue += subtotal
            })

            return this.currencyFormat(totalValue)
        },

        finishedGoodsTotalValue() {
            let totalValue = 0

            this.selectedListFinishedGoods.forEach(barang => {
                const subtotal = (Number(barang.harga) * Number(barang?.pivot?.jumlah)) ?? 0
                totalValue += subtotal
            })

            return this.currencyFormat(totalValue)
        },

    },

    methods: {

        async getItemDetails() {
            const pathname = new URL(location).pathname.split('/')
            const id = pathname[pathname.length - 1]

            const { data } = await this.axios().get(`/api/persediaan/${id}`)

            this.selectedListRawMaterial = data.data?.listRawMaterial ?? []
            this.selectedListFinishedGoods = data.data?.listFinishedGoods ?? []
        },

        countSubtotal({ value }) {
            return this.currencyFormat((Number(value.harga) * Number(value?.pivot?.jumlah)) ?? 0)
        },

        initPage() {
            const url = new URL(location)
            this.isPrintPage = url.searchParams.get("print")

            this.getItemDetails().then(() => {
                setTimeout(() => {
                    if (this.isPrintPage) print()
                }, 100);
            })
        },

    },

    created() {
        this.initPage()
    }
}
</script>

<style lang="scss" scoped>
.subtotal-barang :deep(input):hover {
    cursor: not-allowed !important;
}
</style>