<template lang="html">
  <div class="">

  </div>
</template>

<script>
  // const localDomain = 'http://localhost:8000';
  const localDomain = 'http://www.badtudou.com';
  const token = sessionStorage.getItem('token');
  const userId = sessionStorage.getItem('userId');

  export default
  {
    localDomain,
    token,
    userId,
  }
</script>

<style lang="css">
</style>
