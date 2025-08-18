<template>
  <section class="p-6 max-w-xl mx-auto font-[txt] relative">
    <h1 class="text-xl font-bold mb-4">Admin - Tambah/Edit Tamu</h1>

    <input v-model="nama_kel" placeholder="Nama Keluarga" class="input" />
    <input v-model="nama_pasangan" placeholder="Nama Pasangan" class="input" />

    <button @click="generateLink" class="btn mt-4">Generate Link & Teks</button>

    <textarea v-model="ucapan_text" placeholder="Teks Undangan" class="textarea mt-2" readonly></textarea>

    <div v-if="link_tamu" class="flex gap-2 mt-4">
      <button @click="salinTeks" class="btn bg-blue-600">Salin Teks</button>
      <button @click="resetForm" class="btn bg-gray-600">Tambah Nama Tamu Lain</button>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { db } from '@/firebase'
import { doc, setDoc } from 'firebase/firestore'

const nama_kel = ref('')
const nama_pasangan = ref('')
const link_tamu = ref('')
const ucapan_text = ref('')

async function generateLink() {
  if (!nama_kel.value || !nama_pasangan.value) return alert('Nama tamu dan pasangan wajib diisi!')

  const origin = window.location.origin
  const param = encodeURIComponent(`${nama_kel.value} & ${nama_pasangan.value}`)
  link_tamu.value = `${origin}/?to=${param}`

  ucapan_text.value = `${nama_kel.value} & ${nama_pasangan.value}

Bismillahirrahmanirrahim
Assalamu'alaikum Warahmatullahi Wabarakatuh

Yth. Bpk/Ibu/Sdr/i ${nama_kel.value.toUpperCase()}, 

Dengan mengharap ridha dan rahmat Allah SWT, serta tanpa mengurangi rasa hormat. Perkenankan kami mengundang Bpk/Ibu/Sdr/i untuk hadir di acara pernikahan kami pada:

Nama: ${nama_kel.value} & ${nama_pasangan.value}
Hari/Tgl: Sabtu, 30 Agustus 2025
Pukul: 08.00 s.d. selesai
Lokasi: Kp. Ci Pangawaren RT 09/02, Pasir Panjang, Ciracap

Merupakan suatu kehormatan bagi kami apabila Bpk/Ibu/Sdr/i dapat menghadiri/menyaksikan prosesi pernikahan kami pada tautan dibawah ini:

${link_tamu.value}

Kami juga mengharapkan ucapan, harapan, serta doa Bpk/Ibu/Sdr/i untuk kami.

Atas perhatiannya kami ucapkan terimakasih.`

  // Simpan ke Firestore
  const docId = `${nama_kel.value}_${nama_pasangan.value}`.replace(/\s+/g, '_')
  try {
    await setDoc(doc(db, 'tamu', docId), {
      nama_kel: nama_kel.value,
      nama_pasangan: nama_pasangan.value,
      link_tamu: link_tamu.value,
      ucapan_text: ucapan_text.value
    })
    alert('Tamu berhasil disimpan & teks undangan di-generate!')
  } catch (err) {
    alert('Gagal menyimpan tamu! ' + err.message)
  }
}

function salinTeks() {
  if (!ucapan_text.value) return alert('Teks undangan kosong!')
  try {
    navigator.clipboard.writeText(ucapan_text.value)
    alert('Teks undangan berhasil disalin!')
  } catch (err) {
    // fallback untuk browser lama
    const el = document.createElement('textarea')
    el.value = ucapan_text.value
    document.body.appendChild(el)
    el.select()
    document.execCommand('copy')
    document.body.removeChild(el)
    alert('Teks undangan berhasil disalin (fallback)!')
  }
}

function resetForm() {
  nama_kel.value = ''
  nama_pasangan.value = ''
  link_tamu.value = ''
  ucapan_text.value = ''
}
</script>

<style>
.input { display:block; width:100%; margin-top:8px; padding:8px; border-radius:6px; border:1px solid #ccc }
.textarea { display:block; width:100%; margin-top:8px; padding:8px; border-radius:6px; border:1px solid #ccc; min-height:100px }
.btn { padding:8px 16px; border:none; border-radius:6px; background:#4f46e5; color:white; cursor:pointer }
.bg-gray-600 { background:#4b5563; }
.bg-blue-600 { background:#2563eb; }
</style>
