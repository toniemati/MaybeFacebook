<template>
  <div class="chat text-center">
    <h1>Messenger</h1>
    <div class="friends">
      <div
        v-for="(profile, idx) in profiles"
        :key="idx"
        class="d-flex align-items-center m-4"
      >
        <img
          class="profImg rounded-circle"
          :src="`img/${profile.profImg}`"
          alt="Profile Image"
        />
        <div class="h4 mx-4">{{ profile.user.name }}</div>
        <div class="ml-5">
          <router-link
            :to="`/chat/${profile.user.nickname}`"
            class="btn btn-outline-success"
            >Zobacz wiadomosci</router-link
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "Chat",
    props: ["auth", "friends"],
    data() {
      return {
        profiles: []
      };
    },
    methods: {
      getProfiles: function() {
        axios
          .get("/api/profiles")
          .then(res => {
            let profiles = res.data;
            this.friends.forEach(friend => {
              profiles.forEach(profil => {
                if (profil.user_id === friend.user_id) {
                  this.profiles.push(profil);
                }
              });
            });
          })
          .catch(err => console.log(err));
      }
    },
    created() {
      this.getProfiles();
    },
    mounted() {
      this.$emit("profile", false);
    }
  };
</script>

<style scoped>
.profImg {
  height: 100px;
}
</style>