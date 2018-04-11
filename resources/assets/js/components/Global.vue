<template lang="html">
  <div class="">

  </div>
</template>

<script>
  // const localDomain = 'http://localhost:8000';
  const localDomain = 'http://www.badtudou.com';
  const token = sessionStorage.getItem('token');
  const userId = sessionStorage.getItem('userId');
  const permissions = sessionStorage.getItem('permissions');


  export default
  {
    localDomain,
    token,
    userId,
    permissions,
    // a,
  }
  // export default {
  //   data() {
  //     return {
  //
  //     };
  //   },
  //   components: {
  //   },
  //   props: [
  //     'userId',
  //     'token',
  //   ],
  //   methods: {
  //
  //   },
  //   created() {
  //
  //   },
  //   watch: {
  //     userId: function (value, oldValue) {
  //       const that = this;
  //       debugger
  //     },
  //     token: function (value, oldValue) {
  //       const that = this;
  //       debugger
  //     }
  //   }
  // }
</script>


<style lang="css">
</style>
