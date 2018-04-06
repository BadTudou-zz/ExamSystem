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
          <input v-model="teachingData.name" class="input" type="text">
        </div>
        <div class="box-item">
          <label>课程ID</label>
          <input v-model="teachingData.course_id" class="input" type="text">
        </div>
        <div class="box-item">
          <label>最大值</label>
          <input v-model="teachingData.max" class="input" type="text">
        </div>
        <div class="box-item">
          <label>允许组织的ID集合</label>
          <input v-model="teachingData.allowable_organization_ids" class="input" type="text" placeholder="若多个id请用逗号分隔">
        </div>
        <div class="box-item">
          <label>描述</label>
          <input v-model="teachingData.describe" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addTeaching" class="button is-success">确认</button>
        <button @click="switchModal()" class="button">取消</button>
      </footer>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      isShowModal: false,
      teachingData: {
        name: null,
        course_id: null,
        max: null,
        allowable_organization_ids: null,
        describe: null,
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
    clearWords: function () {
      const that = this;
      that.teachingData.name = '';
      that.teachingData.course_id = '';
      that.teachingData.max = '';
      that.teachingData.allowable_organization_ids = '';
      that.teachingData.describe = '';
    },
    addTeaching: function () {
      const that = this;
      let ids = [];
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
        },
        // 优化：检测id是否合法，ids是否是数组
        params: {
          name: that.teachingData.name,
          course_id: that.teachingData.course_id,
          max: that.teachingData.max,
          allowable_organization_ids: that.allowable_organization_ids,  // ?? params not allow send array
          describe: that.teachingData.describe
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getTeaching');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {

  }
}
</script>

<style>
</style>
