<template lang="html">
    <div class="">
      <img class="banner" src="../../img/banner1.jpg" alt="">
      <navigation v-model="logOut"></navigation>
    </div>
</template>

<script>
import Navigation from './Navigation'
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
    Navigation,
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
