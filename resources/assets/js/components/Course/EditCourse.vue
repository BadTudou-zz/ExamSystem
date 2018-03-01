<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑课程</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>课程名称</label>
          <input v-model="courseData.name" class="input" type="text" placeholder="请输入课程名">
        </div>
        <div class="box-item">
          <label>显示名称</label>
          <input v-model="courseData.display_name" class="input" type="text" placeholder="请输入课程名">
        </div>
        <div class="box-item">
          <label>显示描述</label>
          <input v-model="courseData.description" class="input" type="text" placeholder="请输入课程名">
        </div>
        <div class="box-item">
          <label>数量</label>
          <input v-model="courseData.number" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addCourse()" class="button is-success">确认</button>
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
      courseData: {
        name: null,
        display_name: null,
        description: null,
        number: null,
      },
      token: null,
      permissionId: null,
    }
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    // 添加成员
    addCourse: function () {
      const that = this;
      that.courseData.max = Number(that.courseData.max);
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/courses`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
          name: that.courseData.name,
          display_name: that.courseData.display_name,
          description: that.courseData.description,
          number: that.courseData.number
        }
      }).then(res => {
      }).catch(err => {
        console.log(err)
      })
    },
  },
  created() {
    this.token = sessionStorage.getItem('token');
  }
}
</script>

<style>
</style>
