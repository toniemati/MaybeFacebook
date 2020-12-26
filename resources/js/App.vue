<template>
  <div class="app">
    <div v-if="profile">
      <Nav :profile="profile" />
      <div class="row w-100">
        <div v-if="showLeft" class="col-3">leftside</div>
        <div :class="{ 'col-6': showLeft, 'col-9': !showLeft }">
          <router-view
            @profile="showLeftSide"
            :auth="auth"
            @friends="getFriends"
          >
          </router-view>
        </div>
        <div class="col-3">
          <FriendsList :friends="friends" />
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
  import FriendsList from "./components/FriendsList";
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
        showLeft: false,
        friends: null
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
      },

      getFriends: function(friends) {
        this.friends = friends;
      }
    },

    created() {
      this.showLeftSide(false);
      this.getProfile(this.auth.id);
    },

    components: { Nav, FriendsList }
  };
</script>

<style>
</style>