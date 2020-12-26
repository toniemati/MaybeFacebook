<template>
  <div class="addpost">
    <div v-if="profile">
      <div class="col mx-auto mt-3">
        <h1>Settings for: {{ profile.user.name }}</h1>

        <form @submit.prevent="addPost" enctype="multipart/form-data">
          <div class="form-group">
            <label for="desc">Description:</label>
            <textarea
              class="form-control"
              id="desc"
              rows="4"
              @change="descChange"
            ></textarea>
          </div>
          <div class="form-group">
            <label for="img">Zdjęcie:</label>
            <input
              type="file"
              id="file"
              class="form-control-file"
              @change="imgChange"
            />
          </div>
          <button type="submit" class="btn btn-success">Add post</button>
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
    name: "AddPost",

    props: ["auth"],

    data() {
      return {
        profile: null,
        post: {}
      };
    },

    methods: {
      getProfile: function(id) {
        axios
          .get(`/api/profiles/${id}`)
          .then(res => {
            this.profile = res.data;
            this.checkAuth(id);
            this.post.profile_id = id;
          })
          .catch(err => console.log(err));
      },

      checkAuth: function(id) {
        if (this.auth.id !== this.profile.user_id) {
          this.$router.push({ path: `/${this.profile.user.username}` });
        }
      },

      descChange: function(e) {
        this.post.description = e.target.value;
      },

      imgChange: function(e) {
        let fileReader = new FileReader();

        fileReader.readAsDataURL(e.target.files[0]);

        fileReader.onload = e => {
          this.post.img = e.target.result;
        };
      },

      addPost: function() {
        axios
          .post("/api/posts", this.post)
          .then(res => {
            this.$router.push({ path: `/${this.profile.user.nickname}` });
          })
          .catch(err => console.log(err));
      }
    },

    created() {
      this.getProfile(this.$route.params.id);
    }
  };
</script>

<style scoped>
textarea {
  resize: none;
}
</style>