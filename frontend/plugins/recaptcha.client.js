import { install } from "vue3-recaptcha-v2";

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.vueApp.use(install, {
    sitekey: "6LefuewqAAAAAAddL0qfo-funTyX-9swDM9CDZ5L",
    cnDomains: false,
  });
});