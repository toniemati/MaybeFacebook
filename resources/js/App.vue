<template>
  <div class="app">
    <div v-if="profile">
      <Nav :profile="profile" />
      <div class="row">
        <div v-if="showLeft" class="col-3">leftside</div>
        <div :class="{ 'col-6': showLeft, 'col-9': !showLeft }">
          <router-view @profile="showLeftSide" :auth="auth"></router-view>
        </div>
        <div class="col-3">contacts</div>
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
  import Nav from "./components/Nav";
  export default {
    name: "App",

    props: {
      auth: {
        type: Object,
        required: true
      }
    },

    data() {
      return {
        profile: null,
        showLeft: false
      };
    },

    methods: {
      getProfile: function(id) {
        axios
          .get(`/api/profiles/${this.auth.id}`)
          .then(res => (this.profile = res.data))
          .catch(err => console.log(err));
      },

      showLeftSide: function(arg) {
        this.showLeft = arg;
      }
    },

    created() {
      this.showLeftSide(false);
      this.getProfile(this.auth.id);
    },

    components: { Nav }
  };
</script>

<style>
</style>