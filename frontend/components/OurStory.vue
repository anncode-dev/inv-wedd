<template>

  <section class="relative min-h-screen px-6 text-white overflow-hidden transition-opacity duration-700">
    <video ref="bgVideo" autoplay muted playsinline class="absolute top-0 left-0 w-full h-full object-cover">
      <source src="/video/bagian-satu.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>
  </section>

  <section class="relative min-h-screen px-6 text-white overflow-hidden transition-opacity duration-700 flex items-center justify-center text-center">
  <video ref="bgVideo" autoplay muted playsinline class="absolute top-0 left-0 w-full h-full object-cover">
    <source src="/video/kedua.mp4" type="video/mp4" />
    Your browser does not support the video tag.
  </video>
  <div class="relative z-10 max-w-2xl">
    <p class="text-white  mb-6 text-2xl font-[txt] leading-relaxed" data-aos="fade-up" data-aos-delay="100">
      وَمِنْ اٰيٰتِهٖٓ اَنْ خَلَقَ لَكُمْ مِّنْ اَنْفُسِكُمْ اَزْوَاجًا 
      لِّتَسْكُنُوْٓا اِلَيْهَا وَجَعَلَ بَيْنَكُمْ مَّوَدَّةً وَّرَحْمَةًۗ 
      اِنَّ فِيْ ذٰلِكَ لَاٰيٰتٍ لِّقَوْمٍ يَّتَفَكَّرُوْنَ 
    </p>
    <p class="text-xl leading-relaxed font-[txt] px-2" data-aos="fade-up" data-aos-delay="200">
      "Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan
      untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan
      Dia menjadikan di antaramu rasa kasih dan sayang. Sungguh, pada yang demikian itu
      benar-benar terdapat tanda-tanda (kebesaran Allah) bagi kaum yang berpikir."
      <span class="block mt-2">(<i>Q.S. Ar-Rum: 21</i>)</span>
    </p>
  </div>
</section>


  <section class="relative bg-black text-white text-center">
    <div>
      <p class="font-[txt] text-4xl" data-aos="fade-up" data-aos-delay="100">بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ</p>
    </div>
    <div class="mt-6 px-10" data-aos="fade-up" data-aos-delay="200">
      <p class="text-sm font-semibold mt-2 font-[txt]" >
        Dengan memohonkan Rahmat dan Ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk hadir pada acara pernikahan kami.
      </p>
    </div>
  </section>

  <section class="relative min-h-screen px-6 text-white overflow-hidden transition-opacity duration-700">
    <video ref="bgVideo" autoplay muted playsinline class="absolute top-0 left-0 w-full h-full object-cover">
      <source src="/video/bride-cewe.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>
    <div class="absolute bottom-24 left-0 right-0 text-center z-10 max-w-2xl mx-auto px-4">
      <p class="text-white text-6xl font-[hdr] leading-relaxed" data-aos="fade-up" data-aos-delay="100">
        Siti Santia
      </p>
      <hr class="border-2 border-white mx-40 rounded-full my-6">
      <p class="text-xl mt-2 leading-relaxed font-[txt] px-5" data-aos="fade-up" data-aos-delay="200">
        Putri ke empat dari <br> Bapak Koyan & Ibu Enung
      </p>
    </div>
  </section>

  <section class="relative bg-black text-white text-center">
    <div class="px-10">
      <p class="text-7xl font-semibold font-[txt]" >
        &
      </p>
    </div>
  </section>

  <section class="relative min-h-screen px-6 text-white overflow-hidden transition-opacity duration-700">
    <video ref="bgVideo" autoplay muted playsinline class="absolute top-0 left-0 w-full h-full object-cover">
      <source src="/video/bride-cowo.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>
    <div class="absolute bottom-24 left-0 right-0 text-center z-10 max-w-2xl mx-auto px-4">
      <p class="text-white text-5xl font-[hdr] leading-relaxed" data-aos="fade-up" data-aos-delay="100">
        Angga Agnia
      </p>
      <hr class="border-2 border-white mx-40 rounded-full my-6">
      <p class="text-xl mt-2 leading-relaxed font-[txt] px-5" data-aos="fade-up" data-aos-delay="200">
        Putri ke empat dari <br> Bapak Joni & Ibu Erna
      </p>
    </div>
  </section>

  

  <section class="relative min-h-screen px-6 text-white overflow-hidden transition-opacity duration-700 flex flex-col items-center justify-center text-center">
    <video ref="bgVideo" autoplay muted playsinline class="absolute top-0 left-0 w-full h-full object-cover">
      <source src="/video/bagian-ketiga.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>
    <div
      ref="countdownRef"
      class="countdown"
    >
      <div class="mb-10 mt-20">
        <p class="text-4xl text-center font-[hdr] text-white" data-aos="zoom-in">Hari Yang Ditunggu</p>
        <hr class="w-24 mx-auto my-4 border-t-2 border-white/30" data-aos="zoom-in" />
      </div>
      <div class="flex  justify-center space-x-6 px-5 bg-white/10 backdrop-blur-sm border-2 border-white text-white py-5  font-semibold transition-transform hover:scale-105" data-aos="zoom-in">
        <div class="text-center ">
          <p class="text-6xl text-white font-bold">{{ days }}</p>
          <p class="text-sm mt-2 text-white/80">Hari</p>
        </div>
        <div class="text-center">
          <p class="text-6xl  text-white font-bold">{{ hours }}</p>
          <p class="text-sm mt-2 text-white/80">Jam</p>
        </div>
        <div class="text-center">
          <p class="text-6xl text-white font-bold">{{ minutes }}</p>
          <p class="text-sm mt-2 text-white/80">Menit</p>
        </div>
        <div class="text-center">
          <p class="text-6xl text-white font-bold">{{ seconds }}</p>
          <p class="text-sm mt-2 text-white/80">Detik</p>
        </div>
      </div>
        <div class="flex flex-col items-center mt-10">
          <p class="text-2xl text-center font-[txt]  text-white/90" data-aos="zoom-in">Save The Date</p>
        </div>  
        <div class="text-center mt-10">
          <button
            @click="addToCalendar"
            class="bg-white/10 backdrop-blur-sm border border-white text-white px-6 py-3 rounded-md font-semibold transition-transform hover:scale-105"
          >
            Tambah Ke Kalender
          </button>
        </div>
    </div>
  </section>

  <section class="relative min-h-screen px-6 text-white overflow-hidden">
    <!-- Background Video -->
    <video
      ref="bgVideo"
      autoplay
      muted
      playsinline
      class="absolute top-0 left-0 w-full h-full object-cover z-0"
    >
      <source src="/video/bagian-keempat.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>

    <!-- Foreground Content -->
    <div class="relative z-10 py-40 mt-20">
      <Gallery id="gallery" />
    </div>
  </section>



</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import AOS from 'aos'
import 'aos/dist/aos.css'
import Gallery from '@/components/Gallery.vue'

// Countdown Logic
const days = ref(0)
const hours = ref(0)
const minutes = ref(0)
const seconds = ref(0)
const targetDate = new Date('2025-08-30T00:00:00')
let countdownInterval = null

function updateCountdown() {
  const now = new Date()
  const timeDiff = targetDate - now
  if (timeDiff <= 0) {
    clearInterval(countdownInterval)
    days.value = hours.value = minutes.value = seconds.value = 0
    return
  }
  days.value = Math.floor(timeDiff / (1000 * 60 * 60 * 24))
  hours.value = Math.floor((timeDiff / (1000 * 60 * 60)) % 24)
  minutes.value = Math.floor((timeDiff / (1000 * 60)) % 60)
  seconds.value = Math.floor((timeDiff / 1000) % 60)
}

const countdownRef = ref(null)
const isCountdownVisible = ref(false)

onMounted(() => {
  AOS.init({ duration: 800, once: true })
  updateCountdown()
  countdownInterval = setInterval(updateCountdown, 1000)

  const countdownObserver = new IntersectionObserver(
    (entries) => {
      isCountdownVisible.value = entries[0].isIntersecting
    },
    { threshold: 0.3 }
  )
  if (countdownRef.value) countdownObserver.observe(countdownRef.value)
})

onBeforeUnmount(() => {
  clearInterval(countdownInterval)
})

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

const eventTitle = "Acara Pernikahan Siti Santia & Angga Agnia"
const eventLocation = "Kp. Ci Pangawaren RT 09/02 Pasir Panjang, Ciracap"
const eventDescription = "Undangan pernikahan Siti Santia & Pasangan"
const eventStart = "2025-12-30T10:00:00" // format ISO 8601
const eventEnd = "2025-12-30T13:00:00"

function addToCalendar() {
  // Google Calendar
  const start = eventStart.replace(/-|:|\.\d+/g, "")
  const end = eventEnd.replace(/-|:|\.\d+/g, "")
  const url = `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventTitle)}&dates=${start}/${end}&details=${encodeURIComponent(eventDescription)}&location=${encodeURIComponent(eventLocation)}&sf=true&output=xml`
  
  window.open(url, "_blank")
}
</script>

<style scoped>
.countdown p {
  transition: all 0.3s ease;
}

.bg-gradient-black-opacity {
  background: linear-gradient(to bottom, rgba(0, 0, 0, 0.664), rgba(0, 0, 0, 0.08));
}
</style>
