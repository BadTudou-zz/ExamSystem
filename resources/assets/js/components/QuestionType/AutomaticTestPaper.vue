<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">自动生成试卷</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>题目类型</label>
          <div class="select">
            <select v-model="type_id">
              <option value=1>单选</option>
              <option value=2>多选</option>
              <option value=3>判断</option>
              <option value=4>填空</option>
              <option value=5>简答</option>
            </select>
          </div>
        </div>

        <div class="box-item">
          <label>题目数量</label>
          <input v-model="number" class="input" type="number" >
        </div>

        <div class="box-item">
          <label>每道题的分数</label>
          <input v-model="score" class="input" type="number">
        </div>

      </section>
     <footer class="modal-card-foot">
        <button @click="automaticTestPaper()" class="button is-success">确认</button>
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
      number: '',
      score: '',
      type_id: '',
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
      that.number = '';
      that.score = '';
      that.type_id = '';
    },
    automaticTestPaper: function () {
      const that = this;

      if (!that.number || !that.score || !that.type_id) {
        alert('请检查内容是否填写完整');
        return;
      }

      // {
      //     "题目类型ID": {
      //         "number":"题目数量",
      //         "score":"每道题的分数"
      //     }
      // }

      let id = that.type_id;
      let json = {};
      json[that.type_id] = {
                            'number': this.number,
                            'score': this.score
                          }

      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/1/maker`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          number: this.number,
          types: json
        }
      }).then(res => {
        alert('生成成功');
        that.$emit('getQuestionType');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.clearWords();
        that.switchModal();
      }).catch(err => {
        alert('生成失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {

  },
  watch: {
  }
}
</script>


<style scoped>
</style>
