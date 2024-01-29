<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" sm="6">
                <div class="text-overline">Dari Tanggal</div>
                <input class="w-100 bg-white px-5 py-3 rounded elevation-3"
                       v-model="startDate"
                       type="date" />
            </v-col>

            <v-col cols="12" sm="5">
                <div class="text-overline">Sampai Tanggal</div>
                <input class="w-100 bg-white px-5 py-3 rounded elevation-3"
                       v-model="endDate"
                       type="date" />
            </v-col>

            <v-col class="d-flex justify-end align-end"
                   cols="12"
                   sm="1">
                <v-btn color="blue-darken-4"
                       icon="mdi-magnify"
                       @click="getReport" />
            </v-col>
        </v-row>

        <v-row>
            <v-col>
                <v-data-table-virtual class="elevation-3 rounded"
                                      :headers="headers"
                                      :items="items">

                    <template #item.numbering="{ index }">
                        {{ index + 1 }}
                    </template>

                    <template #item.actions="{ item }">

                        <v-btn v-if="readAbility"
                               @click="openReadPage(item)"
                               color="yellow-darken-4"
                               variant="tonal"
                               icon="mdi-eye"
                               class="mx-1"
                               size="small" />

                        <v-btn v-if="editAbility"
                               @click="openReadPage(item)"
                               color="blue-darken-4"
                               variant="tonal"
                               icon="mdi-pencil"
                               class="mx-1"
                               size="small" />

                    </template>
                </v-data-table-virtual>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mixin } from "../helper"

export default {
    name: "Report",
    mixins: [mixin],

    props: {
        modelName: String,
        readAbility: Boolean,
        editAbility: Boolean,
    },

    data: () => ({
        startDate: "",
        endDate: "",
        items: [],
    }),

    computed: {
        headers() {
            const headers = [
                { title: 'No.', key: 'numbering', align: 'center', sortable: false },
                { title: 'Daftar Barang', key: 'barang', sortable: false },
                { title: 'Total Jumlah', key: `total_${this.getModelName()}`, align: 'end' },
                { title: 'Total Harga', key: `total_harga_${this.getModelName()}`, align: 'end' },
                { title: 'Tanggal', key: `tanggal_${this.getModelName()}`, align: 'center', sortable: false },
            ]

            if (this.readAbility || this.editAbility) {
                headers.push({ title: '', key: 'actions', align: 'center', sortable: false })
            }

            if (this.getModelName() == 'jual') {
                headers.splice(1, 0,
                    { title: 'Kasir', key: 'kasir' },
                )
            }

            if (this.getModelName() == 'pembelian') {
                headers.splice(1, 0,
                    { title: 'Supplier', key: 'supplier' },
                )
            }

            return headers
        }
    },

    methods: {
        getModelName(fullForm = false) {
            const modelName = this.modelName.toLowerCase()
            if (!fullForm && modelName == 'penjualan') return 'jual'

            return modelName ?? ''
        },

        async getReport() {
            const params = {}

            if (this.startDate && this.endDate) {
                params.startDate = this.startDate
                params.endDate = this.endDate
            }

            try {
                const { data } = await this.axios().get(`/api/${this.getModelName(true)}`, { params })

                this.items = data.data.map((item, index) => {
                    if (item.supplier) item.supplier = item.supplier.nama_supplier ?? ""
                    if (item.user) item.kasir = item.user.name ?? ""

                    const listBarang = item.barang ?? []
                    item.barang = [...new Set(listBarang.map(barang => barang.nama_barang).filter(namaBarang => namaBarang))].join(', ')

                    item[`total_${this.getModelName()}`] = this.unitFormat(item[`total_${this.getModelName()}`])
                    item[`total_harga_${this.getModelName()}`] = this.currencyFormat(item[`total_harga_${this.getModelName()}`])

                    return item
                })

            } catch (error) {
                alert(error)
            }
        },

        openReadPage(item) {
            const modelName = this.getModelName(true)
            const propertyNameID = `id_${modelName}`

            const routes = [
                modelName,
                modelName === "persediaan" ? "laporan" : "nota",
                item[propertyNameID],
            ]

            location.href = `/${routes.join("/")}`
        },

    },

    created() {
        this.getReport()
    }
}
</script>
