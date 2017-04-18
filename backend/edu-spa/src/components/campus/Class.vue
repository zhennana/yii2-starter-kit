<template>
  <div>
    <div id="class-header">
      班级管理
    </div>
    <div>
      <el-table
        :data="tData"
        stripe
        @selection-change="handleSelectionChange"
        style="width: 100%">
        <el-table-column
          type="selection"
          width="55">
        </el-table-column>
        <el-table-column
          v-for="item in tHeader"
          :prop="item.prop"
          :label="item.label"
          :key="item.key"
          width="120">
        </el-table-column>

      </el-table>
    </div>
  </div>
</template>

<script>
  import Class from '../../api/class'
  export default {
    name: 'class',
    created () {
      this.getClassData()
    },
    data () {
      return {
        tHeader: [
          {
            key: 0,
            label: '学校',
            prop: 'school_title'
          },
          {
            key: 1,
            label: '班级分类',
            prop: 'group_category_name'
          },
          {
            key: 2,
            label: '几班',
            prop: 'grade_title'
          },
          {
            key: 3,
            label: '创建者',
            prop: 'creater_id'
          },
          {
            key: 4,
            label: '班主任',
            prop: 'owner_id'
          },
          {
            key: 5,
            label: '班主任',
            prop: 'owner_id'
          },
          {
            key: 6,
            label: '排序',
            prop: 'sort'
          },
          {
            key: 7,
            label: '活动状态',
            prop: 'status'
          },
          {
            key: 8,
            label: '创建时间',
            prop: 'created_at'
          },
          {
            key: 9,
            label: '更新时间',
            prop: 'updated_at'
          }
        ],
        tData: [],
        params: {}
      }
    },
    methods: {
      getClassData () {
        Class.getClassData(this.params).then(response => {
          if (response.errno === '0') {
            this.tData = response.result
          } else {
            this.showMsg(response.message)
          }
        }).catch(error => {
          console.log(error)
        })
      },
      showMsg (errorMsg) {
        this.$alert(errorMsg, '提示', {
          confirmButtonText: '确定'
        })
      },
      handleSelectionChange (selects) {}
    }
  }
</script>

<style>

</style>
