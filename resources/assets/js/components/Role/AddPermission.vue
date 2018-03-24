<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加权限</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>permissions</label>
          <input v-model="permissionString" class="input" type="text" placeholder="请用英文逗号将多个权限id分开">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addPermission()" class="button is-success">确认添加</button>
        <button  @click="switchModal()" class="button">取消</button>
      </footer>
    </div>

  </div>
</template>
<script>
export default {
  data() {
    return {
      token: null,
      isShowModal: false,
      permissionString: null,
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
      that.permissionString = '';
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
    addPermission: function () {
      const that = this;
      let id = that.roleId;
      let params = that.computedParams(that.permissionString, 'permissions');
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/roles/${id}/permissions?${params}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token,
        },
        // params: {
        // }
      }).then(res => {
        alert('添加成功');
        that.$emit('getPermission');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
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
    this.token = sessionStorage.getItem('token');
  },
  watch: {
  }
}
</script>


<style>
</style>
