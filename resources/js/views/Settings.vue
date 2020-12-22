<template>
  <div class="settings">
    <div v-if="profile">
      <h1>settings: {{ profile.user.name }}</h1>
    </div>
    <div
      v-else
      style="height:50vh;"
      class="d-flex justify-content-center align-items-center"
    >
      <div class="spinner-border text-dark" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "Settings",

    data() {
      return {
        profile: null
      };
    },

    methods: {
      getProfile: function(id) {
        axios
          .get(`/api/profiles/${id}`)
          .then(res => (this.profile = res.data))
          .catch(err => console.log(err));
      }
    },

    created() {
      this.getProfile(this.$route.params.id);
    }
  };
</script>

<style>
</style>