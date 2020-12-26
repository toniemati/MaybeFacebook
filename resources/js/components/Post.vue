<template>
  <div class="card mx-auto p-2 mt-3" :class="width">
    <div v-if="post.profile" class="mb-2 d-flex align-items-center">
      <img
        :src="`img/${post.profile.profImg}`"
        class="rounded-circle mr-3 profileImg"
        alt="profile img"
      />
      <div>
        <router-link :to="`/${post.profile.user.nickname}`">
          {{ post.profile.user.name }}
        </router-link>
      </div>
    </div>
    <img
      v-if="post.img"
      class="card-img-top"
      :src="`img/${post.img}`"
      alt="Post image"
    />
    <div class="card-body">
      <p class="card-text">
        {{ post.description }}
      </p>
      <div v-if="owner">
        <router-link
          :to="`/${slug}/post/${post.id}`"
          class="btn btn-sm btn-secondary"
        >
          Edytuj
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "Post",
    props: ["post", "owner", "slug", "width"]
  };
</script>

<style scoped>
.profileImg {
  height: 50px;
}
</style>