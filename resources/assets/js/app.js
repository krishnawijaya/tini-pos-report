import { createApp } from "vue";
import { createVuetify } from "vuetify"
import * as vuetifyComponents from "vuetify/components"
import * as vuetifyDirectives from "vuetify/directives"
import * as components from "./components"

import "vuetify/styles"
import 'flatpickr/dist/flatpickr.css';

const vuetify = createVuetify({ components: vuetifyComponents, directives: vuetifyDirectives, })
createApp({ components }).use(vuetify).mount("#vue-app")