<template>
  <div class="relative mx-auto max-w-md min-h-screen font-sans text-gray-900 transition-bg duration-700">
    <!-- Konten halaman -->
    <div class="relative z-10">
      <IntroSection id="intro" />
      <OurStory />
      <Gallery id="gallery" />
      <GroomBride id="wedding-gif" />
      <FooterSection id="footer" />
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import AOS from 'aos'
import 'aos/dist/aos.css'

import IntroSection from '@/components/IntroSection.vue'
import OurStory from '@/components/OurStory.vue'
import Gallery from '@/components/Gallery.vue'
import GroomBride from '@/components/GroomBride.vue'
import FooterSection from '@/components/FooterSection.vue'

// Daftar foto slideshow
const photos = ref([
  'https://plus.unsplash.com/premium_photo-1675851211463-7b04cd066e10?q=80&w=687&auto=format&fit=crop',
  'https://plus.unsplash.com/premium_photo-1675851211519-fc13d860e103?q=80&w=687&auto=format&fit=crop',
  'https://plus.unsplash.com/premium_photo-1675851211768-f8b9296ed7bd?q=80&w=687&auto=format&fit=crop',
])

const currentIndex = ref(0)

onMounted(() => {
  AOS.init({
    duration: 800,
    once: false,
    offset: -100,
    easing: 'ease-in-out',
  })

  // Slideshow otomatis setiap 5 detik
  setInterval(() => {
    currentIndex.value = (currentIndex.value + 1) % photos.value.length
  }, 5000)
})
</script>

<style>
.transition-bg {
  transition: background-image 0.1s ease-in-out;
}
</style>
