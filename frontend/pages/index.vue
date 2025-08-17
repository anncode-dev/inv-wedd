<template>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Siti&Angga | anncode.dev</title>

    <!-- Open Graph -->
    <meta property="og:title" content="Siti&Angga | anncode.dev" />
    <meta property="og:description" content="Kami mengundang Anda untuk hadir dalam acara pernikahan kami." />
    <meta property="og:image" content="https://inv-wedd.vercel.app/images/gambar-1.jpg" />
    <meta property="og:url" content="https://inv-wedd.vercel.app/" />

    <meta property="og:type" content="website" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Siti&Angga | anncode.dev" />
    <meta name="twitter:description" content="Kami mengundang Anda untuk hadir dalam acara pernikahan kami." />
    <meta property="og:image" content="https://inv-wedd.vercel.app/images/gambar-1.jpg" />
    <meta property="og:url" content="https://inv-wedd.vercel.app/" />
  </head>
  <div class="relative mx-auto max-w-md min-h-screen font-sans text-gray-900 transition-bg duration-700">
    <div class="relative z-10">
      <IntroSection id="intro" />
      <OurStory />
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

const imageUrl = `${window.location.origin}/images/gambar-1.jpg`
const url = window.location.href;

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
