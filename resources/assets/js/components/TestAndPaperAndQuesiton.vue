<!-- test.vue and examinationPaper.vue and Quesiton.vue 's wrapper -->
<template lang="html">
  <div class="">
    <div class="tabs is-centered">
      <ul>
        <li @click="currentTag = 'test'" :class="{'is-active' : currentTag === 'test'}"><a>考试</a></li>
        <li @click="currentTag = 'examinationPaper'" :class="{'is-active' : currentTag === 'examinationPaper'}"><a>试卷</a></li>
        <li @click="currentTag = 'question'" :class="{'is-active' : currentTag === 'question'}"><a>题目</a></li>
      </ul>
    </div>

    <test v-if="currentTag === 'test'"></test>
    <examination-paper v-if="currentTag === 'examinationPaper'"></examination-paper>
    <question v-if="currentTag === 'question'"></question>

  </div>
</template>
<script>
import Test from './Test/Test'
import ExaminationPaper from './ExaminationPaper/ExaminationPaper'
import Question from './Question/Question'

export default {
  data() {
    return {
      currentTag: 'test'
    }
  },
  components: {
    Test,
    ExaminationPaper,
    Question,
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
