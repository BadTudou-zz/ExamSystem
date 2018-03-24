<!-- 查看消息 -->
<template lang="html">
  <div>
    <div>
      <h3 class="title">消息</h3>
      <div class="label-box">
        <label class="label">ID：</label>
        <span>{{ currentMessageData.id }}</span>
      </div>
      <div class="label-box">
        <label class="label">来源：</label>
        <span>{{ currentMessageData.from }}</span>
      </div>
      <div class="label-box">
        <label class="label">发送给：</label>
        <span>{{ currentMessageData.to }}</span>
      </div>
      <div class="label-box">
        <label class="label">消息内容：</label>
        <span>{{ currentMessageData.data }}</span>
      </div>
      <div class="label-box">
        <label class="label">创建时间：</label>
        <span>{{ currentMessageData.created_at }}</span>
      </div>
      <div class="label-box">
        <label class="label">更新时间：</label>
        <span>{{ currentMessageData.updated_at }}</span>
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
      messageData: null,
      currentMessageData: {
        id: '',
        from: '',
        to: '',
        data: '',
        created_at: '',
        updated_at: '',
      },
      isShowEditModal: false,
      editData: null,
    }
  },
  components: {
  },
  methods: {
    // 全部消息
    getMessage: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${that.userId}/messages/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.messageData = res.data.data;

        that.currentMessageData.id = res.data.data.id;
        that.currentMessageData.from = res.data.data.from;
        that.currentMessageData.to = res.data.data.to;
        that.currentMessageData.data = res.data.data.data;
        that.currentMessageData.created_at = res.data.data.created_at.date;
        that.currentMessageData.updated_at = res.data.data.updated_at.date;
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
    this.getMessage();
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
