<template>
  <section
    v-if="showIntro"
    class="relative min-h-screen px-6 text-white overflow-hidden transition-opacity duration-700"
    :class="{ 'opacity-0 pointer-events-none': hideIntro }"
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
    </video>

    <!-- Konten Intro -->
    <div
      class="absolute bottom-28 left-0 right-0 text-center z-20 px-4 transition-opacity duration-500"
    >
      <p class="text-base font-[txt]">Kepada Yth.</p>
      <p class="text-xl font-semibold mt-2 font-[txt]">{{ NamaTamu }}</p>
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

// Ambil query dari router
const route = useRoute()
const NamaTamu = ref(route.query.to || 'Tamu Undangan') 
console.log(`Guest Name: ${NamaTamu.value}`);
const Tamu = NamaTamu.value || 'Tamu Undangan'


// Audio dan kontrol intro
const showIntro = ref(true)
const hideIntro = ref(false)
let audio = null
const musicUrl = '/music/music.mp3'

// Fungsi tombol "Buka Undangan"
async function handleOpenInvitation() {
  if (!audio) {
    audio = new Audio(musicUrl)
    audio.loop = true
  }
  audio.play().catch(() => {})

  hideIntro.value = true
  await new Promise((resolve) => setTimeout(resolve, 700))
  showIntro.value = false
  await nextTick()

  document.documentElement.classList.remove('noscroll')
  document.body.classList.remove('noscroll')

  const el = document.getElementById('our-story')
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}

function handleVisibilityChange() {
  if (!audio) return
  if (document.hidden) audio.pause()
  else audio.play().catch(() => {})
}

onMounted(() => document.addEventListener('visibilitychange', handleVisibilityChange))
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
