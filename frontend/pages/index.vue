<template>
  <div class="relative mx-auto max-w-md min-h-screen font-sans text-gray-900 transition-bg duration-700">
    <!-- Background fixed -->
    <div
      class="fixed inset-0 -z-10 bg-cover bg-center bg-no-repeat"
      :style="{
        backgroundImage: `url(${bgDefault})`,
      }"
    ></div>

    <!-- Overlay hitam transparan -->
    <div class="fixed inset-0 -z-5 bg-black opacity-50"></div>

    <!-- Konten halaman -->
    <div class="relative z-10">
      <IntroSection id="intro" />
      <OurStory/>
      <Gallery id="gallery" />
      <GroomBride id="wedding-gif" />
      <FooterSection id="footer" />
    </div>
  </div>
</template>

<script setup>
import AOS from 'aos'
import 'aos/dist/aos.css'
import { onMounted } from 'vue'


import IntroSection from '@/components/IntroSection.vue'
import OurStory from '@/components/OurStory.vue'
import EventDetails from '@/components/EventDetails.vue'
import MapLocation from '@/components/MapLocation.vue'
import Gallery from '@/components/Gallery.vue'
import FooterSection from '@/components/FooterSection.vue'

const bgDefault = 'https://plus.unsplash.com/premium_photo-1675851210850-de5525809dd9?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'

onMounted(() => {
  AOS.init({
  duration: 800,
  once: false,
  offset: -300,
  easing: 'ease-in-out',
})
})
</script>

<style>
.transition-bg {
  transition: background-image 0.7s ease-in-out;
}
</style>
