<template>
  <div>
    <div class="class-header">
      <div class="create-wrapper">
        <el-button class="create" type="success" icon="plus" @click="handleCreateClick">创建</el-button>
      </div>
      <div class="search">
        <el-form :inline="true" class="demo-form-inline">
          <el-form-item label="学校">
            <el-select placeholder="学校" v-model="searchForm.school">
              <el-option label="学校一" value="shanghai"></el-option>
              <el-option label="学校二" value="beijing"></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="班级分类">
            <el-input placeholder="班级分类"></el-input>
          </el-form-item>

          <el-form-item label="班级名称">
            <el-input placeholder="班级名称"></el-input>
          </el-form-item>

          <el-form-item label="创建者">
            <el-input placeholder="创建者"></el-input>
          </el-form-item>

          <el-form-item label="创建者">
            <el-input placeholder="创建者"></el-input>
          </el-form-item>

          <el-form-item label="创建者">
            <el-input placeholder="创建者"></el-input>
          </el-form-item>

          <el-form-item label="创建者">
            <el-input placeholder="创建者"></el-input>
          </el-form-item>

          <el-form-item label="创建者">
            <el-input placeholder="创建者"></el-input>
          </el-form-item>

          <el-form-item label="日期">
            <el-date-picker v-model="searchForm.time"
                            type="daterange"
                            align="left"
                            placeholder="选择日期范围"
                            :picker-options="pickerOptions2">

            </el-date-picker>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="onSubmit">查询</el-button>
          </el-form-item>
        </el-form>

      </div>
    </div>
    <div class="class-table">
      <el-table
        border
        :data="tData"
        v-loading.body="loading"
        stripe
        @selection-change="handleSelectionChange"
        style="width: 100%">
        <el-table-column
          v-for="item in tHeader"
          :prop="item.prop"
          :label="item.label"
          :key="item.key"
          width="120">
        </el-table-column>

        <el-table-column
          label="操作"
          width="250"
          fixed="right">
          <template scope="scope">
            <el-button type="info"
                       size="small"
                       icon="edit"
                       @click="handleBrowse(scope.$index, scope.row)">查看
            </el-button>
            <el-button
              size="small"
              type="success"
              icon="edit"
              @click="handleEdit(scope.$index, scope.row)">编辑
            </el-button>
            <el-button
              size="small"
              icon="delete2"
              type="danger"
              @click="handleDelete(scope.$index, scope.row)">删除
            </el-button>
          </template>
        </el-table-column>

      </el-table>
    </div>
    <div class="create-dialog">
      <el-dialog title="创建班级" v-model="dialogFormVisible" size="small">
        <!--创建班级表单-->
        <el-form id="create-form" :model="createForm" :rules="rules" ref="createForm" label-width="100px"
                 class="demo-ruleForm">
          <el-form-item label="学校名称" prop="schoolName">
            <el-select v-model="createForm.schoolName" placeholder="请选择学校">
              <el-option
                v-for="item in formInfo.school"
                :label="item.school_title"
                :key="item.school_id"
                :value="item.school_id">
              </el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="班级分类" prop="classifyName">
            <el-select v-model="createForm.classifyName" placeholder="请选择分类">
              <el-option
                v-for="item in formInfo.grade_category"
                :label="item.name"
                :key="item.grade_category_id"
                :value="item.grade_category_id">
              </el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="班级名称" prop="className">
            <el-input v-model="createForm.className"></el-input>
          </el-form-item>

          <el-form-item label="班级号" prop="number">
            <el-input type="text" v-model="createForm.number"></el-input>
          </el-form-item>

          <el-form-item label="班主任" prop="owner">
            <el-select v-model="createForm.owner" placeholder="请选择班主任">
              <el-option
                v-for="item in formInfo.user"
                :label="item.username"
                :key="item.id"
                :value="item.id">
              </el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="排序" prop="sort">
            <el-input v-model="createForm.sort"></el-input>
          </el-form-item>

          <el-form-item label="活动状态" prop="status">
            <el-select v-model="createForm.status" placeholder="请选择状态">
              <el-option
                v-for="item in formInfo.status"
                :label="item.status_label"
                :key="item.status_id"
                :value="item.status_id">
              </el-option>
            </el-select>
          </el-form-item>
        </el-form>

        <!--<create-class-->
          <!--v-bind:create-form="createForm"-->
          <!--v-bind:form-info="formInfo">-->
        <!--</create-class>-->

        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisible = false">取 消</el-button>
          <el-button type="primary" @click="create('createForm')">确 定</el-button>
        </div>

      </el-dialog>
    </div>

  </div>
</template>

<script>
  import Class from '../../api/class'
  import CreateClass from '../../components/campus/CreateClass'
  export default {
    name: 'class',
    created () {
      this.initFormData()
      this.getClassData()
    },
    data () {
      return {
        pickerOptions2: {
          shortcuts: [
            {
              text: '最近一周',
              onClick (picker) {
                const end = new Date()
                const start = new Date()
                start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
                picker.$emit('pick', [start, end])
              }
            },
            {
              text: '最近一个月',
              onClick (picker) {
                const end = new Date()
                const start = new Date()
                start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
                picker.$emit('pick', [start, end])
              }
            },
            {
              text: '最近三个月',
              onClick (picker) {
                const end = new Date()
                const start = new Date()
                start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
                picker.$emit('pick', [start, end])
              }
            }
          ]
        },
        loading: false,
        searchForm: {
          school: '',
          classify: '',
          className: '',
          creator: '',
          owner: '',
          sort: '',
          status: '',
          graduateStatus: '',
          time: ''
        },
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
            label: '班级名称',
            prop: 'grade_name'
          },
          {
            key: 3,
            label: '创建者id',
            prop: 'creater_id'
          },
          {
            key: 4,
            label: '班主任',
            prop: 'owner_label'
          },
          {
            key: 5,
            label: '排序',
            prop: 'sort'
          },
          {
            key: 6,
            label: '活动状态',
            prop: 'status_label'
          },
          {
            key: 7,
            label: '结业状态',
            prop: 'graduate_label'
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
        params: {},
        dialogFormVisible: false,
        createForm: {
          schoolName: '',
          classifyName: '',
          className: '',
          number: '',
          owner: '',
          sort: '',
          status: ''
        },
        formInfo: {},
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
          ],
          schoolName: [
            {required: true, message: '请选择学校', trigger: 'change'}
          ],
          classifyName: [
            {required: true, message: '请选择分类', trigger: 'change'}
          ],
          owner: [
            {required: true, message: '请选择班主任', trigger: 'change'}
          ],
          status: [
            {required: true, type: 'number', message: '请选择状态', trigger: 'change'}
          ]
        }
      }
    },
    methods: {
      getClassData () {
        this.loading = true
        Class.getClassData(this.params).then(response => {
          if (response.errno === '0') {
            this.tData = response.result
          } else {
            this.showMsg(response.message)
          }
          this.loading = false
        }).catch(error => {
          console.log(error)
          this.loading = false
        })
      },
      initFormData () {
        this.loading = true
        Class.getClassFormInfo().then(response => {
          if (response.errno === '0') {
            this.formInfo = response.result
          } else {
            this.showMsg(response.message)
          }
          console.log(this.formInfo)
        }).catch(error => {
          console.log(error)
        })
      },
      showMsg (errorMsg) {
        this.$alert(errorMsg, '提示', {
          confirmButtonText: '确定'
        })
      },
      handleSelectionChange (selects) {
      },
      handleCreateClick () {
        this.dialogFormVisible = true
      },
      onSubmit () {
        console.log(this.searchForm)
      },
      create (formName) {
        this.$refs[formName].validate((valid) => {
          console.log(valid)
          if (valid) {
            alert('submit!')
            this.dialogFormVisible = false
          } else {
            console.log('error submit!!')
            return false
          }
        })
        console.log(this.createForm)
      }
    },
    components: {
      CreateClass
    }
  }
</script>

<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">
  .class-header
    .create-wrapper
      height 50px;
      line-height 50px;
    .search
      margin 15px 0;
      .el-form-item__content
        width inherit;

  .class-table
    margin-right 20px;
  .create-dialog
    .el-form-item__content
      width 70%
      .el-select
        width 100%
</style>
