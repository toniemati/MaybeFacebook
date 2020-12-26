<template>
  <div class="settings">
    <div v-if="profile">
      <div class="col mx-auto mt-3">
        <h1>Settings for: {{ profile.user.nickname }}</h1>

        <form @submit.prevent="saveChanges" enctype="multipart/form-data">
          <div class="form-group">
            <label for="bgImg">Background Image:</label>
            <input
              type="file"
              class="form-control-file"
              id="bgImg"
              @change="bgImageChanged"
            />
          </div>
          <div class="form-group">
            <label for="profImage">Profile Image:</label>
            <input
              type="file"
              class="form-control-file"
              id="profImage"
              @change="profImageChanged"
            />
          </div>
          <div class="form-group">
            <label for="desc">Description:</label>
            <textarea
              type="text"
              class="form-control"
              id="desc"
              rows="3"
              v-model="profile.description"
              @change="descChanged"
            ></textarea>
          </div>
          <button type="submit" class="btn btn-success">Save changes</button>
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

    props: ["auth"],

    data() {
      return {
        profile: null,
        editedProfile: {}
      };
    },

    methods: {
      getProfile: function(id) {
        axios
          .get(`/api/profiles/${id}`)
          .then(res => {
            this.profile = res.data;
            this.checkAuth();
            this.editedProfile.id = this.profile.id;
            this.editedProfile.user_id = this.profile.user_id;
          })
          .catch(err => console.log(err));
      },

      profImageChanged: function(e) {
        let fileReader = new FileReader();

        fileReader.readAsDataURL(e.target.files[0]);

        fileReader.onload = e => {
          this.editedProfile.profImg = e.target.result;
        };
      },

      bgImageChanged: function(e) {
        let fileReader = new FileReader();

        fileReader.readAsDataURL(e.target.files[0]);

        fileReader.onload = e => {
          this.editedProfile.bgImg = e.target.result;
        };
      },

      descChanged: function(e) {
        this.editedProfile.description = this.profile.description;
      },

      checkAuth: function() {
        if (this.profile.user.id !== this.auth.id) {
          this.$router.push({ path: `/${this.profile.user.nickname}` });
        }
      },

      saveChanges: function() {
        axios
          .put(`/api/profiles/${this.profile.id}`, this.editedProfile)
          .then(res =>
            this.$router.push({
              path: `/${this.profile.user.nickname}`
            })
          )
          .catch(err => console.log(err));
      }
    },

    created() {
      this.getProfile(this.$route.params.id);
      this.$emit("profile", false);
    }
  };
</script>

<style scoped>
textarea {
  resize: none;
}
</style>