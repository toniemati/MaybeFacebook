<template>
  <div class="searchfriends text-center">
    <h1>Szukaj znajomego</h1>
    <div>
      <input
        class="form-control col-3 mx-auto"
        type="text"
        v-model="word"
        @keypress="filterFriends"
      />
    </div>
    <div
      v-for="(profile, idx) in filretedProfiles"
      :key="idx"
      class="d-flex align-items-center m-4"
    >
      <img
        class="profImg rounded-circle"
        :src="`img/${profile.profImg}`"
        alt="Profile Image"
      />
      <div class="h4 mx-4">{{ profile.user.name }}</div>
      <FriendButton
        class="btn btn-outline-info friend"
        :authID="auth.id"
        :userID="profile.id"
      />
    </div>
  </div>
</template>

<script>
  import FriendButton from "../components/FriendButton";
  export default {
    name: "SearchFriends",
    props: ["auth"],
    data() {
      return {
        word: null,
        owner: false,
        profiles: null,
        filretedProfiles: []
      };
    },
    methods: {
      getProfiles: function() {
        axios
          .get("/api/profiles")
          .then(res => {
            this.profiles = res.data;
          })
          .catch(err => console.log(err));
      },
      filterFriends: function() {
        this.filretedProfiles = this.profiles.filter(profile => {
          if (profile.user.nickname.match(this.word)) return true;

          if (profile.user.name.match(this.word)) return true;
        });
      }
    },
    created() {
      this.$emit("profile", false);
      this.getProfiles();
    },
    components: { FriendButton }
  };
</script>

<style scoped>
.profImg {
  height: 100px;
}
</style>