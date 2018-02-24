<template lang="html">
  <div class="">
    <div>
      <div class="tabs is-centered is-toggle is-fullwidth">
        <ul>
          <li v-bind:class="{'is-active': tabSelect === 'message'}" v-on:click="tabSelect = 'message'">
            <a>消息</a>
          </li>
          <li v-bind:class="{'is-active': tabSelect === 'notice'}" v-on:click="tabSelect = 'notice'">
            <a>通知</a>
          </li>
        </ul>
      </div>
      <div class="content">

        <!-- 消息 -->
        <message v-if="tabSelect === 'message'"></message>

        <!-- 通知 -->
        <notice v-if="tabSelect === 'notice'"></notice>

      </div>
    </div>
  </div>
</template>

<script>
import Message from './base/Message.vue'
import Notice from './base/Notice.vue'
export default {
  data() {
    return {
      tabSelect: 'message',
    };
  },
  components: {
    Message,
    Notice,
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
.tabs.is-toggle li.is-active a {
  background-color: #2B9EEB;
}
</style>
