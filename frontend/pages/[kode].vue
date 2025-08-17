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

onMounted(async () => {
  // Fetch data tamu
  const kode = route.params.kode
  if (kode) {
    try {
      const docRef = doc(db, 'tamu', kode)
      const docSnap = await getDoc(docRef)
      if (docSnap.exists()) {
        guestName.value = docSnap.data().nama_kel || 'Tamu Undangan'

        // Set meta tag dinamis
        useHead({
          title: `Siti&Angga | anncode.dev`,
          meta: [
            { property: 'og:title', content: `Siti&Angga | anncode.dev` },
            { property: 'og:description', content: `Kami mengundang Saudara/i untuk hadir dalam acara pernikahan kami.` },
            { property: 'og:image', content: 'https://inv-wedd.vercel.app/images/gambar-1.jpg' },
            { property: 'og:url', content: window.location.href },
            { property: 'og:type', content: 'website' },
            { name: 'twitter:card', content: 'summary_large_image' },
            { name: 'twitter:title', content: `Siti&Angga | anncode.dev` },
            { name: 'twitter:description', content: `Kami mengundang Saudara/i untuk hadir dalam acara pernikahan kami.` },
            { name: 'twitter:image', content: 'https://inv-wedd.vercel.app/images/gambar-1.jpg' }
          ]
        })
      }
    } catch (error) {
      console.error('Gagal ambil data tamu:', error)
    }
  }

  guestLoaded.value = true

  // Init AOS
  AOS.init({ duration: 800, once: false, offset: -100, easing: 'ease-in-out' })

  // Slideshow otomatis
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
