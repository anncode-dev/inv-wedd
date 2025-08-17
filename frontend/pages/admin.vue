<template>
  <section class="p-6 max-w-xl mx-auto">
    <h1 class="text-xl font-bold mb-4">Admin - Tambah/Edit Tamu</h1>

    <input v-model="nama_kel" placeholder="Nama Keluarga" class="input" />
    <input v-model="kode" placeholder="Kode Tamu" class="input" />
    <input v-model="link_tamu" placeholder="Link Undangan" class="input" />
    <textarea v-model="ucapan_text" placeholder="Teks Undangan" class="textarea"></textarea>

    <button @click="simpanTamu" class="btn mt-4">Simpan</button>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { db } from '@/firebase'
import { doc, setDoc } from 'firebase/firestore'

const nama_kel = ref('')
const kode = ref('')
const link_tamu = ref('')
const ucapan_text = ref('')

async function simpanTamu() {
  if (!kode.value) return alert('Kode tamu wajib diisi!')

  await setDoc(doc(db, 'tamu', kode.value), {
    nama_kel: nama_kel.value,
    kode: kode.value,
    link_tamu: link_tamu.value,
    ucapan_text: ucapan_text.value
  })

  alert('Tamu berhasil disimpan!')
  nama_kel.value = ''
  kode.value = ''
  link_tamu.value = ''
  ucapan_text.value = ''
}
</script>

<style>
.input { display:block; width:100%; margin-top:8px; padding:8px; border-radius:6px; border:1px solid #ccc }
.textarea { display:block; width:100%; margin-top:8px; padding:8px; border-radius:6px; border:1px solid #ccc; min-height:100px }
.btn { padding:8px 16px; border:none; border-radius:6px; background:#4f46e5; color:white; cursor:pointer }
</style>
