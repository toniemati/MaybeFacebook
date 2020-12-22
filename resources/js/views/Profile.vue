<template>
  <div class="profile">
    <div v-if="profile">
      <div>
        <h1>Profile: {{ profile.user.name }}</h1>

        <div>
          <h2>bg image</h2>
          <img :src="`img/${profile.bgImg}`" class="w-100" alt="bgImage" />
        </div>
        <div>
          <h2>prof imafe</h2>
          <img :src="`img/${profile.profImg}`" class="w-100" alt="profImage" />
        </div>
        <div>
          <h2>description</h2>
          <p>{{ profile.description }}</p>
        </div>
      </div>
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
    name: "Profile",

    data() {
      return {
        profile: null
      };
    },

    methods: {
      getProfiles: function(slug) {
        axios
          .get("/api/profiles")
          .then(res => {
            let profiles = res.data;
            profiles.forEach(profil => {
              if (profil.user.name == slug) {
                this.getProfile(profil.id);
              }
            });
          })
          .catch(err => console.log(err));
      },

      getProfile: function(id) {
        axios
          .get(`/api/profiles/${id}`)
          .then(res => (this.profile = res.data))
          .catch(err => console.log(err));
      }
    },

    created() {
      this.getProfiles(this.$route.params.slug);
    }
  };
</script>

<style>
</style>