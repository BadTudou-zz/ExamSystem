<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加课程</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>课程名称</label>
          <input v-model="courseData.name" class="input" type="text" placeholder="请输入英文名">
        </div>
        <div class="box-item">
          <label>显示名称</label>
          <input v-model="courseData.display_name" class="input" type="text" placeholder="请输入中文名">
        </div>
        <div class="box-item">
          <label>显示描述</label>
          <input v-model="courseData.descripe" class="input" type="text" placeholder="请输入课程名">
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
        descripe: null,
        number: null,
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
      that.courseData.name = '';
      that.courseData.display_name = '';
      that.courseData.descripe = '';
      that.courseData.number = '';
    },
    addCourse: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/courses`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          name: that.courseData.name,
          display_name: that.courseData.display_name,
          descripe: that.courseData.descripe,
          number: that.courseData.number
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getCourse');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
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
