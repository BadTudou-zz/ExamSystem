<!-- 查看通知 -->
<template lang="html">
  <div>
    <div>
      <h3 class="title">通知</h3>
      <div class="label-box">
        <label class="label">ID：</label>
        <span>{{ currentNoticeData.id }}</span>
      </div>
      <div class="label-box">
        <label class="label">类型：</label>
        <span>{{ currentNoticeData.type }}</span>
      </div>
      <div class="label-box">
        <label class="label">通知ID：</label>
        <span>{{ currentNoticeData.notifiable_id }}</span>
      </div>
      <div class="label-box">
        <label class="label">通知类型：</label>
        <span>{{ currentNoticeData.notifiable_type }}</span>
      </div>
      <div class="label-box">
        <label class="label">通知内容</label>
        <span>{{ currentNoticeData.data }}</span>
      </div>
      <div class="label-box">
        <!-- ?? means -->
        <label class="label">read_at：</label>
        <span>{{ currentNoticeData.read_at }}</span>
      </div>
      <div class="label-box">
        <label class="label">创建时间：</label>
        <span>{{ currentNoticeData.created_at }}</span>
      </div>
      <div class="label-box">
        <label class="label">更新时间：</label>
        <span>{{ currentNoticeData.updated_at }}</span>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      token: '',
      userId: null,
      noticeData: null,
      currentNoticeData: {
        id: '',
        type: '',
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
    // 全部通知
    getNotice: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${that.uerId}/notifications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.noticeData = res.data.data;

        that.currentNoticeData.id = res.data.data.id;
        that.currentNoticeData.type = res.data.data.type;
        that.currentNoticeData.notifiable_id = res.data.data.notifiable_id;
        that.currentNoticeData.notifiable_type = res.data.data.notifiable_type;
        that.currentNoticeData.data = res.data.data.data;
        that.currentNoticeData.read_at = res.data.data.read_at;
        that.currentNoticeData.created_at = res.data.data.created_at;
        that.currentNoticeData.updated_at = res.data.data.updated_at;
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
    this.getNotice();
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
