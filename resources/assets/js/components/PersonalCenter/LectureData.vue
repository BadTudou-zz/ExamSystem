<!-- 查看选课 -->
<template lang="html">
  <div class="box">
    <h3 class="title">选课</h3>
    <table class="table">
      <thead>
        <tr>
          <th>id</th>
          <th>名称</th>
          <th>用户ID</th>
          <th>课程ID</th>
          <th>允许的组织ID</th>
          <th>允许的用户ID</th>
          <th>描述</th>
          <th>最大值容量</th>
          <th>当前容量</th>
          <th>创建时间</th>
          <th>更新时间</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in currentLectureData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.user_id }}</td>
          <td>{{ item.course_id }}</td>
          <td>{{ item.allowable_organization_ids }}</td>
          <td>{{ item.allowable_user_ids }}</td>
          <td>{{ item.describe }}</td>
          <td>{{ item.max }}</td>
          <td>{{ item.current }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
        </tr>
      </tbody>
    </table>

    <pagination v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>
  </div>
</template>

<script>
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      lectureData: null,
//       currentLectureData: {
//         id: '',
//         name: '',
//         user_id: '',
//         course_id: '',
//         allowable_organization_ids: '',
//         allowable_user_ids: '',
//         describe: '',
//         max: '',
//         current: '',
//         created_at: '',
//         updated_at: '',
//       },
      currentLectureData: null,
      isShowEditModal: false,
      editData: null,
      paginationData: null,
      data: null,
    }
  },
  components: {
    Pagination,
  },
  methods: {
    // 全部选课
    getLecture: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${this.GLOBAL.userId}/lectures/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
        }
      }).then(res => {
        that.lectureData = res.data.data;
        that.paginationData = res.data.links;

        that.currentLectureData.id = that.res.data.data.id;
        that.currentLectureData.name = that.res.data.data.name;
        that.currentLectureData.user_id = that.res.data.data.user_id;
        that.currentLectureData.course_id = that.res.data.data.course_id;
        that.currentLectureData.allowable_organization_ids = that.res.data.data.allowable_organization_ids;
        that.currentLectureData.allowable_user_ids = that.res.data.data.allowable_user_ids;
        that.currentLectureData.describe = that.res.data.data.describe;
        that.currentLectureData.max = that.res.data.data.max;
        that.currentLectureData.current = that.res.data.data.current;
        that.currentLectureData.created_at = that.res.data.data.created_at;
        that.currentLectureData.updated_at = that.res.data.data.updated_at;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  computed: {
  },
  created() {
    this.getLecture();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.lectureData = value.data;
      that.paginationData = value.links;
    }
  }
}
</script>

<style lang="css">
label {
  display: inline-block;
  width: 100px;
}
.label {
  display: inline-block;
}
.label-box {
  margin-bottom: 10px;
  height: 36px;
  line-height: 36px;
}
.title {
  color: #363636;
  font-size: 1.5rem;
  font-weight: 600;
  line-height: 1.125;
}
</style>
