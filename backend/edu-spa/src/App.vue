<template>
  <div id="app">

    <v-header></v-header>
    <div class="content">
      <router-view></router-view>
    </div>

    <div class="content"> I am content
      <div class="left"> I am left
        <div id="leftmodules_userinfo">
          userinfo
        </div>
      </div>
      <div class="right"> I am right</div>
    </div>

  </div>
</template>

<script>
  import Header from './components/header/Header.vue'
  export default {
    name: 'app',
    data () {
      return {
        topMenuList: []
      }
    },
    components: {
      'v-header': Header
    }
  }
</script>

<style lang="stylus" type="text/stylus">
  .content{
    padding 10px;
    background-color #e7eaec;
  }
</style>
