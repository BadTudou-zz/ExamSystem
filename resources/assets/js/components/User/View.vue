<!-- 查看 -->
<template lang="html">
  <div class="wrapper">
    <div class="select">
      <select v-model="currentTag">
        <option value="nothing">请选择你要查看的选项</option>
        <!-- <option value="user">查看用户</option> -->
        <option value="role">查看角色</option>
        <option value="message">查看消息</option>
        <option value="notice">查看通知</option>
        <option value="lecture">查看选课</option>
        <option value="permission">查看权限</option>
        <option value="apply-for">查看申请</option>
      </select>
    </div>

    <div class="modal" v-bind:class="{'is-active': isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-content member-content">
        <div class="box member-box">
          <div>
            <!-- <u-user v-show="currentTag === 'user'"></u-user> -->
            <role v-show="currentTag === 'role'"></role>
            <message v-show="currentTag === 'message'"></message>
            <notice v-show="currentTag === 'notice'"></notice>
            <lecture v-show="currentTag === 'lecture'"></lecture>
            <permission v-show="currentTag === 'permission'"></permission>
            <apply-for v-show="currentTag === 'apply-for'"></apply-for>
          </div>
        </div>
      </div>
      <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>
    </div>
  </div>

</template>

<script>
// import UUser from './UUser'
import Lecture from '../Teaching/Teaching'
import Message from '../Message/MMessage'
import Notice from '../Notice/NNotice'
import Role from '../Role/Role'
import Permission from '../Permission/PPermission'
import ApplyFor from '../ApplyFor/ApplyFor'

export default {
  data() {
      return {
        currentTag: 'nothing',
        isShowModal: false,
    }
  },
  components: {
    // UUser,
    Lecture,
    Message,
    Notice,
    Role,
    Permission,
    ApplyFor,
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
  },
  created() {
  },
  watch: {
    currentTag: function (value, oldValue) {
      const that = this;
      if (value === 'nothing') {
        that.isShowModal = false;
      }
      else {
        that.isShowModal = true;
      }
    },
    isShowModal: function (value, oldValue) {
      const that = this;
      if (value === false) {
        that.currentTag = 'nothing'
      }
    }
  }
}

</script>

<style>
.wrapper {
  /* margin-left: 20px; */
}
.select {
  margin: 0 0 20px 10px;
}
</style>
