/**
 * Created by YJZX-LCH on 2017-04-12.
 */
export default {
  addData (name, data) {
    if (!data) return false
    let datas = ''
    if (data instanceof Object) {
      datas = JSON.stringify(data)
    } else {
      datas = data
    }
    console.log(' zhe li yun xing le ')
    window.localStorage[name] = datas
  },

  getData (name) {
    let data = window.localStorage[name]
    if (data) {
      return data
    } else {
      return false
    }
  },
  removeData (name) {
    window.localStorage.removeItem(name)
  }
}
