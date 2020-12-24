<template>
  <div class="profile">
    <div v-if="profile">
      <div class="p-2">
        <div
          class="background position-relative rounded"
          :style="`background-image: url('img/${profile.bgImg}')`"
        >
          <img
            class="rounded-circle profileImg"
            height="150px"
            :src="`img/${profile.profImg}`"
            alt="profImage"
          />
          <FriendButton
            v-if="!owner"
            class="btn btn-outline-info friend"
            :authID="auth.id"
            :userID="profile.id"
          />
        </div>
        <div class="col-6 mx-auto text-center mt-5">
          <p>{{ profile.description }}</p>
        </div>
        <hr />
        <div>
          <div class="text-center" v-if="owner">
            <router-link
              class="btn btn-outline-primary"
              :to="`/addpost/${profile.id}`"
            >
              Dodaj nowy post
            </router-link>
          </div>
          <div class="text-center" v-else>
            <h4>Posty {{ profile.user.name }}</h4>
          </div>
          <div v-if="profile.posts.length">
            <Post
              v-for="(post, idx) in descPosts"
              :key="idx"
              :post="post"
              :owner="owner"
              :slug="slug"
            />
          </div>
          <div class="text-center mt-5" v-else>
            <h3>{{ profile.user.name }} nie posiada jeszcze żadnych postów.</h3>
          </div>
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
  import FriendButton from "../../components/FriendButton";
  import Post from "../../components/Post";
  export default {
    name: "Profile",

    props: ["auth"],

    data() {
      return {
        profile: null,
        descPosts: null,
        slug: null,
        owner: false
      };
    },

    methods: {
      getProfiles: function(slug) {
        axios
          .get("/api/profiles")
          .then(res => {
            let profiles = res.data;
            profiles.forEach(profil => {
              if (profil.user.name == slug) {
                this.getProfile(profil.id);
              }
            });
          })
          .catch(err => console.log(err));
      },

      getProfile: function(id) {
        axios
          .get(`/api/profiles/${id}`)
          .then(res => {
            this.profile = res.data;
            this.checkAuth();
            this.sortPosts();
          })
          .catch(err => console.log(err));
      },

      checkAuth: function() {
        if (this.profile.user.id === this.auth.id) {
          this.owner = true;
        }
      },

      sortPosts: function() {
        this.descPosts = this.profile.posts;
        this.descPosts.sort();
        this.descPosts.reverse();
      }
    },

    created() {
      this.getProfiles(this.$route.params.slug);
      this.$emit("profile", false);
      this.slug = this.$route.params.slug;
    },

    components: { Post, FriendButton }
  };
</script>

<style scoped>
.background {
  height: 400px;
  width: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.profileImg {
  position: absolute;
  bottom: -10%;
  left: 50%;
  transform: translateX(-50%);
  box-shadow: 10px 10px 50px 3px #666;
}

.friend {
  position: absolute;
  right: 0;
  bottom: 0;
  margin: 10px;
}
</style>