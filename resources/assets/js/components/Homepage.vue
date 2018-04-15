<template lang="html">
    <div class="">
      <img class="banner" src="../../img/banner1.jpg" alt="">
      <navigation2 v-model="logOut"></navigation2>
    </div>
</template>

<script>
// import Navigation from './Navigation'
import Navigation2 from './Navigation2'
export default {
  data() {
    return {
      permissionIdList: [],
      permissionData: null,
      url: `${this.GLOBAL.localDomain}/api/v1/roles/1/permissions`,
      logOut: null,
      permissions: [],
      isShowNavigation: false
    };
  },
  components: {
    // Navigation,
    Navigation2,
  },
  methods: {
  },
  created() {
  },
  watch: {
    logOut: function (value, oldValue) {
      const that = this;
      that.$emit('input', 'logOut');
    },
  }
}
</script>

<style lang="css">
.banner {
  width: 100%;
  height: 250px;
  margin-bottom: -6px;
}
</style>
