<template lang="html">
    <div class="">
      <img class="banner" src="./../../img/banner.jpg" alt="">
      <navigation v-model="logOut"></navigation>
    </div>
    <!-- <navigation v-model="logOut"></navigation> -->
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
    };
  },
  components: {
    Navigation
  },
  methods: {
    getPermission: function (url) {
      const that = this;
      let urlPath = url ? url : that.url
      axios({
        method: 'get',
        url: urlPath,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
        }
      }).then(res => {
        that.permissionData = res.data;  // conclude links
        that.url = res.data.links.next;
        for (let i = 0; i < res.data.data.length; i++) {
          that.permissionIdList.push(parseInt(res.data.data[i].id));
        }
          // that.$store.commit('setPermissionIdList', that.permissionIdList);
        if (that.url) {
          that.getNextPermission(that.url);
        }
      }).catch(err => {
        console.log(err);
      })
    },
    getNextPermission: function (url) {
      const that = this;
      axios({
        method: 'get',
        url: url,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
        }
      }).then(res => {
        that.permissionData = res.data;  // conclude links
        that.url = res.data.links.next;
        for (let i = 0; i < res.data.data.length; i++) {
          that.permissionIdList.push(parseInt(res.data.data[i].id));
        }
        if (that.url) {
          that.getPermission(that.url);
        }
        else {
          that.$store.commit('setPermissionIdList', that.permissionIdList);
        }
      }).catch(err => {
        console.log(err);
      })
    },
  },
  created() {
    this.getPermission();
  },
  watch: {
    logOut: function (value, oldValue) {
      const that = this;
      that.$emit('input', 'logOut');
    }
  }
}
</script>

<style lang="css">
.banner {
  width: 100%;
  height: 200px;
  margin-bottom: -6px;
}
</style>
