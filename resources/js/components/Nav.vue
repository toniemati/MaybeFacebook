<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <router-link class="navbar-brand" :to="{ name: 'Home' }">
      <img src="img/unnamed.png" height="40" alt="logo" />
    </router-link>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <form class="form-inline my-2 my-lg-0">
          <input
            class="form-control mr-sm-2 rounded"
            type="search"
            placeholder="Search friends"
            aria-label="Search"
          />
        </form>
      </ul>
      <ul class="navbar-nav ml-auto text-center">
        <li class="nav-item dropdown rounded bg-light mx-1">
          <router-link
            class="nav-link dropdown-toggle text-dark"
            to="#"
            id="navbarDropdown"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{ profile.user.name }}
          </router-link>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <router-link class="dropdown-item" :to="`/${profile.user.name}`"
              >Zobacz swój profil
            </router-link>
            <router-link class="dropdown-item" :to="`/settings/${profile.id}`">
              Ustawienia
            </router-link>
            <div class="dropdown-divider"></div>
            <button class="dropdown-item" @click="logout" to="#">
              Wyloguj
            </button>
          </div>
        </li>
        <li class="nav-item rounded bg-light mx-1">
          <router-link class="nav-link" to="#">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              fill="currentColor"
              class="bi bi-chat-dots-fill text-dark"
              viewBox="0 0 16 16"
            >
              <path
                fill-rule="evenodd"
                d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"
              />
            </svg>
          </router-link>
        </li>
        <li class="nav-item rounded bg-light mx-1">
          <router-link class="nav-link" to="#">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              fill="currentColor"
              class="bi bi-bell-fill text-dark"
              viewBox="0 0 16 16"
            >
              <path
                d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"
              />
            </svg>
          </router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
  export default {
    name: "Nav",

    props: ["profile"],

    methods: {
      logout: function() {
        axios.post("/logout").then(res => {
          window.location.reload();
        });
      }
    }
  };
</script>

<style>
</style>