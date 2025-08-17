// firebase.js
import { initializeApp } from "firebase/app";
import { getFirestore } from "firebase/firestore";

// Konfigurasi Firebase project
const firebaseConfig = {
  apiKey: "AIzaSyBBA3UNK6PmbR-_mmADfFiCTkSXu-gbmHw",
  authDomain: "invwedding-628de.firebaseapp.com",
  projectId: "invwedding-628de",
  storageBucket: "invwedding-628de.appspot.com", // perbaiki url jika perlu
  messagingSenderId: "1067770305911",
  appId: "1:1067770305911:web:781ca298e3f802f1c25572"
};

// Inisialisasi Firebase
const app = initializeApp(firebaseConfig);

// Inisialisasi Firestore
const db = getFirestore(app);

// Export agar bisa digunakan di komponen Vue
export { db };
