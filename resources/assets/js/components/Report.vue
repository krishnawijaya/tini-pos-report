<template>
    <v-container fluid>
        <v-row>
            <v-col>
                <input class="w-100 bg-white px-5 py-3 rounded elevation-1"
                       v-model="startDate"
                       type="date" />
            </v-col>

            <v-col>
                <input class="w-100 bg-white px-5 py-3 rounded elevation-1"
                       v-model="endDate"
                       type="date" />
            </v-col>

            <v-col cols="1"
                   class="d-flex justify-end align-center">
                <v-btn color="blue-darken-4"
                       icon="mdi-magnify"
                       @click="getReport" />
            </v-col>
        </v-row>

        <v-row>
            <v-col>
                <v-data-table-virtual class="elevation-1 rounded"
                                      :headers="headers"
                                      :items="items">
                    <template #item.actions="{ item }">

                        <v-btn @click="openReadPage(item)"
                               color="yellow-darken-4"
                               variant="tonal"
                               icon="mdi-eye"
                               size="small" />

                    </template>
                </v-data-table-virtual>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from "axios";

export default {
    name: "Report",

    props: {
        modelName: String,
    },

    data: () => ({
        startDate: "",
        endDate: "",
        items: [],
    }),

    computed: {
        getModelName() {
            const modelName = this.modelName.toLowerCase()

            if (!modelName) return ''
            if (modelName == 'penjualan') return 'jual';

            return modelName
        },

        headers() {
            const header = [
                { title: 'No.', key: 'item_no', align: 'center', sortable: false },
                { title: 'Total Jumlah', key: `total_${this.getModelName}`, align: 'end' },
                { title: 'Total Harga', key: `total_harga_${this.getModelName}`, align: 'end' },
                { title: 'Tanggal', key: `tanggal_${this.getModelName}`, align: 'center', sortable: false },
                { title: '', key: 'actions', align: 'center', sortable: false },
            ]

            if (this.getModelName == 'jual') {
                header.splice(1, 0,
                    { title: 'Kasir', key: 'kasir' },
                    { title: 'Pelanggan', key: 'pelanggan' },
                )
            }

            return header
        }
    },

    methods: {
        unitFormat(value) {
            return value += value < 1 ? ' unit' : ' units';
        },

        currencyFormat(value) {
            return value.toLocaleString("id-ID", {
                style: "currency",
                currency: "IDR",
                maximumFractionDigits: 0,
            })
        },

        async getReport() {
            const params = {}

            if (this.startDate && this.endDate) {
                params.startDate = this.startDate
                params.endDate = this.endDate
            }

            try {
                const url = this.getModelName == 'jual' ? '/api/penjualan' : `/api/${this.getModelName}`
                const { data } = await axios.get(url, { params })

                this.items = data.data.map((item, index) => {
                    if (item['pelanggan']) item['pelanggan'] = item['pelanggan']['nama_pelanggan'] ?? ""
                    if (item['user']) item['kasir'] = item['user']['name'] ?? ""

                    item[`total_${this.getModelName}`] = this.unitFormat(item[`total_${this.getModelName}`])
                    item[`total_harga_${this.getModelName}`] = this.currencyFormat(item[`total_harga_${this.getModelName}`])

                    item.item_no = index + 1
                    return item
                })

            } catch (error) {
                alert(error)
            }
        },

        openReadPage(item) {
            const propertyNameID = `id_${this.getModelName}`
            location.href += `/nota/${item.value[propertyNameID]}`
        }
    },

    created() {
        this.getReport()
    }
}
</script>
