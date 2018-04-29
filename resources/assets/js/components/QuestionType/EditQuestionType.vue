<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑题目</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>名称</label>
          <input v-model="questionTypeData.name" class="input" type="text" placeholder="请输入英文名称">
        </div>

        <div class="box-item">
          <label>显示名称</label>
          <input v-model="questionTypeData.title" class="input" type="text" placeholder="请输入中文名称">
        </div>

        <div class="box-item">
          <label>分隔符</label>
          <input v-model="questionTypeData.delimiter" class="input" type="text">
        </div>

        <div class="box-item">
          <label>是否允许多选</label>
          <div class="select">
            <select v-model="questionTypeData.level_type">
              <option value="false">禁止</option>
              <option value="true">允许</option>
            </select>
          </div>
        </div>

      </section>
     <footer class="modal-card-foot">
        <button @click="editQuestionType()" class="button is-success">确认</button>
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
      questionTypeData: {
        name: '',
        title: '',
        delimite: '',
        is_multiple_choice: '',
      },
    }
  },
  components: {
  },
  props: [
    'editData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.questionTypeData.name = '';
      that.questionTypeData.title = '';
      that.questionTypeData.delimite = '';
      that.questionTypeData.is_multiple_choice = '';

    },
    editQuestionType: function () {
      const that = this;

      if (!that.questionTypeData.name || !that.questionTypeData.title || !that.questionTypeData.delimiter || !that.questionTypeData.is_multiple_choice)
      {
        alert('请检查内容是否填写完整');
        return;
      }

      axios({
        method: 'patch',
        url: `${this.GLOBAL.localDomain}/api/v1/questionTypes/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          name: that.questionTypeData.name,
          title: that.questionTypeData.title,
          delimiter: that.questionTypeData.delimiter,
          answer: that.questionTypeData.answer,
          is_multiple_choice: that.questionTypeData.is_multiple_choice,
        }
      }).then(res => {
        alert('编辑成功');
        that.$emit('getQuestionType');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.clearWords();
        that.switchModal();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {

  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      that.questionTypeData.name = value.name;
      that.questionTypeData.title = value.title;
      that.questionTypeData.delimiter = value.delimiter;
      that.questionTypeData.is_multiple_choice = value.is_multiple_choice;
    }
  }
}
</script>


<style scoped>
</style>
