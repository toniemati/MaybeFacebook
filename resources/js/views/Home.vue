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
        posts: [],
        friends: []
      };
    },

    methods: {
      getPosts: function() {
        axios
          .get(`/api/posts`)
          .then(res => {
            this.filterPosts(res.data);
          })
          .catch(err => console.log(err));
      },

      filterPosts: function(posts) {
        posts.forEach(post => {
          console.log(post);
          if (post.profile_id === this.auth.id) {
            this.friends = post.profile.user.friends;
            this.posts.push(post);
          }
          this.friends.forEach(friend => {
            if (post.profile_id === friend.id) {
              console.log("XD");
              this.posts.push(post);
            }
          });
        });
        this.sortPosts();
      },

      sortPosts: function() {
        this.posts.sort((a, b) => {
          return a.created_at > b.created_at ? -1 : 1;
        });
      }
    },

    created() {
      this.$emit("profile", true);
      this.getPosts();
    },

    components: { Post }
  };
</script>

<style>
</style>