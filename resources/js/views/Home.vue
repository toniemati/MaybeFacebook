<template>
  <div>
    <h1>Home</h1>
  </div>
</template>

<script>
  export default {
    name: "Home",

    created() {
      this.$emit("profile", true);
    }
  };
</script>

<style>
</style>