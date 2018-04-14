<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加授课</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>授课名称</label>
          <input class="input" type="text" placeholder="请输入授课名">
        </div>

        <div class="box-item">
          <label>授课名称</label>
          <input class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="editTeaching()" class="button is-success">确认</button>
        <button @click="switchModal()" class="button">取消</button>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentTeachingData: {
        name: null,
        max: null,
        allowable_organization_ids: null,
        allowable_user_ids: null,
        describe: null,
      },
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
    editTeaching: function () {
      const that = this;
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/teachings/${that.currentTeachingData.id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          name: that.teachingData.name,
          max: that.teachingData.max,
          allowable_organization_ids: that.teachingData.allowable_organization_ids,
          allowable_user_ids: that.teachingData.allowable_user_ids,
          describe: that.teachingData.describe
        }
      }).then(res => {
        alert('编辑成功');
        that.$emit('getTeaching');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  creatad() {

  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      that.currentTeachingData.id = value.id;
      that.currentTeachingData.name = value.name;
      that.currentTeachingData.describe = value.describe;
      that.currentTeachingData.max = value.max;
    }
  }
}
</script>

<style lang="css">
label {
  display: inline-block;
  width: 100px;
}
</style>
