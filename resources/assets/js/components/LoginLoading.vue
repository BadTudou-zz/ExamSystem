<template>
  <div class="">

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-content">
        <p class="loading-text">登录中，请稍等</p>
        <p class="loading-text">
          <img class="loading-img" src="./../../img/loading.gif" alt="">
        </p>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      isShowModal: false,
    };
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
  },
  created() {
  },
  watch: {
  }
}
</script>

<style scoped>
.modal-background {
  background-color: rgba(255,255,255,0.6);
}
.loading-text {
  text-align: center;
  margin-bottom: 25px;
}
.loading-img {
  display: inline-block;
  width: 100px;
  height: 100px;
}
</style>
