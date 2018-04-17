<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加授课</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="item">
          <label>授课名称</label>
          <input v-model="teachingData.name" class="input text-input" type="text">
        </div>

        <div class="item">
          请选择课程
          <div>
            <table class="table">
              <thead>
                <tr>
                  <th>是否选中</th>
                  <th>课程名称</th>
                  <th>描述</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in courseData">
                  <td><input type="radio" v-bind:value="item.id" v-model="teachingData.course_id" class="is-selected"></td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.descripe }}</td>
                </tr>
              </tbody>
            </table>
            <pagination v-bind:pagination-data="paginationData1"
                        v-model="data1"
            ></pagination>
          </div>
        </div>

        <div class="item">
          <label>最大值</label>
          <input v-model="teachingData.max" class="input number-input" type="number">
        </div>

        <div class="item">
          请选择允许组织
          <div>
            <table class="table">
              <thead>
                <tr>
                  <th>是否选中</th>
                  <th>组织名称</th>
                  <th>描述</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in organizationData">
                  <td><input type="checkbox" v-bind:value="item.id" v-model="teachingData.allowable_organization_ids" class="is-selected"></td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.describe }}</td>
                </tr>
              </tbody>
            </table>
            <pagination v-bind:pagination-data="paginationData2"
                        v-model="data2"
            ></pagination>
          </div>
        </div>

        <div class="item">
          请选择允许的用户
          <div>
            <table class="table">
              <thead>
                <tr>
                  <th>是否选中</th>
                  <th>用户名称</th>
                  <th>描述</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in userData">
                  <td><input type="checkbox" v-bind:value="item.id" v-model="teachingData.allowable_user_ids" class="is-selected"></td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.describe }}</td>
                </tr>
              </tbody>
            </table>
            <pagination v-bind:pagination-data="paginationData3"
                        v-model="data3"
            ></pagination>
          </div>

        </div>
        <div class="item">
          <label>详情描述</label>
          <input v-model="teachingData.describe" class="input text-input" type="text">
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
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      isShowModal: false,
      teachingData: {
        name: null,
        course_id: null,
        max: null,
        allowable_organization_ids: [],
        allowable_user_ids: [],
        describe: null,
      },
      courseData: [],
      organizationData: [],
      userData: [],
      // 翻页
      paginationData1: null,  // course翻页
      data1: null,

      paginationData2: null,  // organizations翻页
      data2: null,

      paginationData3: null,  // users翻页
      data3: null,
      //
    }
  },
  components: {
    Pagination,
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
      that.teachingData.allowable_organization_ids = [];
      that.teachingData.describe = '';
    },
    addTeaching: function () {
      const that = this;
      let allowable_organization_ids = that.teachingData.allowable_organization_ids;
      let allowable_user_ids = that.teachingData.allowable_user_ids;
      if (   !that.teachingData.name
          && !that.teachingData.course_id
          && !that.teachingData.max
          && !allowable_organization_ids
          && !allowable_user_ids
          && !that.teachingData.describe) {
        alert('请将信息填写完整');
        return;
      }
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        // 优化：检测id是否合法，ids是否是数组
        params: {
          name: that.teachingData.name,
          course_id: that.teachingData.course_id,
          max: that.teachingData.max,
          allowable_organization_ids: allowable_organization_ids,
          allowable_user_ids: allowable_user_ids,
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
    },
    getCourse: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/courses`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.courseData = res.data.data;
        that.paginationData1 = res.data.links;
        //
      }).catch(err => {
        console.log(err)
      })
    },
    getOrganization: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.organizationData = res.data.data;
        that.paginationData2 = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    // 全部用户
    getUser: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.userData = res.data.data;
        that.paginationData3 = res.data.links;
      }).catch(err => {
        console.log(err);
      })
    },
  },
  created() {
    // this.getCourse();
    // this.getOrganization();
    // this.getUser();
  },
  watch: {
    data1: function (value, oldValue) {
      const that = this;
      that.courseData = value.data;
      that.paginationData1 = value.links;
    },
    data2: function (value, oldValue) {
      const that = this;
      that.organizationData = value.data;
      that.paginationData2 = value.links;
    },
    data3: function (value, oldValue) {
      const that = this;
      that.userData = value.data;
      that.paginationData3 = value.links;
    },
    isShowModal: function (value, oldVale) {
      const that = this;
      if (value) {
        this.getCourse();
        this.getOrganization();
        this.getUser();
      }
    },
  }
}
</script>

<style scoped>
.is-selected {
  width: 20px;
}
.item {
  margin-bottom: 20px;
}
.number-input {
  width: 100px;
}
.text-input {
  width: 300px;
}
</style>
