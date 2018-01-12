<!-- 教师注册组件 -->
<template lang="html">
  <div class="">
    <!-- register -->
    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background is-actice"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">教师账号注册</p>
          <button class="delete" aria-label="close"  @click="switchModal()"></button>
        </header>
        <section class="modal-card-body">
          <div class="item-box">
            <span>工号</span>
            <input class="input" type="text" name="" value="">
          </div>
          <div class="item-box">
            <span>密码</span>
            <input class="input" type="text" name="" value="">
          </div>
          <div class="item-box">
            <span>姓名</span>
            <input class="input" type="text" name="" value="">
          </div>
          <div class="item-box">
            <span>电话</span>
            <input class="input" type="text" name="" value="">
          </div>
          <div class="item-box">
            <span>邮箱</span>
            <input class="input" type="text" name="" value="">
          </div>
          <div class="item-box">
            <span>QQ</span>
            <input class="input" type="text" name="" value="">
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success">确认创建</button>
          <button class="button" @click="switchModal()">取消</button>
        </footer>
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
    }
  },
  watch: {

  }
}
</script>

<style lang="scss">
.item-box {
  margin-bottom: 20px;
  input {
    display: inline-block;
    width: 300px;
  }
  span {
    display: inline-block;
    width: 80px;
    margin-right: 20px;
  }
}
</style>
