<template>
    <v-container>
        <v-row>
            <v-col>
                <v-autocomplete label="Barang"
                                item-text="nama_barang"
                                :items="[]"
                                returnObject />

                <v-text-field label="Jumlah"
                              v-model="jumlahBarang" />

                <v-text-field label="Harga"
                              v-model="hargaBarang" />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "Create",
}
</script>