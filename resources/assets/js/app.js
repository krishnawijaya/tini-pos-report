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
    // icons: { defaultSet: 'mdi' },
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
    directives: vuetifyDirectives,
    components: { ...vuetifyComponents, ...vuetifyLabs },
})

createApp({ components }).use(vuetify).mount("#vue-app")
