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
import { mixin } from "../helper";

export default {
    name: "Report",
    mixins: [mixin],

    props: {
        modelName: String,
    },

    data: () => ({
        startDate: "",
        endDate: "",
        items: [],
    }),

    computed: {
        headers() {
            const header = [
                { title: 'No.', key: 'item_no', align: 'center', sortable: false },
                { title: 'Total Jumlah', key: `total_${this.getModelName()}`, align: 'end' },
                { title: 'Total Harga', key: `total_harga_${this.getModelName()}`, align: 'end' },
                { title: 'Tanggal', key: `tanggal_${this.getModelName()}`, align: 'center', sortable: false },
                { title: '', key: 'actions', align: 'center', sortable: false },
            ]

            if (this.getModelName() == 'jual') {
                header.splice(1, 0,
                    { title: 'Kasir', key: 'kasir' },
                    { title: 'Pelanggan', key: 'pelanggan' },
                )
            }

            return header
        }
    },

    methods: {
        getModelName(fullForm = false) {
            const modelName = this.modelName.toLowerCase()
            if (!fullForm && modelName == 'penjualan') return 'jual';

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
                    if (item.pelanggan) item.pelanggan = item.pelanggan.nama_pelanggan ?? ""
                    if (item.user) item.kasir = item.user.name ?? ""

                    item[`total_${this.getModelName()}`] = this.unitFormat(item[`total_${this.getModelName()}`])
                    item[`total_harga_${this.getModelName()}`] = this.currencyFormat(item[`total_harga_${this.getModelName()}`])

                    item.item_no = index + 1
                    return item
                })

            } catch (error) {
                alert(error)
            }
        },

        openReadPage({ value }) {
            const propertyNameID = `id_${this.getModelName(true)}`
            location.href += `/nota/${value[propertyNameID]}`
        }
    },

    created() {
        this.getReport()
    }
}
</script>
