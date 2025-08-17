import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "../App.vue";

const app = createApp(App);
app.use(createPinia()); // Aktifkan Pinia
app.mount("#app");
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import AOS from 'aos'
import 'aos/dist/aos.css'

onMounted(() => {
  AOS.init({
  duration: 800,
  once: false,
  offset: -100,
  easing: 'ease-in-out',
})
})

