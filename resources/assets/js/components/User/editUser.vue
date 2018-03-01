<!-- 编辑用户 -->
<!-- ??有哪些数据允许编辑 -->
<template lang="html">
  <div class="modal" v-if="currentUserData"
                     v-bind:class="{'is-active': isShowModal}"
                     >
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modal title</p>
      <button @click="switchModal()" class="delete" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      <div class="label-box">
        <label class="label">ID：</label>
        <input class="input" v-model:id="currentUserData.id" disabled>
      </div>
      <div class="label-box">
        <label class="label">用户名：</label>
        <input class="input" v-model:name="currentUserData.name">
      </div>
      <div class="label-box">
        <label class="label">邮箱：</label>
        <input class="input" v-model:email="currentUserData.email">
      </div>
      <div class="label-box">
        <label class="label">电话：</label>
        <input class="input" v-model:phone="currentUserData.phone">
      </div>
      <div class="label-box">
        <label class="label">QQ：</label>
        <input class="input" v-model:qq="currentUserData.qq">
      </div>
      <div class="label-box">
        <label class="label">Number：</label>
        <input class="input" v-model:number="currentUserData.number" disabled>
      </div>
      <div class="label-box">
        <label class="label">创建时间：</label>
        <input class="input" v-model:create="currentUserData.created_at" disabled>
      </div>
      <div class="label-box">
        <label class="label">更新时间：</label>
        <input class="input" v-model:updated="currentUserData.updated_at" disabled>
      </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success">保存</button>
      <button @click="switchModal()" class="button">取消</button>
    </footer>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      isShowModal: null,
    }
  },
  props: [
    'isShowEditModal',
    'currentUserData',  // 当前需要编辑的用户数据
  ],
  components: {

  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    }
  },
  watch: {
    isShowEditModal: function (value, oldValue) {
      const that = this;
      that.isShowModal = value;
    },
    currentUserData: function (value, oldValue) {
    }
  }
}
</script>

<style lang="css">
label {
  display: inline-block;
  width: 100px;
}
.label {
  display: inline-block;
}
.label-box {
  margin-bottom: 10px;
}
.label-box input {
  width: 300px;
  display: inline-block;
}
</style>
