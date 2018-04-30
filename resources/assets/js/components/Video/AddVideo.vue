<template lang="html">
  <!-- <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加视频</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>视频名称</label>
          <input v-model="videoData.videoName" class="input" type="text">
        </div>
        <div class="box-item">
          <label>知识点</label>
          <input v-model="videoData.kp" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addVideo()" class="button is-success">确认</button>
        <button  @click="switchModal()" class="button">取消</button>
      </footer>
    </div>
  </div> -->
  <div class="">
    ss
  </div>
</template>

<script>
// export default {
//   data() {
//     return {
//       isShowModal: false,
//       videoData: {
//         videoName: '',
//         kp: '',
//       },
//     }
//   },
//   components: {
//   },
//   methods: {
//     switchModal: function () {
//       const that = this;
//       that.isShowModal = !that.isShowModal;
//     },
//     clearWords: function () {
//       const that = this;
//       that.videoData.name = '';
//       that.videoData.display_name = '';
//       that.videoData.descripe = '';
//       that.videoData.number = '';
//     },
//     addVideo: function () {
//       const that = this;
//       axios({
//         method: 'post',
//         url: `${this.GLOBAL.localDomain}/api/v1/courses`,
//         headers: {
//           'Accept': 'application/json',
//           'Authorization': sessionStorage.getItem('token'),
//         },
//         params: {
//           videoName: that.videoData.videoName,
//           kp: that.videoData.kp,
//         }
//       }).then(res => {
//         alert('添加成功');
//         that.$emit('getVideo');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
//         that.switchModal();
//       }).catch(err => {
//         alert('添加失败');
//         console.log(err);
//         that.clearWords();
//       })
//     }
//   },
//   created() {
//   }
// }
</script>

<style>
</style>
