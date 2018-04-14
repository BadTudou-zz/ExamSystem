<!-- course.vue and teaching.vue 's wrapper -->
<template lang="html">
  <div class="">
    <div class="tabs is-centered">
      <ul>
        <li @click="currentTag = 'course'" :class="{'is-active' : currentTag === 'course'}"><a>课程</a></li>
        <li @click="currentTag = 'teaching'" :class="{'is-active' : currentTag === 'teaching'}"><a>授课</a></li>
      </ul>
    </div>

    <course v-show="currentTag === 'course'"></course>
    <teaching v-show="currentTag === 'teaching'"></teaching>
    
  </div>
</template>
<script>
import Course from './Course/Course'
import Teaching from './Teaching/Teaching'

export default {
  data() {
    return {
      currentTag: 'course'
    }
  },
  components: {
    Course,
    Teaching,
  },
  methods: {

  },
  computed: {
  },
  created() {
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
