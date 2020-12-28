<template>
  <div class="chatwith text-center">
    <h1>chat with {{ slug }}</h1>
    <div class="message-box">
      <div class="messages">
        <p
          v-for="(message, idx) in filteredMessages"
          :class="{
            from: message.user_id === auth.id,
            to: message.to === auth.id
          }"
          :key="idx"
        >
          {{ message.text }}
        </p>
      </div>
      <input
        v-model="message.text"
        @keypress.enter="sendMessage"
        class="mess"
        type="text"
      />
    </div>
  </div>
</template>

<script>
  export default {
    name: "ChatWith",
    props: ["auth", "friends"],
    data() {
      return {
        slug: null,
        messages: [],
        filteredMessages: [],
        friendId: null,
        message: {}
      };
    },
    methods: {
      getMessages: function() {
        this.filteredMessages = [];
        axios
          .get(`/api/messages/${this.auth.id}`)
          .then(res => {
            this.messages = res.data;
            this.getProfiles();
          })
          .catch(err => console.log(err));
      },
      getProfiles: function() {
        axios
          .get("/api/profiles")
          .then(res => {
            let profiles = res.data;
            this.friends.forEach(friend => {
              profiles.forEach(profile => {
                if (this.slug === profile.user.nickname) {
                  this.friendId = profile.user_id;
                }
              });
            });
            this.filterMessages();
          })
          .catch(err => console.log(err));
      },
      filterMessages: function() {
        this.messages.forEach(message => {
          if (
            (message.user_id === this.auth.id || message.to === this.auth.id) &&
            (message.user_id === this.friendId || message.to === this.friendId)
          ) {
            this.filteredMessages.push(message);
          }
        });
        this.setMessage();
      },
      setMessage: function() {
        this.message.user_id = this.auth.id;
        this.message.to = this.friendId;
      },
      sendMessage: function() {
        axios
          .post("/api/messages", this.message)
          .then(res => {
            this.getMessages();
          })
          .catch(err => console.log(err));
      }
    },
    created() {
      this.slug = this.$route.params.slug;
      this.getMessages();
    }
  };
</script>

<style scoped>
.message-box {
  display: flex;
  position: relative;
  margin: 10px;
  min-height: 600px;
}

.messages {
  width: 100%;
  overflow-y: scroll;
  background-color: #ccc;
  border: 1px solid darkgray;
  border-radius: 10px;
}

.mess {
  position: absolute;
  bottom: 0;
  width: 100%;
  padding: 5px;
  outline: none;
  border: 1px solid darkgray;
}

.from,
.to {
  text-align: left;
  width: 25%;
  padding: 5px 10px;
  margin: 5px;
  background-color: rgb(39, 174, 219);
  border-radius: 5px;
}

.from {
  margin-right: auto;
}

.to {
  margin-left: auto;
}
</style>