<template>
    <v-container>
        <v-row>
            <v-col>
                <div class="dodi-ukir-controls">
                    <date-picker :config="datePickerConfig"
                                 v-model="selectedDates"
                                 @change="change" />
                </div>
                <v-btn @click="click">Click</v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col>
                <!-- <v-data-table></v-data-table> -->
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import DatePicker from "vue-flatpickr-component"

export default {
    name: "Report",
    components: { DatePicker },
    data: () => ({
        selectedDates: [],
        datePickerConfig: {
            mode: "range"
        }
    }),
    methods: {
        change(value) {
            console.log(value);
        },
        click() {
            console.log(this.selectedDates);
            console.log(typeof this.selectedDates);
        }
    }
}
</script>

<style scoped>
.dodi-ukir-controls>>>input {
    border: thin solid;
}
</style>