<template lang="html">
  <div class="">
    <div class="box">
      <table class="table">
        <thead>
          <tr>
            <th>课程名</th>
            <th>可选课程数</th>
            <th>课程描述</th>
            <th>创建时间</th>
            <th>更新时间</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in data">
            <td>{{ item.display_name }}</td>
            <td>{{ item.number }}</td>
            <td>{{ item.descripe }}</td>
            <td>{{ item.created_at }}</td>
            <td>{{ item.updated_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: [
        {
          "id": 2,
          "name": "english",
          "number": "123",
          "display_name": "英语",
          "descripe": "这是英语课程",
          "created_at": "2018-01-19 15:01:45",
          "updated_at": "2018-01-19 15:01:45"
        }
      ],
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
</style>
