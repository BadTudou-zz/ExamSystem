<template>

  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content user-content box">

      <webtrc-server></webtrc-server>

    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>
  </div>

</template>

<script>
import webtrcServer from './webrtcServer'
export default {
  data() {
    return {
      token: '',
      isShowModal: false,
      userData: null,
    }
  },
  components: {
    webtrcServer,
  },
  props: [
    'editData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
  },
  created() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
    }
  }
}
</script>

<style scoped>
.booth {
    width:400px;

    background:#ccc;
    border: 10px solid #ddd;
    margin: 0 auto;
}

.user-box {
  width: 1250px;
}
.user-content {
  width: 1300px;
}
</style>
