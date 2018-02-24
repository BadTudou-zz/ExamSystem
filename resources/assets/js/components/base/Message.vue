<!--
【用户】
涉及API：用户-消息
-->
<template lang="html">
  <div class="box">
    <div class="notification">
      <button class="delete"></button>
      Lorem ipsum dolor sit amet, consectetur
      adipiscing elit lorem ipsum dolor. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida purus diam, et dictum <a>felis venenatis</a> efficitur. Sit amet,
      consectetur adipiscing elit
      <p>2018-01-05</p>
    </div>
  </div>
</template>


<script>
import Moment from 'moment';

export default {
  data() {
    return {
    };
  },
  props: [],
  methods: {
  },
  created() {
  },
  watch: {

  }
}
</script>

<style lang="css">
.notification p{
  margin-top: 25px;
  text-align: right;
}
</style>
