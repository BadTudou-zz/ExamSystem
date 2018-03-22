<!-- 编辑用户 -->
<!-- ??有哪些数据允许编辑 -->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">编辑组织</p>
      <button @click="switchModal()" class="delete" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      <!-- <div class="label-box">
        <label class="label">ID：</label>
        <input class="input" v-model:id="currentOrganizationData.id" disabled>
      </div> -->
      <div class="label-box">
        <label class="label">组织名：</label>
        <input class="input" v-model="currentOrganizationData.name">
      </div>
      <!-- <div class="label-box">
        <label class="label">创建者ID：</label>
        <input class="input" v-model:creator_id="currentOrganizationData.creator_id" disabled>
      </div> -->
      <div class="label-box">
        <label class="label">描述：</label>
        <input class="input" v-model="currentOrganizationData.description">
      </div>
      <div class="label-box">
        <label class="label">最大值：</label>
        <input class="input" v-model="currentOrganizationData.max">
      </div>
      <!-- <div class="label-box">
        <label class="label">当前值：</label>
        <input class="input" v-model:current="currentOrganizationData.current" disabled>
      </div> -->
      <!-- <div class="label-box">
        <label class="label">创建时间：</label>
        <input class="input" v-model:created_at="currentOrganizationData.created_at" disabled>
      </div>
      <div class="label-box">
        <label class="label">更新时间：</label>
        <input class="input" v-model:updated_at="currentOrganizationData.updated_at" disabled>
      </div> -->
    </section>
    <footer class="modal-card-foot">
      <button @click="editOrganization()" class="button is-success">确认</button>
      <button @click="switchModal()" class="button">取消</button>
    </footer>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      currentOrganizationData: {
        // id: null,
        name: null,
//         creator_id: null,
        description: null,
        max: null,
//         current: null,
//         created_at: null,
//         updated_at: null
      },
      token: null,
      isShowModal: false,
    }
  },
  props: [
    'editData',
  ],
  components: {

  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    editOrganization: function () {
      const that = this;
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations/${that.currentOrganizationData.id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token,
        },
        params: {
          name: that.currentOrganizationData.name,
          describe: that.currentOrganizationData.describe,
          max: that.currentOrganizationData.max,
        }
      }).then(res => {
        alert('编辑成功');
        that.$emit('getOrganization');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  creatad() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      that.currentOrganizationData.id = value.id;
      that.currentOrganizationData.name = value.name;
      that.currentOrganizationData.describe = value.describe;
      that.currentOrganizationData.max = value.max;
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
