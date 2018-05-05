<template>

  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content user-content box">
      <div class="booth">

          <video id="video" width="400" height="300"></video>
          <canvas id='canvas' width='400' height='300'></canvas>
          <img id='img' src=''>
      </div>

    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>
  </div>

</template>

<script>

export default {
  data() {
    return {
      token: '',
      isShowModal: false,
      userData: null,
    }
  },
  components: {
  },
  props: [
    'editData'
  ],
  methods: {
  },
  created() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    isShowModal: function (value, oldValue) {
      const that = this;
      if (value) {
        that.getUser();
      }
    },
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
