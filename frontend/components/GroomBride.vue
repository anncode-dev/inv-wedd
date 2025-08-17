<template>
  <section id="wedding-gif" class="text-white px-8 py-20 bg-gradient-black-opacity" >
    <div class="mb-12 text-center mt-12" data-aos="fade-up">
      <h2 class="text-3xl font-semibold text-white/80 mb-2" data-aos="fade-up" data-aos-delay="100">WEDDING GIFT</h2>
      <p class="text-white/70 max-w-xl mx-auto italic">
        Kehadiran dan doa restu Bapak/Ibu/Saudara/i merupakan anugerah terindah bagi kami. Namun, apabila Bapak/Ibu/Saudara/i tidak dapat hadir dan hendak memberikan tanda kasih kepada kami, dapat menggunakan fitur di bawah ini.
      </p>
      <div class="flex justify-center mt-5 items-center text-white/80 space-x-6">
        <button
          @click="scrollTo('our-story')"
          class="bg-white/10 backdrop-blur-sm border border-white text-white px-6 py-3 rounded-md font-semibold transition-transform hover:scale-105"
        >
          Cash Gift
        </button>
        <button
          @click="scrollTo('our-story')"
          class="bg-white/10 backdrop-blur-sm border border-white text-white px-6 py-3 rounded-md font-semibold transition-transform hover:scale-105"
        >
          Send Gift
        </button>
      </div>
    </div>

    <!-- Section RSVP -->
    <div class="mt-20 max-w-xl mx-auto text-center" data-aos="fade-up">
      <h2 class="text-3xl font-semibold text-white/80 mb-2">RSVP</h2>
      <p class="text-white/70 mb-6 italic">
        Mohon kesediaannya untuk mengisi konfirmasi kehadiran di bawah ini.
      </p>

      <form @submit.prevent="submitRSVP" class="space-y-4 text-left">
        <div>
          <label class="block text-sm mb-1">Nama Lengkap</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full px-4 py-2 bg-white/10 border border-white/30 text-white rounded focus:outline-none"
            required
          />
        </div>
        <div>
          <label class="block text-sm mb-1">Kehadiran</label>
          <select
            v-model="form.attendance"
            class="w-full px-4 py-2 bg-white/10 border border-white/30 text-white rounded focus:outline-none"
            required
          >
            <option value="">Pilih salah satu</option>
            <option value="Hadir">Hadir</option>
            <option value="Tidak Hadir">Tidak Hadir</option>
          </select>
        </div>
        <div class="text-center pt-4">
          <button
            type="submit"
            class="bg-white/10 backdrop-blur-sm border border-white text-white px-6 py-3 rounded-md font-semibold transition-transform hover:scale-105"
          >
            Kirim RSVP
          </button>
        </div>
      </form>
    </div>

    <div>
      <img src="https://plus.unsplash.com/premium_photo-1675851210850-de5525809dd9?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
           alt="Wedding Gift" 
           class="w-full h-60 object-cover rounded-lg shadow-lg mt-10"
           loading="lazy">
    </div>

    <!-- Wishess -->
     <div class="mt-10 max-w-xl mx-auto text-center" data-aos="fade-up">
      <h2 class="text-3xl font-semibold text-white/80 mb-2">WISHESS</h2>
      <p class="text-white/70 mb-6 italic">
        Mohon kesediaannya untuk mengisi konfirmasi kehadiran di bawah ini.
      </p>

      <form @submit.prevent="submitRSVP" class="space-y-4 text-left">
        <div>
          <label class="block text-sm mb-1">Nama Lengkap</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full px-4 py-2 bg-white/10 border border-white/30 text-white rounded focus:outline-none"
            required
          />
        </div>
        <div>
          <label class="block text-sm mb-1">Ucapan & Doa</label>
          <textarea
            v-model="form.message"
            rows="3"
            class="w-full px-4 py-2 bg-white/10 border border-white/30 text-white rounded focus:outline-none"
            placeholder="Tulis ucapan terbaikmu..."
          ></textarea>
        </div>
        <div class="text-center pt-4">
          <button
            type="submit"
            class="bg-white/10 backdrop-blur-sm border border-white text-white px-6 py-3 rounded-md font-semibold transition-transform hover:scale-105"
          >
            Kirim
          </button>
        </div>
      </form>
    </div>

    <div class="mt-10 max-w-xl mx-auto text-center" data-aos="fade-up">
      <h2 class="text-3xl font-semibold text-white/80 mb-2">SEE YOU ON OUR BIG DAY!</h2>
      <p class="text-white/70 mb-6 italic">
        Mohon kesediaannya untuk mengisi konfirmasi kehadiran di bawah ini.
      </p>
      <img src="https://plus.unsplash.com/premium_photo-1675851211748-3b6a771cec02?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3Dx" 
           alt="Wedding Gift" 
           class="w-full h-60 object-cover rounded-lg shadow-lg mt-10"
           loading="lazy">
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

// Form data
const form = ref({
  name: '',
  attendance: '',
  message: '',
})

// Handle submit
const submitRSVP = () => {
  console.log('RSVP submitted:', form.value)
  alert('Terima kasih telah mengisi RSVP!')

  // Reset form
  form.value = {
    name: '',
    attendance: '',
    message: '',
  }
}

// Dummy scrollTo untuk tombol gift
const scrollTo = (id) => {
  const el = document.getElementById(id)
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}
</script>
<style scoped>

.bg-gradient-black-opacity {
  background: linear-gradient(
    to bottom,
    rgba(0, 0, 0, 0.08),
    rgba(0, 0, 0, 0.842)
  );
}
</style>