import "vuetify/styles"

import { createApp } from "vue";
import { createVuetify } from "vuetify"
import * as vuetifyComponents from "vuetify/components"
import * as vuetifyDirectives from "vuetify/directives"
import * as vuetifyLabs from "vuetify/labs/components"
import * as components from "./components"

const vuetify = createVuetify({
    components: { ...vuetifyComponents, ...vuetifyLabs },
    directives: vuetifyDirectives,
})

createApp({ components }).use(vuetify).mount("#vue-app")
