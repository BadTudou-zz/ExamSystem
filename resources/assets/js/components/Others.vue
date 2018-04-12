<!-- applyFor.vue and label.vue 's wrapper -->
<template lang="html">
  <div class="">
    <!-- others -->
    <div class="tabs is-centered">
      <ul>
        <li @click="currentTag = 'applyFor'" :class="{'is-active' : currentTag === 'applyFor'}"><a>申请</a></li>
        <li @click="currentTag = 'label'" :class="{'is-active' : currentTag === 'label'}"><a>标签</a></li>
      </ul>
    </div>

    <apply-for v-show="currentTag === 'applyFor'"></apply-for>
    <label v-show="currentTag === 'label'"></label>

  </div>
</template>

<script>
import ApplyFor from './ApplyFor/AddApplyFor'
import Label from './Label/Label'

export default {
  data() {
    return {
      currentTag: 'applyFor'
    }
  },
  components: {
    ApplyFor,
    Label,
  },
  methods: {
  },
  computed: {
  },
  created() {
    console.log('others')
    console.log(this.currentTag);
  },
  watch: {
  }
}
</script>

<style scoped>
ul li a {
  border-bottom-width: 5px;
}
.tabs.is-centered ul {
  background-color: #fff;
}
</style>
