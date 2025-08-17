<template>
  <div>
    <div>
      <slot />
    </div>
  </div>
</template>

<script>

export default {
  name: "Layout",
  data() {
    return {
      loading: true,
    };
  },
  mounted() {
    setTimeout(() => {
      this.loading = false;
    }, 2000); 
  },
};
</script>

<style scoped>
.d{
  background-color: #ffffff8c;
}
</style>
