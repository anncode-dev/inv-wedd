<template>
  <section
    v-if="showIntro"
    :class="[
      'relative min-h-screen px-6 text-white overflow-hidden transition-opacity duration-700',
      { 'opacity-0 pointer-events-none': hideIntro }
    ]"
  >
    <!-- Background Video -->
    <video
      ref="bgVideo"
      autoplay
      muted
      playsinline
      class="absolute top-0 left-0 w-full h-full object-cover"
    >
      <source src="/video/pembukaan.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>

    <!-- Content -->
    <div
      class="absolute bottom-28 left-0 right-0 text-center z-20 px-4 transition-opacity duration-500"
      :class="{ 'opacity-100': show, 'opacity-0': !show }"
    >
      <p class="text-base font-[txt]">Kepada Yth.</p>
      <p class="text-xl font-semibold mt-2 font-[txt]">{{ guestName }}</p>
      <button
        @click="handleOpenInvitation"
        class="bg-white/10 backdrop-blur-sm text-sm border border-white text-white px-6 py-3 mt-5 rounded-md transition-transform hover:scale-105 font-[txt]"
      >
        Buka Undangan
      </button>
    </div>
  </section>
</template>

<script setup>
import { ref, nextTick, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { db } from '@/firebase'
import { doc, getDoc } from 'firebase/firestore'

const show = ref(false)
const showIntro = ref(true)
const hideIntro = ref(false)
const guestName = ref('Tamu Undangan')
let audio = null
const musicUrl = '/music/music.mp3'

const route = useRoute()

// 🔹 Ambil kode unik dari URL dan fetch nama tamu dari Firebase
onMounted(async () => {
  const kode = route.params.kode
  if (kode) {
    const docRef = doc(db, 'tamu', kode)
    const docSnap = await getDoc(docRef)
    if (docSnap.exists()) {
      guestName.value = docSnap.data().nama
    }
  }

  // Lock scroll
  document.documentElement.classList.add('noscroll')
  document.body.classList.add('noscroll')

  setTimeout(() => {
    show.value = true
  }, 500)
})

// 🔹 Play musik & buka halaman utama
async function handleOpenInvitation() {
  if (!audio) {
    audio = new Audio(musicUrl)
    audio.loop = true
  }
  audio.play().catch((e) => console.warn('Autoplay gagal:', e))

  hideIntro.value = true
  await new Promise((resolve) => setTimeout(resolve, 700))
  showIntro.value = false
  await nextTick()

  // Unlock scroll
  document.documentElement.classList.remove('noscroll')
  document.body.classList.remove('noscroll')

  const el = document.getElementById('our-story')
  if (el) el.scrollIntoView({ behavior: 'smooth' })

  setTimeout(() => {
    if (window.AOS) {
      window.AOS.refresh()
      window.AOS.refreshHard()
    }
  }, 600)
}

// 🔹 Stop / resume musik saat user keluar tab
function handleVisibilityChange() {
  if (!audio) return
  if (document.hidden) audio.pause()
  else audio.play().catch(() => {})
}

onMounted(() => {
  document.addEventListener('visibilitychange', handleVisibilityChange)
})

onUnmounted(() => {
  if (audio) {
    audio.pause()
    audio.src = ''
    audio.load()
    audio = null
  }
  document.removeEventListener('visibilitychange', handleVisibilityChange)
})
</script>

<style>
html.noscroll,
body.noscroll {
  overflow: hidden !important;
  height: 100% !important;
}
</style>
