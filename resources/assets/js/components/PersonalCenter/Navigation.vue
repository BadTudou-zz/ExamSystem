<!-- 查看用户 -->
<template lang="html">
  <div>
    <div class="tabs is-centered is-boxed">
      <ul>
        <li v-bind:class="{'is-active': currentTag === 'userData'}">
          <a>
            <span @click="currentTag = 'userData'">个人信息</span>
          </a>
        </li>

        <li v-bind:class="{'is-active': currentTag === 'messageData'}">
          <a>
            <span @click="currentTag = 'messageData'">消息</span>
          </a>
        </li>

        <li  v-bind:class="{'is-active': currentTag === 'noticeData'}">
          <a>
            <span @click="currentTag = 'noticeData'">通知</span>
          </a>
        </li>

        <li v-bind:class="{'is-active': currentTag === 'lectureData'}">
          <a>
            <span @click="currentTag = 'lectureData'">选课</span>
          </a>
        </li>

        <li v-bind:class="{'is-active': currentTag === 'organizationData'}">
          <a>
            <span @click="currentTag = 'organizationData'">组织</span>
          </a>
        </li>

        <li v-bind:class="{'is-active': currentTag === 'roleData'}">
          <a>
            <span @click="currentTag = 'roleData'">角色</span>
          </a>
        </li>

        <li v-bind:class="{'is-active': currentTag === 'permissionData'}">
          <a>
            <span @click="currentTag = 'permissionData'">权限</span>
          </a>
        </li>

        <li v-bind:class="{'is-active': currentTag === 'applyForData'}">
          <a>
            <span @click="currentTag = 'applyForData'">申请</span>
          </a>
        </li>

        <li v-bind:class="{'is-active': currentTag === 'TestData'}">
          <a>
            <span @click="currentTag = 'testData'">考试</span>
          </a>
        </li>

      </ul>
    </div>

  </div>
</template>

<script>

export default {
  data() {
    return {
      currentTag: 'userData',
    }
  },
  components: {
  },
  methods: {
  },
  computed: {
  },
  created() {

  },
  watch: {
    currentTag: function (value, oldValue) {
      const that = this;
      that.$emit('input', that.currentTag);
    }
  }
}
</script>

<style lang="css">

</style>
