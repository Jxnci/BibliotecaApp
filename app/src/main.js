import './index.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import { OhVueIcon, addIcons } from 'oh-vue-icons'
import {
  MdDashboardRound,
  IoSettings,
  BiCircleSquare,
  MdPersonsearchRound,
  FaStore,
  MdStackedlinechartRound,
  HiLogout,
  MdDarkmodeRound,
  MdLightmode,
  FaUserAlt,
  MdNavigatenextRound,
  BiPersonCheck,
  LaEditSolid,
  RiDeleteBinLine,
  BiEye,
  IoSettingsSharp,
  MdLibrarybooksRound,
  MdCommentsdisabledOutlined
} from 'oh-vue-icons/icons'

addIcons(
  MdDashboardRound,
  IoSettings,
  BiCircleSquare,
  MdPersonsearchRound,
  FaStore,
  MdStackedlinechartRound,
  HiLogout,
  MdDarkmodeRound,
  MdLightmode,
  FaUserAlt,
  MdNavigatenextRound,
  BiPersonCheck,
  LaEditSolid,
  RiDeleteBinLine,
  BiEye,
  IoSettingsSharp,
  MdLibrarybooksRound,
  MdCommentsdisabledOutlined
)


const app = createApp(App)

app.use(createPinia())
app.component('v-icon', OhVueIcon)
app.use(router)

app.mount('#app')
