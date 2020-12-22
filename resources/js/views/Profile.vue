<template>
  <div class="profile">
    <div v-if="profile">
      <div class="p-2">
        <div
          class="background position-relative rounded"
          :style="`background-image: url('img/${profile.bgImg}')`"
        >
          <img
            class="rounded-circle profileImg"
            height="150px"
            :src="`img/${profile.profImg}`"
            alt="profImage"
          />
        </div>
        <div class="col-6 mx-auto text-center mt-5">
          <p>{{ profile.description }}</p>
        </div>
        <hr />
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
      this.$emit("profile", false);
    }
  };
</script>

<style scoped>
.background {
  height: 400px;
  width: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.profileImg {
  position: absolute;
  bottom: -10%;
  left: 50%;
  transform: translateX(-50%);
  box-shadow: 10px 10px 50px 3px #666;
}
</style>