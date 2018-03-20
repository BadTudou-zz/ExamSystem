<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加组织</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>组织名称</label>
          <input v-model="organizationData.name" class="input" type="text" placeholder="请输入组织名">
        </div>
        <div class="box-item">
          <label>组织描述</label>
          <input v-model="organizationData.describe" class="input" type="text">
        </div>
        <div class="box-item">
          <label>最大值</label>
          <input v-model="organizationData.max" class="input" type="number">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addOrganization()" class="button is-success">确认</button>
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
      organizationData: {
        name: null,  // 组织名称
        describe: null, // 组织描述
        max: null  // 最大值
      },
      token: null,
    }
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
      that.clearWords();
    },
    clearWords: function () {
      const that = this;
      that.organizationData.name = '';
      that.organizationData.describe = '';
      that.organizationData.max = '';
    },
    addOrganization: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token,
        },
        params: {
          name: that.organizationData.name,
          describe: that.organizationData.describe,
          max: that.organizationData.max,
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getOrganization');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
  }
}
</script>

<style>
</style>
