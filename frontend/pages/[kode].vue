<template>
    
  <div>
    <!-- Intro Section -->
    <IntroSection v-if="guestLoaded" :guest-name="guestName" />

    <!-- Loading fallback -->
    <div v-else class="h-screen flex justify-center items-center text-center p-6 text-gray-700">
      <p class="txt-[hdr] text-2xl">Loading...</p>
    </div>

    <!-- Halaman utama undangan -->
    <div v-if="guestLoaded" class="relative mx-auto max-w-md min-h-screen font-sans text-gray-900 transition-bg duration-700">
      <div class="relative z-10">
        <OurStory />
        <FooterSection id="footer" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { db } from '@/firebase'
import { doc, getDoc } from 'firebase/firestore'
import { useHead } from '@vueuse/head'
import AOS from 'aos'
import 'aos/dist/aos.css'

import IntroSection from '@/components/IntroSection.vue'
import OurStory from '@/components/OurStory.vue'
import FooterSection from '@/components/FooterSection.vue'

const route = useRoute()
const guestName = ref('Tamu Undangan')
const guestLoaded = ref(false)
const photos = ref([
  'https://plus.unsplash.com/premium_photo-1675851211463-7b04cd066e10?q=80&w=687&auto=format&fit=crop',
  'https://plus.unsplash.com/premium_photo-1675851211519-fc13d860e103?q=80&w=687&auto=format&fit=crop',
  'https://plus.unsplash.com/premium_photo-1675851211768-f8b9296ed7bd?q=80&w=687&auto=format&fit=crop'
])
const currentIndex = ref(0)

</script>

<style>
.transition-bg {
  transition: background-image 0.1s ease-in-out;
}
</style>
