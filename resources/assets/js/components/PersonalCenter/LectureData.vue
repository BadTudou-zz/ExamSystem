<!-- 查看选课 -->
<template lang="html">
  <div class="box">
    <h3 class="title">消息</h3>

    <div  v-for="(item,index) in messageData" class="message box">
      <div class="notification">
        {{ item.data}}
        <p>{{item.created_at}}</p>
      </div>
    </div>

    <pagination v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>

  </div>
</template>

<script>
export default {
  data() {
    return {
      token: '',
      userId: null,
      lectureData: null,
//
//       "id": 1,
//             "name": "1班的英语",
//             "user_id": "1",
//             "course_id": "1",
//             "allowable_organization_ids": "",
//             "allowable_user_ids": "",
//             "describe": "这是描述",
//             "max": "20",
//             "current": "1",
//             "created_at": "2018-01-19 18:44:54",
//             "updated_at": "2018-01-19 18:44:54",
//             "pivot": {
//                 "user_id": "1",
//                 "lecture_id": "1"
//             }

      currentLectureData: {
        id: '',
        name: '',
        notifiable_id: '',
        notifiable_type: '',
        data: '',
        read_at: '',
        created_at: '',
        updated_at: ''
      },
      isShowEditModal: false,
      editData: null,
    }
  },
  components: {
  },
  methods: {
    // 全部选课
    getLecture: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${that.userId}/lectures/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.lectureData = res.data.data;

        that.currentLectureData.id = res.data.data.id;
        that.currentLectureData.type = res.data.data.type;
        that.currentLectureData.notifiable_id = res.data.data.notifiable_id;
        that.currentLectureData.notifiable_type = res.data.data.notifiable_type;
        that.currentLectureData.data = res.data.data.data;
        that.currentLectureData.read_at = res.data.data.read_at;
        that.currentLectureData.created_at = res.data.data.created_at;
        that.currentLectureData.updated_at = res.data.data.updated_at;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  computed: {
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.userId = sessionStorage.getItem('userId');
    this.getLecture();
  },
  watch: {
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
