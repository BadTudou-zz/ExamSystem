<!-- 查看申请 -->
<template lang="html">
  <div class="box">
    <table class="table">
      <thead>
        <tr>
          <th>from</th>
          <th>to</th>
          <th>action</th>
          <th>resource_id</th>
          <th>resource_type</th>
          <th>申请数据</th>
          <th>创建时间</th>
          <th>更新时间</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in applyForData">
          <td>{{ item.from }}</td>
          <td>{{ item.to }}</td>
          <td>{{ item.action }}</td>
          <td>{{ item.resource_id }}</td>
          <td>{{ item.resource_type }}</td>
          <td>{{ item.data }}</td>
          <td>{{ item.created_at.date }}</td>
          <td>{{ item.updated_at.date }}</td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加申请</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>申请名称</label>
            <input class="input" type="text" placeholder="请输入申请名">
          </div>

          <div class="box-item">
            <label>申请名称</label>
            <input class="input" type="text">
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success">确认</button>
          <button  @click="showModal()" class="button">取消</button>
        </footer>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      "applyForData": [
        {
            "id": "6e386941-0b81-4820-b323-154b95f68414",
            "from": "2",
            "to": "1",
            "action": "create",
            "resource_id": "1",
            "resource_type": "Organization",
            "data": "请求加入组织1",
            "created_at": {
                "date": "2018-01-28 08:05:27.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2018-01-28 08:05:27.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
    ],
      isShowModal: false,
      // applyForData: null,
      token: null,
    }
  },
  components: {
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getApplyFor: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/1/applications?reveived=true`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.applyForData = res.data.data;
      }).catch(err => {
        console.log(err)
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    // this.getApplyFor();
  },
  watch: {
  }
}
</script>

<style lang="scss">
table {
  margin: 35px auto 0 auto;
}
.search-input {
  width: 200px;
  display: inline-block;
  margin-right: 10px;
}
.search-box {
  padding-right: 20px;
  display: inline-block;
  border-right: 1px solid #dedede;
}
.add-role-button {
  margin-left: 20px;
}
.box-item {
  margin-bottom: 20px;
  input  {
    display: inline-block;
    width: 300px;
  }
  label {
    display: inline-block;
    width: 130px;
  }
}
</style>
