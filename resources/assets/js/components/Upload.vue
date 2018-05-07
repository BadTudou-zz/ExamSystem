<!-- 查看通知 -->
<template lang="html">
  <div class="box">
    <h3 class="title">上传</h3>

    <div>
      <div class="tabs is-centered is-boxed">
        <ul>

          <li v-bind:class="{'is-active': currentTag === 'role'}">
            <a>
              <span @click="currentTag = 'role'">导入角色数据</span>
            </a>
          </li>

          <li v-bind:class="{'is-active': currentTag === 'question'}">
            <a>
              <span @click="currentTag = 'question'">导入问题数据</span>
            </a>
          </li>

        </ul>
      </div>

    </div>

    <!-- <upload-role v-show="currentTag === 'role'"></upload-role> -->
    <upload-question v-bind:show-upload="showUpload"></upload-question>

  </div>

</template>


<script>
// import UploadRole from './Role/UploadRole'
import UploadQuestion from './Question/UploadQuestion'

export default {
  data() {
    return {
      currentTag: 'role',
      showUpload: true,
    }
  },
  components: {
    UploadQuestion,
    // UploadRole
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
  },
  computed: {
  },
  created() {

  },
  watch: {
  }
}
</script>

<style lang="scss">
.message {
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
.message-detail {
  margin: 0px;
  text-align: right;
  color: #acb9b8;
}
.title {
  color: #363636;
  font-size: 1.5rem;
  font-weight: 600;
  line-height: 1.125;
}
.message-data {
  margin-bottom: 20px;
}
</style>
