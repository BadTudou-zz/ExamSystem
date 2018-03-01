<!-- 编辑用户 -->
<!-- ??有哪些数据允许编辑 -->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modal title</p>
      <button @click="switchModal()" class="delete" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      <div class="label-box">
        <label class="label">ID：</label>
        <input class="input" v-model:id="currentOrganizationData.id" disabled>
      </div>
      <div class="label-box">
        <label class="label">组织名：</label>
        <input class="input" v-model:name="currentOrganizationData.name">
      </div>
      <div class="label-box">
        <label class="label">创建者ID：</label>
        <input class="input" v-model:creator_id="currentOrganizationData.creator_id" disabled>
      </div>
      <div class="label-box">
        <label class="label">描述：</label>
        <input class="input" v-model:="currentOrganizationData.description">
      </div>
      <div class="label-box">
        <label class="label">最大值：</label>
        <input class="input" v-model:max="currentOrganizationData.max">
      </div>
      <div class="label-box">
        <label class="label">当前值：</label>
        <input class="input" v-model:current="currentOrganizationData.current" disabled>
      </div>
      <div class="label-box">
        <label class="label">创建时间：</label>
        <input class="input" v-model:created_at="currentOrganizationData.created_at" disabled>
      </div>
      <div class="label-box">
        <label class="label">更新时间：</label>
        <input class="input" v-model:updated_at="currentOrganizationData.updated_at" disabled>
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
      currentOrganizationData: {
        id: null,
        name: null,
        creator_id: null,
        description: null,
        max: null,
        current: null,
        created_at: null,
        updated_at: null
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
      id = that.currentOrganizationData.id;
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
          // ?? 传入的是String or Number
          name: that.organizationData.name,
          description: that.organizationData.description,
          max: that.organizationData.max,
        }
      }).then(res => {
         
      }).catch(err => {
        console.log(err)
      })
    }
  },
  creatad() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      that.currentOrganizationData = value;
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
