<template>
  <div class="settings">
    <div v-if="profile">
      <div class="col mx-auto mt-3">
        <h1>Settings for: {{ profile.user.name }}</h1>

        <form @submit.prevent="saveChanges" enctype="multipart/form-data">
          <div class="form-group">
            <label for="bgImg">Background Image:</label>
            <input
              type="file"
              class="form-control-file"
              id="bgImg"
              @change="imageChange"
            />
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
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
      },

      imageChange: function(e) {
        let fileReader = new FileReader();

        fileReader.readAsDataURL(e.target.files[0]);

        fileReader.onload = e => {
          this.profile.bgImg = e.target.result;
        };
      },

      saveChanges: function() {
        axios
          .put(`/api/profiles/${this.profile.id}`, this.profile)
          .then(res => console.log(res))
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