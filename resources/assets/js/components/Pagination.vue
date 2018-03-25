<template lang="html">
  <div class="wrapper">
    <button @click="prevPage()" v-bind:disabled="currentPage === 1" class="button" type="button" name="button">上一页</button>
    <button @click="nextPage()" v-bind:disabled="currentPage === totalPage" class="button" type="button" name="button">下一页</button>
    <span>{{ currentPage }} / {{ totalPage }}</span>
    <!-- <input class="input search-key" type="text" name="" value="">
    <button @click="jumpPage()" type="button" class="button is-primary" name="button">跳转</button> -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      token: null,
      first: null,  // 首页
      last: null,  // 尾页
      next: null,  // 下一页
      prev: null,  // 上一页
      data: null,
      totalPage: null,
      currentPage: null,
    };
  },
  components: {
  },
  props: [
    'paginationData',
  ],
  methods: {
    getData: function (urlPath) {
      const that = this;
      axios({
        method: 'get',
        url: urlPath,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.data = res.data;
        that.$emit('input', that.data);
        // that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    nextPage: function () {
      const that = this;
      let url = that.next;
      that.getData(url);
    },
    prevPage: function () {
      const that = this;
      let url = that.prev;
      if (!url) {
        that.getData(that.first);
      }
      else {
        that.getData(url);
      }
    },
    jumpePage: function () {
      const that = this;
      // let url = that;
      that.getData(url);
    },
  },
  created() {
    this.token = sessionStorage.getItem('token');

  },
  watch: {
    paginationData: function (value, oldValue) {
      const that = this;
      that.first = value.first;
      that.last = value.last;
      that.next = value.next;
      that.prev = value.prev;
      let numberReg = /(page=)([^&]+)/;
      that.totalPage = parseInt(that.last.match(numberReg)[2]);
      if (that.next) {
        that.currentPage = parseInt(that.next.match(numberReg)[2]) - 1;
      } else if (that.prev) {
        that.currentPage = parseInt(that.prev.match(numberReg)[2]) + 1;
      }
      else {
        that.currentPage = 1;
      }
    }
  }
}
</script>

<style>
.search-key {
  width: 60px;
  margin: 0 5px 0 40px;
}
.wrapper {
  margin-top: 50px;
}
span {
  display: inline-block;
  height: 36px;
  line-height: 36px;
}
</style>
