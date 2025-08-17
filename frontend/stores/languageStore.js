import { defineStore } from "pinia";

export const useLanguageStore = defineStore("language", {
  state: () => ({
    selectedLang: localStorage.getItem("selectedLang") || "id", // Default ke "id"
  }),
  actions: {
    switchLanguage(lang) {
      this.selectedLang = lang;
      localStorage.setItem("selectedLang", lang); // Simpan di localStorage agar tidak hilang saat refresh
    },
  },
});
