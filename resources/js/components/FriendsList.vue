<template>
  <div class="friendslist mt-3">
    <div
      v-for="(friend, idx) in friendsList"
      :key="idx"
      class="d-flex align-items-center"
    >
      <img
        :src="`img/${friend.profImg}`"
        class="rounded-circle profileImg"
        alt="Profile Image"
      />
      <div class="ml-3">
        <a :href="`/${friend.user.nickname}`">
          {{ friend.user.name }}
        </a>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "FriendsList",
    props: ["friends"],
    data() {
      return {
        friendsList: []
      };
    },
    watch: {
      friends: function() {
        this.getFriends();
      }
    },
    methods: {
      getFriends: function() {
        this.friends.forEach(friend => {
          axios
            .get(`/api/profiles/${friend.user_id}`)
            .then(res => {
              this.friendsList.push(res.data);
              console.log(this.friendsList);
            })
            .catch(err => console.log(err));
        });
      }
    }
  };
</script>

<style scoped>
.profileImg {
  height: 50px;
}
</style>