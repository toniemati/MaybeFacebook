<template>
  <div class="home">
    <h1 class="text-center">Home.vue.vue</h1>
    <Post v-for="(post, idx) in posts" :key="idx" :post="post" width="col-12" />
  </div>
</template>

<script>
  import Post from "../components/Post";
  export default {
    name: "Home",

    props: ["auth"],

    data() {
      return {
        posts: []
      };
    },

    methods: {
      getPosts: function(id) {
        axios
          .get(`/api/posts`)
          .then(res => {
            this.filterPosts(res.data);
          })
          .catch(err => console.log(err));
      },

      filterPosts: function(posts) {
        posts.forEach(post => {
          if (post.profile_id === this.auth.id) {
            let friends = post.profile.user.friends;

            posts.forEach(post => {
              friends.forEach(friend => {
                if (post.profile_id === friend.id) {
                  this.posts.push(post);
                  console.log(post);
                }
              });
            });
          }
        });
      }
    },

    created() {
      this.$emit("profile", true);
      this.getPosts(this.auth.id);
    },

    components: { Post }
  };
</script>

<style>
</style>