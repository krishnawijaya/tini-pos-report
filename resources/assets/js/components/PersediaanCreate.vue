<template>
    <v-container fluid>

        <v-row class="mb-4">
            <v-col cols="12"
                   sm="5">

                <v-autocomplete :model-value="selectedRawMaterialOnSelector"
                                @update:modelValue="(item) => onSelectedAction(item, 'RawMaterial')"
                                @click:clear="emptySelectedAction('RawMaterial')"
                                :items="listBarangAvailable"
                                item-title="nama_barang"
                                label="Bahan Baku"
                                variant="solo"
                                class="mb-4"
                                return-object
                                hide-details
                                clearable>
                    <template #selection="{ item }">
                        {{ item.value.nama_barang }} ({{ item.value?.kategori?.nama_kategori }})
                    </template>
                </v-autocomplete>

                <v-text-field v-model="selectedRawMaterial.jumlah"
                              :hint="`Stok saat ini: ${unitFormat(selectedRawMaterial.stok, selectedRawMaterial.ukuran)}`"
                              label="Jumlah yang dibutuhkan"
                              @keyup.enter="addAction('RawMaterial')"
                              variant="solo">

                    <template class="pa-0"
                              #append>
                        <v-btn color="blue-darken-4"
                               @click="addAction('RawMaterial')"
                               icon="mdi-plus"
                               size="x-small" />
                    </template>
                </v-text-field>
            </v-col>

            <v-col cols="12"
                   sm="2">
                <div class="d-flex justify-center align-center h-75">
                    <v-divider class="border-opacity-50"
                               thickness="1"
                               vertical />
                </div>
            </v-col>

            <v-col cols="12"
                   sm="5">

                <v-autocomplete :model-value="selectedFinishedGoodsOnSelector"
                                @update:modelValue="(item) => onSelectedAction(item, 'FinishedGoods')"
                                @click:clear="emptySelectedAction('FinishedGoods')"
                                :items="listBarangAvailable"
                                item-title="nama_barang"
                                label="Barang Jadi"
                                variant="solo"
                                class="mb-4"
                                return-object
                                hide-details
                                clearable>
                    <template #selection="{ item }">
                        {{ item.value.nama_barang }} ({{ item.value?.kategori?.nama_kategori }})
                    </template>
                </v-autocomplete>

                <v-text-field v-model="selectedFinishedGoods.jumlah"
                              :hint="`Stok saat ini: ${unitFormat(selectedFinishedGoods.stok, selectedFinishedGoods.ukuran)}`"
                              label="Jumlah yang dibutuhkan"
                              @keyup.enter="addAction('FinishedGoods')"
                              variant="solo">

                    <template class="pa-0"
                              #append>
                        <v-btn color="blue-darken-4"
                               @click="addAction('FinishedGoods')"
                               icon="mdi-plus"
                               size="x-small" />
                    </template>
                </v-text-field>
            </v-col>
        </v-row>

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
                        {{ item.value.jumlah }} {{ item.value.ukuran }}
                    </template>

                    <template #item.harga="{ item }">
                        {{ currencyFormat(item.value.harga) }} ({{ countSubtotal(item) }})
                    </template>

                    <template #item.action="{ item }">
                        <v-btn @click="removeAction(item, 'RawMaterial')"
                               icon="mdi-delete-empty"
                               color="red-darken-4"
                               variant="tonal"
                               size="small" />
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
                        {{ item.value.jumlah }} {{ item.value.ukuran }}
                    </template>

                    <template #item.harga="{ item }">
                        {{ currencyFormat(item.value.harga) }} ({{ countSubtotal(item) }})
                    </template>

                    <template #item.action="{ item }">
                        <v-btn @click="removeAction(item, 'FinishedGoods')"
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
import { mixin } from "../helper";

export default {
    name: "PersediaanCreate",
    mixins: [mixin],

    props: {
        modelName: String,
    },

    data: () => ({
        listBarangAvailable: [],
        selectedListRawMaterial: [],
        selectedListFinishedGoods: [],

        selectedRawMaterialOnSelector: undefined,
        selectedRawMaterial: {
            uid: "",
            stok: 0,
            harga: 0,
            jumlah: "",
        },

        selectedFinishedGoodsOnSelector: undefined,
        selectedFinishedGoods: {
            uid: "",
            stok: 0,
            harga: 0,
            jumlah: "",
        },

        headers: [
            { title: 'Barang (Kategori)', key: 'nama', align: 'center', sortable: false },
            { title: 'Jumlah', key: 'jumlah', align: 'center', sortable: false },
            { title: 'Harga (Subtotal)', key: 'harga', align: 'center', sortable: false },
            { title: '', key: 'action', align: 'center', sortable: false },
        ],
    }),

    computed: {

        rawMaterialTotalValue() {
            let totalValue = 0

            this.selectedListRawMaterial.forEach(barang => {
                const subtotal = (Number(barang.harga) * Number(barang.jumlah)) ?? 0
                totalValue += subtotal
            })

            return this.currencyFormat(totalValue)
        },

        finishedGoodsTotalValue() {
            let totalValue = 0

            this.selectedListFinishedGoods.forEach(barang => {
                const subtotal = (Number(barang.harga) * Number(barang.jumlah)) ?? 0
                totalValue += subtotal
            })

            return this.currencyFormat(totalValue)
        },

    },

    methods: {

        async getListBarangAvailable() {
            const { data } = await this.axios().get('/api/barang')
            this.listBarangAvailable = data.data
        },

        onSelectedAction(barang, type) {
            if (!barang) return
            barang.jumlah = ""
            barang.uid = Date.now() + (Math.random() + 1).toString(36).substring(7)

            this[`selected${type}`] = barang
            this[`selected${type}OnSelector`] = barang
        },

        addAction(type) {
            if (!this[`selected${type}`].uid ||
                !this[`selected${type}`].jumlah ||
                this[`selected${type}`].jumlah < 1) return

            const barang = this[`selected${type}`]
            this[`selectedList${type}`].push(this.deepCopy(barang))

            this.emptySelectedAction(type)
        },

        removeAction({ value }, type) {
            const index = this[`selectedList${type}`].findIndex(item => item.uid == value.uid)
            if (index == -1) return

            this[`selectedList${type}`].splice(index, 1)
        },

        emptySelectedAction(type) {
            this[`selected${type}OnSelector`] = undefined
            this[`selected${type}`] = {
                uid: "",
                stok: 0,
                harga: 0,
                jumlah: "",
            }
        },

        countSubtotal({ value }) {
            return this.currencyFormat((Number(value.harga) * Number(value.jumlah)) ?? 0)
        },

        async saveData() {
            const payload = {
                listRawMaterial: this.selectedListRawMaterial,
                listFinishedGoods: this.selectedListFinishedGoods,
            }

            try {
                await this.axios().post("/api/persediaan", payload)
                this.backToBrowsePage()

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