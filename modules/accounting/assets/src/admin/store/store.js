import Vue from 'vue'
import Vuex from 'vuex'
import sales from './modules/sales'
import expense from './modules/expense'
import purchase from './modules/purchase'
import spinner from './modules/spinner'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    sales,
    expense,
    purchase,
    spinner
  },
  strict : debug,
  plugins: []
})
