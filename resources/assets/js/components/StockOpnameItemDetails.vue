<template>
    <v-container v-if="!isPrintPage"
                 fluid>
        <v-row>
            <v-col>
                <v-data-table-virtual class="elevation-3 rounded-lg pr-4"
                                      :headers="headers"
                                      :items="listBarang">
                    <template #item.numbering="{ index }">
                        {{ index + 1 }}
                    </template>

                    <template #item.harga="{ item }">
                        {{ currencyFormat(item?.pivot?.harga) }}
                    </template>

                    <template #item.jumlah_nyata="{ item }">
                        {{ unitFormat(item?.pivot?.jumlah_nyata, item?.ukuran) }}
                    </template>

                    <template #item.jumlah_tercatat="{ item }">
                        {{ unitFormat(item?.pivot?.jumlah_tercatat, item?.ukuran) }}
                    </template>

                    <template #item.subtotal="{ item }">
                        {{ countSubtotal(item) }}
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
                        <v-col cols="6"
                               sm="2"
                               class="d-flex">
                            <div
                                 class="d-flex align-self-center text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                Total Nilai Barang Nyata:
                            </div>
                        </v-col>

                        <v-col>
                            <div class="d-flex align-self-center text-h4 font-weight-regular text-medium-emphasis">
                                {{ grandTotal }}
                            </div>
                        </v-col>
                    </v-row>

                    <v-divider class="border-opacity-50"
                               thickness="2" />

                    <v-row>
                        <v-col cols="6"
                               sm="2"
                               class="d-flex">
                            <div
                                 class="d-flex align-self-center text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                Jumlah Total Nyata:
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

            <v-col v-if="modelName.toLowerCase() == 'penjualan'"
                   cols="12"
                   sm="4">
                <v-sheet class="pa-5 elevation-3"
                         rounded="lg">

                    <v-row>
                        <v-col class="d-flex justify-center pb-0"
                               cols="12">
                            <div class="text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                Kasir:
                            </div>
                        </v-col>

                        <v-col class="d-flex justify-center pt-0"
                               cols="12">
                            <div class="text-h4 font-weight-regular text-medium-emphasis">
                                {{ kasir }}
                            </div>
                        </v-col>
                    </v-row>

                </v-sheet>
            </v-col>

            <v-col v-if="modelName.toLowerCase() == 'pembelian'"
                   cols="12"
                   sm="4">
                <v-sheet class="pa-5 elevation-3"
                         rounded="lg">

                    <v-row>
                        <v-col class="d-flex justify-center pb-0"
                               cols="12">
                            <div class="text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                Supplier:
                            </div>
                        </v-col>

                        <v-col class="d-flex justify-center pt-0"
                               cols="12">
                            <div class="text-h4 font-weight-regular text-medium-emphasis">
                                {{ supplier }}
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

            <v-container class="pt-12">
                <v-row>
                    <v-col>
                        <v-data-table-virtual class="elevation-3 rounded-lg pr-4"
                                              :headers="headers"
                                              :items="listBarang">
                            <template #item.numbering="{ index }">
                                {{ index + 1 }}
                            </template>

                            <template #item.harga="{ item }">
                                {{ currencyFormat(item?.pivot?.harga) }}
                            </template>

                            <template #item.jumlah_nyata="{ item }">
                                {{ unitFormat(item?.pivot?.jumlah_nyata, item?.ukuran) }}
                            </template>

                            <template #item.jumlah_tercatat="{ item }">
                                {{ unitFormat(item?.pivot?.jumlah_tercatat, item?.ukuran) }}
                            </template>

                            <template #item.subtotal="{ item }">
                                {{ countSubtotal(item) }}
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
                                <v-col cols="6"
                                       sm="2"
                                       class="d-flex">
                                    <div
                                         class="d-flex align-self-center text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                        <span v-if="modelName.toLowerCase() == 'persediaan'">
                                            Nilai Total Barang:
                                        </span>

                                        <span v-else>Grand Total:</span>
                                    </div>
                                </v-col>

                                <v-col>
                                    <div class="d-flex align-self-center text-h4 font-weight-regular text-medium-emphasis">
                                        {{ grandTotal }}
                                    </div>
                                </v-col>
                            </v-row>

                            <v-divider class="border-opacity-50"
                                       thickness="2" />

                            <v-row>
                                <v-col cols="6"
                                       sm="2"
                                       class="d-flex">
                                    <div
                                         class="d-flex align-self-center text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                        Jumlah Total Barang:
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

                    <v-col v-if="modelName.toLowerCase() == 'penjualan'"
                           cols="12"
                           sm="4">
                        <v-sheet class="pa-5 elevation-3"
                                 rounded="lg">

                            <v-row>
                                <v-col class="d-flex justify-center pb-0"
                                       cols="12">
                                    <div class="text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                        Kasir:
                                    </div>
                                </v-col>

                                <v-col class="d-flex justify-center pt-0"
                                       cols="12">
                                    <div class="text-h4 font-weight-regular text-medium-emphasis">
                                        {{ kasir }}
                                    </div>
                                </v-col>
                            </v-row>

                        </v-sheet>
                    </v-col>

                    <v-col v-if="modelName.toLowerCase() == 'pembelian'"
                           cols="12"
                           sm="4">
                        <v-sheet class="pa-5 elevation-3"
                                 rounded="lg">

                            <v-row>
                                <v-col class="d-flex justify-center pb-0"
                                       cols="12">
                                    <div class="text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                        Supplier:
                                    </div>
                                </v-col>

                                <v-col class="d-flex justify-center pt-0"
                                       cols="12">
                                    <div class="text-h4 font-weight-regular text-medium-emphasis">
                                        {{ supplier }}
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
import { mixin } from "../helper"

export default {
    name: "ItemDetails",
    mixins: [mixin],

    props: {
        modelName: String,
    },

    data: () => ({
        kasir: "",
        supplier: "",
        listBarang: [],
        isPrintPage: false,
    }),

    computed: {
        headers() {
            const headers = [
                { title: 'No.', key: 'numbering', align: 'center', sortable: false },
                { title: 'Nama Barang', key: 'nama_barang' },
                { title: 'Kategori', key: 'kategori.nama_kategori' },
                { title: 'Harga (unit)', key: 'harga', align: 'end' },
                { title: 'Jumlah Tercatat', key: 'jumlah_tercatat', align: 'end' },
                { title: 'Jumlah Nyata', key: 'jumlah_nyata', align: 'end' },
                { title: 'Subtotal Nyata', key: 'subtotal', align: 'end' },
                { title: 'Alasan', key: 'alasan', align: 'end' },
            ]

            return headers
        },

        grandTotal() {
            let grandTotal = 0

            this.listBarang.forEach(barang => {
                const subtotal = (Number(barang?.pivot?.harga) * Number(barang?.pivot?.jumlah_nyata)) ?? 0
                grandTotal += subtotal
            })

            return this.currencyFormat(grandTotal)
        },

        quantityTotal() {
            let quantityTotal = 0
            this.listBarang.forEach(barang => quantityTotal += Number(barang?.pivot?.jumlah_nyata) ?? 0)

            return this.unitFormat(quantityTotal)
        },

    },

    methods: {

        async getItemDetails() {
            const pathname = new URL(location).pathname.split('/')
            const id = pathname[pathname.length - 1]

            const { data } = await this.axios().get(`/api/${this.modelName.toLowerCase()}/${id}`)

            this.listBarang = data.data?.barang ?? []
            this.supplier = data.data?.supplier?.nama_supplier ?? ""
            this.kasir = data.data?.user?.name ?? ""
        },

        countSubtotal(item) {
            return this.currencyFormat((Number(item?.pivot?.harga) * Number(item?.pivot?.jumlah_nyata)) ?? 0)
        },

        initPage() {
            const url = new URL(location)
            this.isPrintPage = url.searchParams.get("print")

            this.getItemDetails().then(() => {
                setTimeout(() => {
                    if (this.isPrintPage) print()
                }, 100)
            })
        },

    },

    created() {
        this.initPage()
    }
}
</script>

<style lang="scss" scoped>
.read-only :deep(input):hover {
    cursor: not-allowed !important;
}
</style>