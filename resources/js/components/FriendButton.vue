<template>
  <button @click="addFriend" v-text="buttonText"></button>
</template>

<script>
  export default {
    name: "FollowButton",

    props: ["authID", "userID"],

    data() {
      return {
        status: null,
        buttonText: null
      };
    },

    methods: {
      getStatus: function() {
        axios
          .get(`/api/${this.authID}/status/${this.userID}`)
          .then(res => {
            this.status = res.data;
            this.setButtonText();
          })
          .catch(err => console.log(err));
      },

      addFriend: function() {
        axios
          .post(`/api/${this.authID}/addfriend/${this.userID}`)
          .then(res => {
            this.getStatus();
          })
          .catch(err => console.log(err));
      },

      setButtonText: function() {
        this.buttonText = this.status ? "Remove friend" : "Add friend";
      }
    },

    mounted() {
      this.getStatus();
    }
  };
</script>

<style scoped>
</style>