<template>
  <div class="editpost">
    <div v-if="post">
      <div class="col mx-auto mt-3">
        <h1>Editing post</h1>

        <form @submit.prevent="updatePost" enctype="multipart/form-data">
          <div class="form-group">
            <label for="desc">Description:</label>
            <textarea
              class="form-control"
              id="desc"
              rows="4"
              v-model="post.description"
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
          <div class="form-group d-flex justify-content-around mt-5">
            <button
              type="button"
              @click="deletePost(post.id)"
              class="btn btn-danger"
            >
              Usuń
            </button>
            <button type="submit" class="btn btn-warning">Zapisz zmiany</button>
          </div>
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
    name: "EditPost",
    props: ["auth"],
    data() {
      return {
        post: null
      };
    },
    methods: {
      checkAuth: function() {
        if (this.auth.id !== this.post.profile_id) {
          this.$router.push({ path: `/${this.$route.params.slug}` });
        }
      },
      getPost: function(id) {
        axios
          .get(`/api/posts/${id}`)
          .then(res => {
            this.post = res.data;
            this.post.img = null;
            this.checkAuth();
          })
          .catch(err => console.log(err));
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
      updatePost: function() {
        axios
          .put(`/api/posts/${this.post.id}`, this.post)
          .then(res => {
            this.$router.push({ path: `/${this.$route.params.slug}` });
          })
          .catch(err => console.log(err));
      },
      deletePost: function(id) {
        axios
          .delete(`/api/posts/${id}`)
          .then(res => {
            alert(res.data);
            this.$router.push({ path: `/${this.post.profile.user.nickname}` });
          })
          .catch(err => console.log(err));
      }
    },
    created() {
      this.getPost(this.$route.params.id);
    }
  };
</script>

<style scoped>
textarea {
  resize: none;
}
</style>