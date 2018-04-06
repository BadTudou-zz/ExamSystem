<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加用户</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>users</label>
          <input v-model="userString" class="input" type="text" placeholder="请用英文逗号将多个用户id分开">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addUser()" class="button is-success">确认添加</button>
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
      userString: null,
    }
  },
  components: {
  },
  props:[
    'roleId'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
      that.clearWords();
    },
    clearWords: function () {
      const that = this;
      that.userString = '';
    },
    /**
     * computedParams
     * @param  {String} str   需要转换的字符串
     * @param  {String} param param拼接参数
     * @return {String}       拼接完成的params
     */
    computedParams: function (str, param) {
      let arr = str.split(',');
      let string = '';
      for (let i = 0; i < arr.length; i++) {
        if (i != 0) {
          string += '&' + param + '=' + arr[i];
        }
        else {
          string += param + '=' + arr[i];
        }
      }
      return string;
    },
    addUser: function () {
      const that = this;
      let id = that.roleId;
      let params = that.computedParams(that.userString, 'users');
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/roles/${id}/users?${params}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
        },
        // params: {
        // }
      }).then(res => {
        alert('添加成功');
        that.$emit('getUser');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
        that.clearWords();
      }).catch(err => {
        alert('添加失败');
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


<style>
</style>
