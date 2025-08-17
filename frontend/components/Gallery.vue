<template>
  <section id="gallery" class="max-w-md mx-auto px-4 mt-10">

    <!-- Preview Image -->
    <div class="mb-6 w-full h-96 rounded-lg overflow-hidden shadow-lg">
      <img
        :src="activeImage"
        alt="Preview"
        class="w-full h-full object-cover transition duration-300 ease-in-out"
        draggable="false"
      />
    </div>

    <!-- Slider -->
    <swiper
      :modules="[Autoplay, Pagination]"
      :slides-per-view="2.8"
      :space-between="10"
      :loop="true"
      :autoplay="{ delay: 2500, disableOnInteraction: false }"
      :pagination="{ clickable: true }"
      class="w-full rounded-lg overflow-hidden shadow-lg"
      @swiper="onSwiperInit"
      @slideChange="onSlideChange"
    >
      <swiper-slide
        v-for="(img, i) in images"
        :key="i"
        class="w-full h-full flex items-center justify-center overflow-hidden rounded-lg"
      >
        <img
          :src="img"
          alt="Galeri"
          class="w-32 h-32 object-cover"
          draggable="false"
        />
      </swiper-slide>
    </swiper>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import 'swiper/css'
import 'swiper/css/pagination'
import { Autoplay, Pagination } from 'swiper/modules'

// Image data
const images = ref([
  '/images/gambar-1.jpg',
  '/images/gambar-2.jpg',
  '/images/gambar-3.jpg',
  '/images/gambar-4.jpg',
  '/images/gambar-5.jpg',
  '/images/gambar-6.jpg',
  '/images/gambar-7.jpg',
])

// Preview image
const activeImage = ref(images.value[0])

// Swiper instance
const swiperInstance = ref(null)

const onSwiperInit = (swiper) => {
  swiperInstance.value = swiper
}

const onSlideChange = () => {
  if (swiperInstance.value) {
    activeImage.value = images.value[swiperInstance.value.realIndex]
  }
}
</script>
