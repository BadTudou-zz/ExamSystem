<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加角色</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>角色名称</label>
          <input v-model="roleData.name" class="input" type="text" placeholder="请输入英文角色名">
        </div>

        <div class="box-item">
          <label>显示的角色名称</label>
          <input v-model="roleData.display_name" class="input" type="text" placeholder="请输入中文角色名">
        </div>
        <div class="box-item">
          <label>角色描述</label>
          <input v-model="roleData.description" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addRole()" class="button is-success">确认</button>
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
      roleData: {
        name: null,
        display_name: null,
        description: null,
      }
    }
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    addRole: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/roles/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          name: that.roleData.name,
          display_name: that.roleData.display_name,
          description: that.roleData.description,
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getRole');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
        that.roleData.name = '';
        that.roleData.display_name = '';
        that.roleData.description = '';
      }).catch(err => {
        alert('添加失败');
        console.log(err)
        that.roleData.name = '';
        that.roleData.display_name = '';
        that.roleData.description = '';
      })

    }
  },
  created() {

  },
  watch: {
  }
}
</script>

<style>
</style>
