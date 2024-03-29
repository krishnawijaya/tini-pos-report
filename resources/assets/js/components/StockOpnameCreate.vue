<template>
    <v-container fluid>
        <v-row class="mb-4">
            <v-col cols="12">
                <v-autocomplete :items="listBarangAvailable"
                                @update:modelValue="onSelectedBarang"
                                @click:clear="emptySelectedBarang"
                                :model-value="selectedBarangOnSelector"
                                item-title="nama_barang"
                                label="Barang"
                                variant="solo"
                                return-object
                                hide-details
                                clearable>

                    <template #selection="{ item }">
                        {{ item.raw.nama_barang }} ({{ item.raw.ukuran }})

                        <span v-if="modelName.toLowerCase() != 'pembelian'">
                            &nbsp;-&nbsp;{{ currencyFormat(item.raw.harga) }}
                        </span>
                    </template>

                    <!-- <template #item="{ item }">
                        {{ item.raw.nama_barang }} ({{ item.raw.ukuran }})
                    </template> -->
                </v-autocomplete>
            </v-col>

            <v-col sm="2" cols="12">
                <v-text-field v-model="selectedBarang.jumlah"
                              label="Jumlah Nyata"
                              variant="solo"
                              hide-details />

            </v-col>

            <v-col sm="2" cols="12">
                <v-text-field :model-value="unitFormat(selectedBarang.stok, selectedBarang.ukuran)"
                              class="cursor-not-allowed"
                              label="Jumlah Tercatat"
                              variant="solo"
                              focused="true"
                              hide-details
                              readOnly />

            </v-col>

            <v-col cols="9" sm="3">
                <v-text-field :model-value="countSelectedBarangSubtotal"
                              class="cursor-not-allowed"
                              label="Subtotal Nilai Barang"
                              variant="solo"
                              hide-details
                              readOnly />
            </v-col>

            <v-col sm="4" cols="12">
                <v-text-field v-model="selectedBarang.alasan"
                              @keyup.enter="addBarang"
                              label="Alasan"
                              variant="solo"
                              hide-details />
            </v-col>

            <v-col class="d-flex justify-end" cols="3" sm="1">
                <v-btn @click="addBarang"
                       color="blue-darken-4"
                       icon="mdi-plus" />
            </v-col>
        </v-row>

        <v-row>
            <v-col>
                <v-data-table-virtual class="elevation-3 rounded-lg"
                                      :headers="headers"
                                      :items="listBarangInCart">
                    <template #item.numbering="{ index }">
                        {{ index + 1 }}
                    </template>

                    <template #item.harga="{ item }">
                        {{ currencyFormat(item.harga) }}
                    </template>

                    <template #item.jumlah_tercatat="{ item }">
                        {{ unitFormat(item.stok, item.ukuran) }}
                    </template>

                    <template #item.jumlah_nyata="{ item }">
                        {{ unitFormat(item.jumlah, item.ukuran) }}
                    </template>

                    <template #item.subtotal="{ item }">
                        {{ countSubtotal(item) }}
                    </template>

                    <template #item.action="{ item }">
                        <v-btn @click="removeBarangFromCart(item)"
                               icon="mdi-delete-empty"
                               color="red-darken-4"
                               variant="tonal"
                               size="small" />
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

            <v-col cols="12"
                   sm="4">
                <v-row class="ma-0 h-100">
                    <v-col cols="12"
                           class="d-flex align-end">
                        <v-btn prepend-icon="mdi-content-save"
                               @click="saveData"
                               class="w-100"
                               color="green">
                            Buat
                        </v-btn>
                    </v-col>

                    <v-col cols="12"
                           class="d-flex align-start">
                        <v-btn prepend-icon="mdi-cancel"
                               color="grey-darken-2"
                               @click="backToBrowsePage"
                               class="w-100">
                            Batal
                        </v-btn>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mixin } from "../helper"

export default {
    name: "Create",
    mixins: [mixin],

    props: {
        roleName: String,
        modelName: String,
    },

    data: () => ({
        selectedBarangOnSelector: undefined,
        selectedSupplier: undefined,
        listSupplierAvailable: [],
        listBarangAvailable: [],
        listBarangInCart: [],
        purchasePrice: "",

        selectedBarang: {
            uid: "",
            stok: 0,
            harga: 0,
            jumlah: "",
            alasan: "",
        },

        headers: [
            { title: 'No.', key: 'numbering', align: 'center', sortable: false },
            { title: 'Nama Barang', key: 'nama_barang' },
            { title: 'Kategori', key: 'kategori.nama_kategori' },
            { title: 'Harga (unit)', key: 'harga', align: 'end' },
            { title: 'Jumlah Tercatat', key: 'jumlah_tercatat', align: 'end' },
            { title: 'Jumlah Nyata', key: 'jumlah_nyata', align: 'end' },
            { title: 'Subtotal Nyata', key: 'subtotal', align: 'end' },
            { title: 'Alasan', key: 'alasan', align: 'end' },
            { title: '', key: 'action', align: 'center', sortable: false },
        ],
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
            const harga = this.modelName.toLowerCase() == 'pembelian' ? this.purchasePrice : this.selectedBarang.harga

            return this.currencyFormat((Number(harga) * Number(this.selectedBarang.jumlah)) ?? 0)
        },

    },

    methods: {

        async getListBarangAvailable() {
            const { data } = await this.axios().get('/api/barang')
            this.listBarangAvailable = data.data.map(barang => {
                barang.uid = Date.now() + (Math.random() + 1).toString(36).substring(7)
                return barang
            })
        },

        async getlistSupplierAvailable() {
            const { data } = await this.axios().get('/api/supplier')
            this.listSupplierAvailable = data.data
        },

        onSelectedBarang(barang) {
            if (!barang) return
            barang.jumlah = ""
            barang.alasan = ""

            this.selectedBarang = barang
            this.selectedBarangOnSelector = barang
        },

        addBarang() {
            if (!this.selectedBarang.uid ||
                !this.selectedBarang.jumlah) {
                return
            }

            const barang = this.deepCopy(this.selectedBarang)
            this.listBarangInCart.push(barang)
            this.emptySelectedBarang()
        },

        removeBarangFromCart({ uid, jumlah }) {
            const index = this.listBarangInCart.findIndex(item => item.uid == uid)
            if (index == -1) return

            this.listBarangInCart.splice(index, 1)
        },

        emptySelectedBarang() {
            this.purchasePrice = ""

            this.selectedBarangOnSelector = undefined
            this.selectedBarang = {
                uid: "",
                stok: 0,
                harga: 0,
                jumlah: "",
                alasan: "",
            }
        },

        countSubtotal(item) {
            return this.currencyFormat((Number(item.harga) * Number(item.jumlah)) ?? 0)
        },

        async saveData() {
            const payload = {
                listBarang: this.listBarangInCart,
                supplier: this.selectedSupplier,
            }

            try {
                const { data } = await this.axios().post(`/api/${this.modelName.toLowerCase()}`, payload)

                if (this.modelName.toLowerCase() == "penjualan" && this.roleName == "kasir") {
                    const idPenjualan = data?.data?.id_penjualan
                    open(`/penjualan/nota/${idPenjualan}?print=true`, '_blank')

                    location.reload()
                } else {
                    this.backToBrowsePage()
                }

            } catch (error) {
                location.reload()
            }
        },

        backToBrowsePage() {
            const url = new URL(location)
            location.href = `/${url.pathname.split('/').find(path => path)}`
        },

        initPage() {
            this.getListBarangAvailable()
            this.getlistSupplierAvailable()
        },

    },

    created() {
        this.initPage()
    }
}
</script>

<style lang="scss" scoped>
.cursor-not-allowed :deep(input):hover {
    cursor: not-allowed !important;
}
</style>