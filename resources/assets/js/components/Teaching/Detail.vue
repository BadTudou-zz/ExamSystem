<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">详情授课</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
          <thead>
            <tr>
              <th></th>
              <th>详情</th>
            </tr>
          </thead>
        <tbody v-if="currentTeachingData">
            <tr>
              <td>id</td>
              <td>{{ currentTeachingData.id }}</td>
            </tr>
            <tr>
              <td>授课名称</td>
              <td>{{ currentTeachingData.name }}</td>
            </tr>
            <tr>
              <td>用户ID</td>
              <td>{{ currentTeachingData.user_id }}</td>
            </tr>
            <tr>
              <td>课程ID</td>
              <td>{{ currentTeachingData.course_id }}</td>
            </tr>
            <tr>
              <td>允许的组织ID</td>
              <td>{{ currentTeachingData.allowable_organization_ids }}</td>
            </tr>
            <tr>
              <td>允许的用户ID</td>
              <td>{{ currentTeachingData.allowable_user_ids }}</td>
            </tr>
            <tr>
              <td>描述</td>
              <td><p class="limit-words">{{ currentTeachingData.describe }}</p></td>
            </tr>
            <tr>
              <td>最大容量</td>
              <td>{{ currentTeachingData.max }}</td>
            </tr>
            <tr>
              <td>当前容量</td>
              <td>{{ currentTeachingData.current }}</td>
            </tr>
            <tr>
              <td>创建时间</td>
              <td>{{ currentTeachingData.created_at }}</td>
            </tr>

            <tr>
              <td>更新时间</td>
              <td>{{ currentTeachingData.updated_at }}</td>
            </tr>



          </tbody>
        </table>
      </section>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      isShowModal: false,
    }
  },
  components: {
  },
  props: [
    'currentTeachingData',
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    }
  },
  created() {
  },
  watch: {
  }
}
</script>

<style scoped>
</style>
