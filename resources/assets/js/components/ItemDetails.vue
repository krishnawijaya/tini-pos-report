<template>
    <v-container v-if="!isPrintPage"
                 fluid>
        <v-row>
            <v-col>
                <v-data-table-virtual class="elevation-3 rounded-lg"
                                      :headers="headers"
                                      :items="listBarang">
                    <template #item.numbering="{ index }">
                        {{ index + 1 }}
                    </template>

                    <template #item.harga="{ item }">
                        {{ currencyFormat(item.value?.pivot?.harga) }}
                    </template>

                    <template #item.jumlah="{ item }">
                        {{ unitFormat(item.value?.pivot?.jumlah, item?.value?.ukuran) }}
                    </template>

                    <template #item.subtotal="{ item }">
                        {{ countSubtotal(item) }}
                    </template>
                </v-data-table-virtual>
            </v-col>
        </v-row>

        <v-row v-if="modelName.toLowerCase() != 'persediaan'"
               class="pt-4">
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

            <v-col v-if="modelName.toLowerCase() == 'penjualan'"
                   cols="12"
                   sm="4">
                <v-sheet class="pa-5 elevation-3"
                         rounded="lg">

                    <v-row>
                        <v-col class="d-flex justify-center pb-0"
                               cols="12">
                            <div class="text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                Pelanggan:
                            </div>
                        </v-col>

                        <v-col class="d-flex justify-center pt-0"
                               cols="12">
                            <div class="text-h4 font-weight-regular text-medium-emphasis">
                                {{ pelanggan }}
                            </div>
                        </v-col>
                    </v-row>

                    <v-divider class="border-opacity-50"
                               thickness="2" />

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
                        Dodi Ukir
                    </div>
                </v-toolbar-title>

                <v-spacer />
            </v-toolbar>

            <v-container class="pt-12">
                <v-row>
                    <v-col>
                        <v-data-table-virtual class="elevation-3 rounded-lg"
                                              :headers="headers"
                                              :items="listBarang">
                            <template #item.numbering="{ index }">
                                {{ index + 1 }}
                            </template>

                            <template #item.harga="{ item }">
                                {{ currencyFormat(item.value?.pivot?.harga) }}
                            </template>

                            <template #item.jumlah="{ item }">
                                {{ unitFormat(item.value?.pivot?.jumlah, item.value?.ukuran) }}
                            </template>

                            <template #item.subtotal="{ item }">
                                {{ countSubtotal(item) }}
                            </template>

                        </v-data-table-virtual>
                    </v-col>
                </v-row>

                <v-row v-if="modelName.toLowerCase() != 'persediaan'"
                       class="pt-4">
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

                    <v-col v-if="modelName.toLowerCase() == 'penjualan'"
                           cols="12"
                           sm="4">
                        <v-sheet class="pa-5 elevation-3"
                                 rounded="lg">

                            <v-row>
                                <v-col class="d-flex justify-center pb-0"
                                       cols="12">
                                    <div class="text-subtitle-2 text-uppercase font-weight-regular text-medium-emphasis">
                                        Pelanggan:
                                    </div>
                                </v-col>

                                <v-col class="d-flex justify-center pt-0"
                                       cols="12">
                                    <div class="text-h4 font-weight-regular text-medium-emphasis">
                                        {{ pelanggan }}
                                    </div>
                                </v-col>
                            </v-row>

                            <v-divider class="border-opacity-50"
                                       thickness="2" />

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
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
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
        kasir: "",
        pelanggan: "",
        listBarang: [],
        isPrintPage: false,
    }),

    computed: {
        headers() {
            const headers = [
                { title: 'No.', key: 'numbering', align: 'center', sortable: false },
                { title: 'Barang', key: 'nama_barang', align: 'center', sortable: false },
                { title: 'Harga (unit)', key: 'harga', align: 'center', sortable: false },
                { title: 'Jumlah', key: 'jumlah', align: 'center', sortable: false },
                { title: 'Subtotal', key: 'subtotal', align: 'center', sortable: false },
                { title: '', key: 'action', align: 'center', sortable: false },
            ]

            if (this.modelName.toLowerCase() == "persediaan") {
                headers.splice(1, 0,
                    { title: 'Jenis', key: 'pivot.jenis', align: 'center', sortable: false },
                )
            }

            return headers
        },

        grandTotal() {
            let grandTotal = 0

            this.listBarang.forEach(barang => {
                const subtotal = (Number(barang?.pivot?.harga) * Number(barang?.pivot?.jumlah)) ?? 0
                grandTotal += subtotal
            })

            return this.currencyFormat(grandTotal)
        },

        quantityTotal() {
            let quantityTotal = 0
            this.listBarang.forEach(barang => quantityTotal += Number(barang?.pivot?.jumlah) ?? 0)

            return this.unitFormat(quantityTotal)
        },

    },

    methods: {

        async getItemDetails() {
            const pathname = new URL(location).pathname.split('/')
            const id = pathname[pathname.length - 1]

            const { data } = await this.axios().get(`/api/${this.modelName.toLowerCase()}/${id}`)

            this.listBarang = data.data?.barang ?? []
            this.pelanggan = data.data?.pelanggan?.nama_pelanggan ?? ""
            this.kasir = data.data?.user?.name ?? ""
        },

        countSubtotal({ value }) {
            return this.currencyFormat((Number(value?.pivot?.harga) * Number(value?.pivot?.jumlah)) ?? 0)
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
.read-only :deep(input):hover {
    cursor: not-allowed !important;
}
</style>