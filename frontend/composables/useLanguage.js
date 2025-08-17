import { ref, watchEffect } from "vue";

export function useLanguage() {
  const selectedLang = ref(localStorage.getItem("lang") || "id");
  const isID = ref(selectedLang.value === "id");

  // Simpan ke localStorage setiap kali berubah
  watchEffect(() => {
    localStorage.setItem("lang", selectedLang.value);
  });

  // Fungsi ganti bahasa
  const switchLanguage = (toID) => {
    isID.value = toID;
    selectedLang.value = toID ? "id" : "en";
  };

  return { selectedLang, isID, switchLanguage };
}
