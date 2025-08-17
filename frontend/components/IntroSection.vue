<template>
  <section
    v-if="showIntro"
    :class="['relative min-h-screen px-6 text-white overflow-hidden transition-opacity duration-700', { 'opacity-0 pointer-events-none': hideIntro }]"
  >
    <video
      ref="bgVideo"
      autoplay
      muted
      playsinline
      class="absolute top-0 left-0 w-full h-full object-cover"
    >
      <source src="/video/intro.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>


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
import { ref, nextTick, onMounted } from 'vue'

const show = ref(false)
const showIntro = ref(true)
const hideIntro = ref(false)
const guestName = ref('Tamu Undangan')
const audio = ref(null)

const musicUrl = ''

onMounted(() => {
  const params = new URLSearchParams(window.location.search)
  const to = params.get('to')
  if (to) guestName.value = decodeURIComponent(to)

  // Lock scroll (html + body)
  document.documentElement.classList.add('noscroll')
  document.body.classList.add('noscroll')

  setTimeout(() => {
    show.value = true
  }, 500)
})

async function handleOpenInvitation() {
  if (!audio.value) {
    audio.value = new Audio(musicUrl)
    audio.value.loop = true
  }
  audio.value.play().catch((e) => {
    console.warn('Autoplay gagal:', e)
  })

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
</script>

<style>
html.noscroll,
body.noscroll {
  overflow: hidden !important;
  height: 100% !important;
}

.svg-text-outline {
    fill: none;
    stroke: #472f1a;
    stroke-width: 18;
    font-size: 280px;
    font-family: 'SNPro', sans-serif;
    stroke-dasharray: 1000;
    stroke-dashoffset: 0;
    animation: drawText 3s  infinite;
  }

  .svg-text-fill {
    fill: white;
    stroke: none;
    font-size: 280px;
    font-family: 'SNPro', sans-serif;
  }

  @keyframes drawText {
    0% {
      stroke-dashoffset: 2000;
    }
    100% {
      stroke-dashoffset: 100;
    }
  }
</style>
