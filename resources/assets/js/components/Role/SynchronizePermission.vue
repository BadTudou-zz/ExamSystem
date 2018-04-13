<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">同步权限</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <div class="all-permission">
            <table class="table">
              <thead>
                <tr>
                  <th>是否选中</th>
                  <th>序号</th>
                  <th>名称</th>
                  <th>别名</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in permissionData">
                  <td><input type="checkbox" v-bind:value="item.id" v-model="selectedPermission" class="permission-seleted"></td>
                  <td>{{ item.id }}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.description }}</td>
                </tr>
              </tbody>
            </table>
            <pagination v-bind:pagination-data="paginationData"
                        v-model="data"
            ></pagination>
          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="synchronousPermission()" class="button is-success">确认</button>
        <button  @click="switchModal()" class="button">取消</button>
      </footer>
    </div>

  </div>
</template>

<script>
import Pagination from './../Pagination.vue'
export default {
  data() {
    return {
      isShowModal: false,
      selectedPermission: [],
      permissionData: [],
      // 翻页
      paginationData: null,
      data: null,
      //
    }
  },
  components: {
    Pagination,
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
      that.selectedPermission = [];
    },
    /**
     * computedParams
     * @param  {Array} selectedQuesiton   选中的数组
     * @param  {String} param param拼接参数
     * @return {String}       拼接完成的params
     */
    computedParams: function (selectedQuesiton, param) {
      let arr = selectedQuesiton;
      let string = '';
      for (let i = 0; i < arr.length; i++) {
        if (i != 0) {
          string += '&' + param + '[' + i + ']' + '=' + arr[i];
        }
        else {
          string += param + '[' + i + ']' + '=' + arr[i];
        }
      }
      return string;
    },
    synchronousPermission: function () {
      const that = this;
      let id = that.roleId;
      let params = that.computedParams(that.selectedPermission, 'permissions');
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/roles/${id}/permissions?${params}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
      }).then(res => {
        alert('同步成功');
        that.$emit('getPermission');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
        that.clearWords();
      }).catch(err => {
        alert('同步失败');
        console.log(err);
        that.clearWords();
      })
    },
    getPermission: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/permissions/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.permissionData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  created() {
    this.clearWords();
    this.getPermission();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.permissionData = value.data;
      that.paginationData = value.links;
    },
    selectedPermission: function(value, oldValue) {
      const that = this;
      console.log(value)
    }
  }
}
</script>


<style scoped>
.permission-seleted {
  width: 20px;
}
</style>
