import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { Head, Link, createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createPinia } from 'pinia'
import HighchartsVue from 'highcharts-vue'
import Highcharts from 'highcharts'
import exportingInit from 'highcharts/modules/exporting'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import { Ziggy } from '@/ziggy'
import DefaultLayout from '@/layouts/Default.vue'

const pinia = createPinia()
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'RMS'

createInertiaApp({
  title: title => `${title} - ${appName}`,
  //   resolve: name => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')),
  resolve: (name) => {
    const page = resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob('./pages/**/*.vue'),
    )
    page.then((module) => {
      module.default.layout = module.default.layout || DefaultLayout
    })
    return page
  },
  //   setup
  setup({ el, app, props, plugin }) {
    createApp({ render: () => h(app, props) })
      .use(pinia)
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(HighchartsVue)
      .component('Link', Link)
      .component('Head', Head)
      .mount(el)
  },
})

// init area
exportingInit(Highcharts)

InertiaProgress.init({
  color: '#3b82f6',
  showSpinner: false,
})
