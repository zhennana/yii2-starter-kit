<template>
  <div>
    <!--头部区域-->
    <div class="class-header">
      <div class="create-wrapper">
        <el-button class="create" type="success" icon="plus" @click="handleCreateClick">创建</el-button>
      </div>
      <div class="search">
        <el-form :inline="true" class="demo-form-inline">
          <el-form-item label="学校">
            <el-input placeholder="学校" v-model="searchForm.school_title">
            </el-input>
          </el-form-item>

          <el-form-item label="班级分类">
            <el-input placeholder="班级分类" v-model="searchForm.group_category_name">

            </el-input>
          </el-form-item>

          <el-form-item label="班级名称">
            <el-input placeholder="班级名称" v-model="searchForm.grade_name"></el-input>
          </el-form-item>

          <el-form-item label="班主任">
            <el-input v-model="searchForm.owner_label" placeholder="班主任">

            </el-input>
          </el-form-item>

          <el-form-item label="创建者">
            <el-input placeholder="创建者" v-model="searchForm.creater_label"></el-input>
          </el-form-item>

          <el-form-item label="状态">
            <el-select style="width: 120px" v-model="searchForm.status" placeholder="请选择状态">
              <el-option
                v-for="item in formInfo.status"
                :label="item.status_label"
                :key="item.status_id"
                :value="item.status_id">
              </el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="结业状态">
            <el-select style="width: 120px" v-model="searchForm.graduate" placeholder="结业状态">
              <el-option
                v-for="item in formInfo.graduate"
                :label="item.graduate_label"
                :key="item.graduate_id"
                :value="item.graduate_id">
              </el-option>
            </el-select>
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
            <el-button type="primary" @click="onSearchSubmit">查询</el-button>
            <el-button type="primary" @click="onSearchReset">重置</el-button>
          </el-form-item>
        </el-form>

      </div>
    </div>
    <!--表格展示数据-->
    <div class="class-table">
      <el-table
        border
        :data="tData"
        v-loading.body="loading"
        stripe
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
          width="180"
          fixed="right">
          <template scope="scope">
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
    <!--创建班级form-->
    <div class="create-dialog">
      <el-dialog title="创建班级" v-model="createVisible" size="small">
        <!--创建班级表单-->
        <el-form id="create-form" :model="createForm" :rules="rules" ref="createForm" label-width="100px"
                 class="demo-ruleForm">
          <el-form-item label="学校名称" prop="school_id">
            <el-select v-model="createForm.school_id" placeholder="请选择学校">
              <el-option
                v-for="item in formInfo.school"
                :label="item.school_title"
                :key="item.school_id"
                :value="item.school_id">
              </el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="班级分类" prop="group_category_id">
            <el-select v-model="createForm.group_category_id" placeholder="请选择分类">
              <el-option
                v-for="item in formInfo.grade_category"
                :label="item.name"
                :key="item.grade_category_id"
                :value="item.grade_category_id">
              </el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="班级名称" prop="grade_name">
            <el-input v-model="createForm.grade_name"></el-input>
          </el-form-item>

          <el-form-item label="班级号" prop="grade_title">
            <el-input type="text" v-model="createForm.grade_title"></el-input>
          </el-form-item>

          <el-form-item label="班主任" prop="owner_id">
            <el-select v-model="createForm.owner_id" placeholder="请选择班主任">
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
          <el-button @click="createVisible = false">取 消</el-button>
          <el-button type="primary" @click="create('createForm')">确 定</el-button>
        </div>

      </el-dialog>
    </div>
    <!--更新班级form-->
    <div class="edit-dialog">
      <el-dialog title="创建班级" v-model="editVisible" size="small">
        <!--创建班级表单-->
        <el-form id="create-form" :model="editForm" :rules="rules" ref="editForm" label-width="100px"
                 class="demo-ruleForm">
          <el-form-item label="学校名称" prop="data.school_id">
            <el-select v-model="editForm.data.school_id" placeholder="请选择学校">
              <el-option
                v-for="item in formInfo.school"
                :label="item.school_title"
                :key="item.school_id"
                :value="item.school_id">
              </el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="班级分类" prop="data.group_category_id">
            <el-select v-model="editForm.data.group_category_id" placeholder="请选择分类">
              <el-option
                v-for="item in formInfo.grade_category"
                :label="item.name"
                :key="item.grade_category_id"
                :value="item.grade_category_id">
              </el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="班级名称" prop="data.grade_name">
            <el-input v-model="editForm.data.grade_name"></el-input>
          </el-form-item>

          <el-form-item label="班级号" prop="data.grade_title">
            <el-input type="text" v-model="editForm.data.grade_title"></el-input>
          </el-form-item>

          <el-form-item label="班主任" prop="data.owner_id">
            <el-select v-model="editForm.data.owner_id" placeholder="请选择班主任">
              <el-option
                v-for="item in formInfo.user"
                :label="item.username"
                :key="item.id"
                :value="item.id">
              </el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="排序" prop="data.sort">
            <el-input v-model="editForm.data.sort"></el-input>
          </el-form-item>

          <el-form-item label="活动状态" prop="data.status">
            <el-select v-model="editForm.data.status" placeholder="请选择状态">
              <el-option
                v-for="item in formInfo.status"
                :label="item.status_label"
                :key="item.status_id"
                :value="item.status_id">
              </el-option>
            </el-select>
          </el-form-item>
        </el-form>

        <div slot="footer" class="dialog-footer">
          <el-button @click="editVisible = false">取 消</el-button>
          <el-button type="primary" @click="update('editForm')">更新</el-button>
        </div>

      </el-dialog>
    </div>

    <div class="block">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page="pagination.currentPage"
        :page-size="pagination.perPage"
        layout="prev, pager, next, jumper"
        :total="pagination.totalCount">
      </el-pagination>
    </div>

  </div>
</template>

<script>
  import Class from '../../api/campus/class'
  import AddressCascader from '../select/AddressCascader.vue'
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
          school_title: '',
          group_category_name: '',
          grade_name: '',
          creater_label: '',
          owner_label: '',
          status: '',
          graduate: '',
          time: '',
          page: 1
        },
        tHeader: [
          {
            key: 0,
            label: '主校ID',
            prop: 'school_id'
          },
          {
            key: 1,
            label: '学校',
            prop: 'school_title'
          },
          {
            key: 2,
            label: '班级分类',
            prop: 'group_category_name'
          },
          {
            key: 3,
            label: '班级名称',
            prop: 'grade_name'
          },
          {
            key: 4,
            label: '创建者',
            prop: 'creater_label'
          },
          {
            key: 5,
            label: '班主任',
            prop: 'owner_label'
          },
          {
            key: 6,
            label: '排序',
            prop: 'sort'
          },
          {
            key: 7,
            label: '活动状态',
            prop: 'status_label'
          },
          {
            key: 8,
            label: '结业状态',
            prop: 'graduate_label'
          },
          {
            key: 9,
            label: '创建时间',
            prop: 'created_at'
          },
          {
            key: 10,
            label: '更新时间',
            prop: 'updated_at'
          }
        ],
        tData: [],
        createVisible: false,
        createForm: {
          school_id: '',
          group_category_id: '',
          grade_name: '',
          grade_title: '',
          owner_id: '',
          sort: '',
          status: ''
        },
        editVisible: false,
        editForm: {
          index: '',
          data: {
            school_id: '',
            group_category_id: '',
            grade_name: '',
            grade_title: '',
            owner_id: '',
            sort: '',
            status: ''
          }
        },
        formInfo: {},
        rules: {
          grade_name: [
            {required: true, message: '请输入班级名称', trigger: 'blur'}
          ],
          grade_title: [
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
          school_id: [
            {required: true, type: 'number', message: '请选择学校', trigger: 'change'}
          ],
          group_category_id: [
            {required: true, type: 'number', message: '请选择分类', trigger: 'change'}
          ],
          owner_id: [
            {required: true, type: 'number', message: '请选择班主任', trigger: 'change'}
          ],
          status: [
            {required: true, type: 'number', message: '请选择状态', trigger: 'change'}
          ]
        },
        pagination: {
          currentPage: 1
        }
      }
    },
    methods: {
      getClassData () {
        this.loading = true
        Class.getClassData(this.searchForm).then(response => {
          if (response.errno === '0') {
            this.tData = response.result
            this.pagination = response._meta
          } else {
            this.showErrorMsg(response.message)
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
            this.showErrorMsg(response.message)
          }
        }).catch(error => {
          console.log(error)
        })
      },
      showErrorMsg (errorMsg) {
        this.this.$message.error(errorMsg)
      },
      showSuccessMsg (msg) {
        this.$message({message: msg, type: 'success'})
      },
      handleCreateClick () {
        this.createVisible = true
      },
      onSearchSubmit () {
        this.getClassData()
      },
      onSearchReset () {
        for (let key in this.searchForm) {
          this.searchForm[key] = ''
        }
        this.getClassData()
      },
      create (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.createVisible = false
            Class.createClass(this.createForm).then((response) => {
              console.log(response)
              if (response.errno === '0') {
                this.showSuccessMsg(response.message)
                this.getClassData()
              } else {
                this.showErrorMsg(response.message)
              }
            }).catch((error) => {
              console.log(error)
            })
          } else {
            return false
          }
        })
      },
      handleEdit (index, row) {
        Object.assign(this.editForm.data, row)
        this.editForm.index = index
        this.editVisible = true
      },
      update (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.editVisible = false
            Class.updateClass(this.editForm.data).then(response => {
              if (response.errno === '0') {
                this.tData[this.editForm.index] = response.result
                this.showSuccessMsg(response.message)
                this.editForm.data = {}
                this.editForm.index = 0
              } else {
                this.showErrorMsg(response.message)
              }
            }).catch((error) => {
              console.log(error)
            })
          } else {
            return false
          }
        })
      },
      handleDelete (index, row) {
        this.editForm.index = index
        Object.assign(this.editForm.data, row)
        Class.deleteClass(this.editForm.data).then(response => {
          if (response.errno === '0') {
            this.tData[this.editForm.index] = response.result
            this.showSuccessMsg(response.message)
          } else {
            this.showErrorMsg(response.message)
          }
        }).catch(error => {
          console.log(error)
        })
      },
      handleCurrentChange (current) {
        this.pagination.currentPage = current
        this.searchForm.page = current
        this.getClassData()
      }
    },
    components: {
      AddressCascader
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

  .create-dialog
    .el-form-item__content
      width 70%
      .el-select
        width 100%

  .edit-dialog
    .el-form-item__content
      width 70%
      .el-select
        width 100%

  .block
    margin 20px;
</style>
