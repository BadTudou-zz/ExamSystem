<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">角色详情</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
          <thead>
            <tr>
              <th></th>
              <th>详情</th>
            </tr>
          </thead>
        <tbody v-if="roleData">
            <tr>
              <td>用户名</td>
              <td>{{ roleData.name }}</td>
            </tr>
            <tr>
              <td>角色名</td>
              <td>{{ roleData.display_name }}</td>
            </tr>
            <tr>
              <td>描述</td>
              <td>{{ roleData.description }}</td>
            </tr>
            <tr>
              <td>创建时间</td>
              <td>{{ GLOBAL.toTime(roleData.created_at) }}</td>
            </tr>

          </tbody>
        </table>
      </section>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      isShowModal: false,
      roleData: null,
    }
  },
  components: {
  },
  props: [
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getRole: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${sessionStorage.getItem('userId')}/roles/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.roleData = res.data.data[0];
      }).catch(err => {
        console.log(err)
      })
    },
  },
  created() {
  },
  watch: {
    isShowModal: function (value, oldValue) {
      const that = this;
      if (value) {
        that.getRole();
      }
    }
  }
}
</script>

<style scoped>
</style>
