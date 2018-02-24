<template lang="html">
  <div class="">
    <nav class="navbar is-info">
      <div class="navbar-brand">
        <a class="navbar-item" href="">
          <img src="https://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox" width="112" height="28">
        </a>
        <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>

      <div id="navbarExampleTransparentExample" class="navbar-menu">
        <div class="navbar-start">
          <a class="navbar-item" href="">
            主页
          </a>
          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link" href="/documentation/overview/start/">
              Docs
            </a>
            <div class="navbar-dropdown is-boxed">
              <a class="navbar-item" href="/documentation/overview/start/">
                课程
              </a>
              <a class="navbar-item" href="">
                预习
              </a>
              <a class="navbar-item" href="">
                作业
              </a>
              <a class="navbar-item" href="">
                考试
              </a>
              <a class="navbar-item" href="">
                错题
              </a>
              <a class="navbar-item" href="">
                测评
              </a>
              <a class="navbar-item" href="">
                消息
              </a>
              <hr class="navbar-divider">
              <a class="navbar-item" href="">
                公告
              </a>
              <a class="navbar-item is-active" href="">
                讨论
              </a>
            </div>
          </div>
        </div>

        <div class="navbar-end">
          <div class="navbar-item">
            <div class="field is-grouped">
              <p class="control">
                <a class="bd-tw-button button" href="">
                  <span class="icon">
                    <i class="far fa-address-card"></i>
                  </span>
                  <span>
                    学生信息
                  </span>
                </a>
              </p>
              <p class="control">
                <a class="bd-tw-button button" href="">
                  <span class="icon">
                    <i class="far fa-envelope"></i>
                  </span>
                  <span>消息中心</span>
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
}
</script>

<style lang="css">
</style>
