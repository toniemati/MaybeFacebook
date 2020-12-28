<template>
  <div class="chatwith text-center">
    <h1>chat with {{ slug }}</h1>
    <div class="message-box">
      <div class="messages" ref="feed">
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
        placeholder="Nowa wiadomość do ziomeczka..."
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
        axios
          .get(`/api/messages/${this.auth.id}`)
          .then(res => {
            this.messages = res.data;
            this.getProfiles();
            this.scrollToBottom();
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
        this.filteredMessages = [];
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
        this.message.text = "";
      },
      sendMessage: function() {
        if (this.message.text.length) {
          axios
            .post("/api/messages", this.message)
            .then(res => {
              this.message.text = "";
              this.filteredMessages.push(res.data);
            })
            .catch(err => console.log(err));
        }
      },
      scrollToBottom: function() {
        setTimeout(() => {
          this.$refs.feed.scrollTop =
            this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
        }, 50);
      },
      handleIncoming: function() {
        this.getMessages();
      }
    },
    watch: {
      filteredMessages: function() {
        this.scrollToBottom();
      }
    },
    created() {
      this.slug = this.$route.params.slug;
      this.getMessages();
    },
    mounted() {
      Echo.private(`messages.${this.auth.id}`).listen("NewMessage", e => {
        this.handleIncoming();
      });
    }
  };
</script>

<style scoped>
.message-box {
  display: flex;
  position: relative;
  margin: 10px;
  height: 600px;
}

.messages {
  width: 100%;
  overflow-y: scroll;
  background-color: #ddd;
  border: 1px solid #777;
  border-radius: 10px 10px 0 0;
}

.mess {
  position: absolute;
  bottom: 0;
  transform: translateY(100%);
  width: 100%;
  padding: 5px;
  outline: none;
  border-top: 0;
  border: 1px solid #777;
}

.from,
.to {
  text-align: left;
  width: 25%;
  padding: 5px 10px;
  margin: 5px;
  border-radius: 5px;
  font-weight: bold;
}

.from {
  margin-right: auto;
  background-color: rgb(226, 155, 23);
}

.to {
  margin-left: auto;
  background-color: rgb(32, 156, 206);
}
</style>