<template>
    <v-container fluid>
        <mmu></mmu>
        <v-row>
            <v-col cols="12"
                   sm="4">
                <v-autocomplete :items="listBarangAvailable"
                                @update:modelValue="onSelectedBarang"
                                @click:clear="emptySelectedBarang"
                                :model-value="selectedBarangOnSelector"
                                item-title="nama_barang"
                                label="Barang"
                                variant="solo"
                                returnObject
                                hide-details
                                clearable>
                    <template #selection="{ item }">
                        {{ item.value.nama_barang }} - {{ item.value.harga }}
                    </template>
                </v-autocomplete>
            </v-col>

            <v-col cols="12"
                   sm="4">
                <v-text-field v-model="selectedBarang.jumlah"
                              @keyup.enter="addBarang"
                              variant="solo"
                              label="Jumlah"
                              hide-details />

            </v-col>

            <v-col cols="9"
                   sm="3">
                <v-text-field :model-value="countSelectedBarangSubtotal"
                              class="subtotal-barang"
                              label="Subtotal Harga"
                              variant="solo"
                              hide-details
                              readOnly />
            </v-col>

            <v-col class="d-flex justify-end"
                   cols="3"
                   sm="1">
                <v-btn @click="addBarang"
                       color="blue-darken-4"
                       icon="mdi-plus" />
            </v-col>
        </v-row>

        <v-row class="px-3 pt-12">
            <v-data-table-virtual class="elevation-1 rounded-lg"
                                  :headers="headers"
                                  :items="listBarangInCart">
                <template #item.numbering="{ index }">
                    {{ index + 1 }}
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
        </v-row>

        <v-row class="pt-4">
            <v-col cols="12"
                   sm="8">
                <v-sheet elevation="3"
                         class="pa-5"
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
import Helper from "../helper";

export default {
    name: "Create",
    data: () => ({
        headers: [
            { title: 'No.', key: 'numbering', align: 'center', sortable: false },
            { title: 'Barang', key: 'nama_barang', align: 'center', sortable: false },
            { title: 'Harga (unit)', key: 'harga', align: 'center', sortable: false },
            { title: 'Jumlah', key: 'jumlah', align: 'center', sortable: false },
            { title: 'Subtotal', key: 'subtotal', align: 'center', sortable: false },
            { title: '', key: 'action', align: 'center', sortable: false },
        ],

        selectedBarangOnSelector: undefined,
        listBarangAvailable: [],
        listBarangInCart: [],
        selectedBarang: {
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

        unitFormat(value) {
            return Helper.unitFormat(value)
        },

        currencyFormat(value) {
            return Helper.currencyFormat(value)
        },

        async getListBarangAvailable() {
            const { data } = await Helper.axios().get('/api/barang')
            this.listBarangAvailable = data.data
        },

        onSelectedBarang(barang) {
            if (!barang) return
            barang.jumlah = ""

            this.selectedBarang = barang
            this.selectedBarangOnSelector = barang
        },

        addBarang() {
            if (!this.selectedBarang.id_barang ||
                !this.selectedBarang.jumlah ||
                this.selectedBarang.jumlah < 1) return

            const barang = this.selectedBarang
            this.listBarangInCart.push(Helper.deepCopy(barang))

            this.emptySelectedBarang()
        },

        removeBarangFromCart(barang) {
            const index = this.listBarangInCart.findIndex(item => item.id_barang == barang.value.id_barang)
            if (index == -1) return

            this.listBarangInCart.splice(index, 1)
        },

        emptySelectedBarang() {
            this.selectedBarangOnSelector = undefined
            this.selectedBarang = {
                harga: 0,
                jumlah: "",
            }
        },

        countSubtotal({ value }) {
            return (Number(value.harga) * Number(value.jumlah)) ?? 0
        },

        saveData() {
            const data = {}
            Helper.axios().post('/api/pembelian/create', data)
        },

        backToBrowsePage() {
            const url = new URL(location)
            location.href = `/${url.pathname.split('/').find(path => path)}`
        }

    },

    created() {
        this.getListBarangAvailable()
    }
}
</script>

<style lang="scss" scoped>
.subtotal-barang :deep(input):hover {
    cursor: not-allowed !important;
}
</style>