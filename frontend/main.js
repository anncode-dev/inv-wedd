// main.js
import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "../App.vue";

import { createMetaManager } from 'vue-meta'

const metaManager = createMetaManager()
app.use(metaManager)


import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import AOS from 'aos'
import 'aos/dist/aos.css'

// Buat instance app
const app = createApp(App);
app.use(createPinia());

// Inisialisasi AOS sekali
AOS.init({
  duration: 800,
  once: false,
  offset: -100,
  easing: 'ease-in-out',
});

app.mount("#app");
