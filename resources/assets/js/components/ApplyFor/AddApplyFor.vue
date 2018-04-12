<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加申请</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>to</label>
          <input v-model="applyForData.to" class="input" type="text">
        </div>
        <!-- <div class="box-item">
          <label>action</label>
          <input v-model="applyForData.action" class="input" type="text">
        </div> -->
        <div class="box-item">
          <label>资源ID</label>
          <input v-model="applyForData.resource_id" class="input" type="text">
        </div>
        <div class="box-item">
          <label>资源类型</label>
          <input v-model="applyForData.resource_type" class="input" type="text">
        </div>
        <div class="box-item">
          <label>数据</label>
          <input v-model="applyForData.data" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addApplyFor()" class="button is-success">确认</button>
        <button  @click="switchModal()" class="button">取消</button>
      </footer>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      isShowModal: false,
      // ?? The data structure provided by the API documentation is problematic.
      applyForData: {
        to: '',  // ?? 语义
        action: '',  // ??
        resource_id: '',  // ??
        resource_type: '',  // ??
        data: '',  // ??
      },
    }
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.applyForData.to = '';
      that.applyForData.action = '';
      that.applyForData.resource_id = '';
      that.applyForData.resource_type = '';
      that.applyForData.data = '';
    },
    addApplyFor: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        body: {
          to: that.applyForData.to,
          action: 'create',  // ?? 枚举值
          resource_id: that.applyForData.resource_id,
          resource_type: that.applyForData.type,
          data: that.applyForData.data
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getApplyFor');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        console.log(err);
        that.clearWords();
      })
    },
  },
  created() {
  }
}
</script>

<style>
</style>
