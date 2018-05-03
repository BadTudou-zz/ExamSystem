<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑练习</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>练习标题</label>
          <input v-model="practiceData.title" class="input" type="text" >
        </div>
        <div class="box-item">
          <label>类型</label>
          <div class="select">
            <select v-model="practiceData.exam_type">
              <option value="OPEN">开卷</option>
            </select>
          </div>
        </div>
        <div class="box-item">
          <label>描述</label>
          <input v-model="practiceData.describe" class="input" type="text">
        </div>
        <div class="box-item">
          <label>成绩</label>
          <input v-model="practiceData.score" class="input" type="text">
        </div>
        <div class="box-item">
          <label>练习时长(分钟)</label>
          <input v-model="practiceData.min" class="input" type="text">
        </div>
        <div class="box-item">
          <label>开始时间</label>
          <input v-model="practiceData.begin_at" class="input" type="date">
        </div>
        <div class="box-item">
          <label>相关的试卷</label>
          <div>
            <table class="table">
              <thead>
                <tr>
                  <th>是否选中</th>
                  <th>序号</th>
                  <th>名称</th>
                  <th>练习类型</th>
                </tr>
              </thead>
              <tbody class="all-paper">
                <tr v-for="(item,index) in examinationPaperData">
                  <td><input type="radio" v-bind:value="item.id" v-model="selectedExaminationPaper" class="practice-selected"></td>
                  <td>{{ item.id }}</td>
                  <td>{{ item.title }}</td>
                  <td>{{ item.exam_type }}</td>
                </tr>
              </tbody>
            </table>

          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="editPractice()" class="button is-success">确认</button>
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
      practiceData: {
        title: '',
        exam_type: '',
        describe: '',
        score: '',
        min: '',
        begin_at: '',
        paper_id: ''
      },
      examinationPaperData: {},
      selectedExaminationPaper: '',
    }
  },
  components: {
  },
  props: [
    'editData',
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.practiceData.title =  '';
      that.practiceData.exam_type =  '';
      that.practiceData.describe =  '';
      that.practiceData.score =  '';
      that.practiceData.min =  '';
      that.practiceData.begin_at =  '';
      that.practiceData.paper_id =  '';
    },
    editPractice: function (index) {
      const that = this;
      let id = that.editData.id;
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          title: that.practiceData.title,
          exam_type: that.practiceData.exam_type,
          describe: that.practiceData.describe,
          score: that.practiceData.score,
          min: that.practiceData.min,
          begin_at: that.practiceData.begin_at,
          paper_id: that.practiceData.paper_id
        }
      }).then(res => {
        alert('编辑成功');
        that.$emit('getPractice');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.clearWords();
        that.switchModal();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
        // that.clearWords();
      })
    },
    getExaminationPaper: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.examinationPaperData = res.data.data;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  created() {

  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      that.getExaminationPaper();

      that.practiceData.title = value.title;
      that.practiceData.exam_type = value.exam_type;
      that.practiceData.describe = value.describe;
      that.practiceData.score = value.score;
      that.practiceData.min = value.min;
      that.practiceData.begin_at = this.GLOBAL.toTime(value.begin_at);

      that.practiceData.paper_id = value.paper_id;
      that.selectedExaminationPaper = value.paper_id;
    }
  }
}
</script>

<style>
.all-paper {
  width: 20px;
}
</style>
