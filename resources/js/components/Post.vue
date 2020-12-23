<template>
  <div class="card col-8 mx-auto p-2 mt-3">
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
    props: ["post", "owner", "slug"]
  };
</script>

<style>
</style>