import "vuetify/styles"
import '@mdi/font/css/materialdesignicons.css'

import { createApp } from "vue";
import { createVuetify } from "vuetify"
import * as vuetifyComponents from "vuetify/components"
import * as vuetifyDirectives from "vuetify/directives"
import * as vuetifyLabs from "vuetify/labs/components"
import * as components from "./components"

import { aliases, mdi } from 'vuetify/iconsets/mdi'

const vuetify = createVuetify({
    components: { ...vuetifyComponents, ...vuetifyLabs },
    directives: vuetifyDirectives,
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
})

createApp({ components }).use(vuetify).mount("#vue-app")
