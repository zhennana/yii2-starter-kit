<template>

</template>

<script>
  export default {
    name: 'create-class',
    props: {
      createForm: {
        type: Object
      },
      formInfo: {
        type: Object
      }
    },
    data () {
      return {
        rules: {
          className: [
            {required: true, message: '请输入班级名称', trigger: 'blur'}
          ],
          number: [
            {required: true, message: '请输入班级号', trigger: 'blur'},
            {
              validator: (rule, value, callback) => {
                if (/^\d+$/.test(value) === false) {
                  callback(new Error('请输入数字'))
                } else {
                  callback()
                }
              },
              trigger: 'blur'
            }
          ],
          sort: [
            {required: true, message: '请输入排序', trigger: 'blur'},
            {
              validator: (rule, value, callback) => {
                if (/^\d+$/.test(value) === false) {
                  callback(new Error('请输入数字'))
                } else {
                  callback()
                }
              },
              trigger: 'blur'
            }
          ]
        }
      }
    },
    methods: {}
  }
</script>

<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">
  .create-dialog
    .el-form-item__content
      width 70%
      .el-select
        width 100%
</style>
