const spgStore = useSpgStore();

export default defineNuxtRouteMiddleware((to, from) => {
  if (!spgStore.isAuthenticated()) {
    console.log("Unauthorized access");

    return {
      path: "/",
      query: {
        redirect: to.fullPath,
      },
    };
  }
});
