<template lang="html">
  <div>
    <nav class="navbar is-info">
      <div class="navbar-brand">
        <a class="navbar-item">
          <!-- <img src="https://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox" width="112" height="28"> -->
        </a>
        <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>

      <div id="navbarExampleTransparentExample" class="navbar-menu">
        <div class="navbar-start">
          <a class="navbar-item" >
            主页
          </a>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              用户
            </a>
            <div class="navbar-dropdown is-boxed">
              <router-link class="navbar-item" to="/view">查看</router-link>
            </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              角色
            </a>
            <div class="navbar-dropdown is-boxed">
              <router-link class="navbar-item" to="/role">角色</router-link>
              <router-link class="navbar-item" to="/permission">权限</router-link>
              <router-link class="navbar-item" to="/user">用户</router-link>
            </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              权限
            </a>
            <div class="navbar-dropdown is-boxed">
              <router-link class="navbar-item" to="/ppermission">权限</router-link>
            </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              消息
            </a>
            <div class="navbar-dropdown is-boxed">
              <router-link class="navbar-item" to="/mmessage">消息</router-link>
            </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              通知
            </a>
            <div class="navbar-dropdown is-boxed">
              <router-link class="navbar-item" to="/nnotice">通知</router-link>
            </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              组织
            </a>
            <div class="navbar-dropdown is-boxed">
              <router-link class="navbar-item" to="/organization">组织</router-link>
              <router-link class="navbar-item" to="/member">成员</router-link>
            </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              课
            </a>
            <div class="navbar-dropdown is-boxed">
              <router-link class="navbar-item" to="/course">课程</router-link>
              <router-link class="navbar-item" to="/teaching">授课</router-link>
              <router-link class="navbar-item" to="/question">问题</router-link>
            </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              试卷
            </a>
            <div class="navbar-dropdown is-boxed">
              <router-link class="navbar-item" to="/examinationPaper">试卷</router-link>
              <!-- <router-link class="navbar-item" to="/chapter">章节</router-link> -->
              <router-link class="navbar-item" to="/test">考试</router-link>
            </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              其他
            </a>
            <div class="navbar-dropdown is-boxed">
              <router-link class="navbar-item" to="/applyFor">申请</router-link>
              <router-link class="navbar-item" to="/label">标签</router-link>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <router-view></router-view>

  </div>
</template>

<script>
export default {
  data() {
    return {

    }
  },
  components: {
  },
  methods: {
  },
  computed: {
    isShowPermission() {
      return this.$store.state.permissionIdList.includes(4);
    },
    isShowRole() {
      return this.$store.state.permissionIdList.includes(7);
    },
    isShowUser() {
      return this.$store.state.permissionIdList.includes(10);
    },
    isShowMessage() {
      return this.$store.state.permissionIdList.includes(13);
    },
    isShowNotification() {
      return this.$store.state.permissionIdList.includes(17);
    },
    isShowOrganization() {
      return this.$store.state.permissionIdList.includes(26);
    },
    isShowQuestion() {
      return this.$store.state.permissionIdList.includes(33);
    },
    isShowPaper() {
      return this.$store.state.permissionIdList.includes(38);
    },
    isShowApplication() {
      return this.$store.state.permissionIdList.includes(43);
    },
    isShowTag() {
      return this.$store.state.permissionIdList.includes(49);
    },
  },
  created() {
  },
  watch: {
  }
}
</script>

<style lang="css">
a {
  color: #000;
}
</style>
