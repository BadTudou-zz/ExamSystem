<!-- 查看用户 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的用户">
        <button class="button" type="button" name="button">查找用户</button>
      </div>
        <button @click="showModal()" class="button add-role-button" type="button" name="button">添加用户</button>
        <button class="button add-role-button" type="button" name="button">同步用户</button>
    </div>
    <div class="box user">
      <div class="notification">
        <button class="delete"></button>
        Lorem ipsum dolor sit amet, consectetur
        adipiscing elit lorem ipsum dolor. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida purus diam, et dictum <a>felis venenatis</a> efficitur. Sit amet,
        consectetur adipiscing elit
        <p>2018-01-05</p>
      </div>
    </div>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加用户</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>用户名称</label>
            <input class="input" type="text" placeholder="请输入用户名">
          </div>

          <div class="box-item">
            <label>用户名称</label>
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
      "data": [
        {
            "id": 1,
            "name": "admin",
            "email": "admin@email.com",
            "created_at": {
                "date": "2018-01-05 03:27:18.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2018-01-05 03:27:18.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2,
            "name": "test",
            "email": "test@gmail.com",
            "created_at": {
                "date": "2018-01-05 03:28:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2018-01-05 03:28:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
      ],
      isShowModal: false,
    }
  },
  components: {
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteRole: function () {
      const that = this;
      let prompt = confirm("确认删除改用户吗？");
      if (prompt) {

      }
    }
  },
  created() {
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
.user {
  margin-top: 20px;
}
</style>
