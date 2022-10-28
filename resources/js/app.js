import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { Link, createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createPinia } from 'pinia'
import { createHead } from '@vueuse/head'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import { Ziggy } from '@/ziggy'
import DefaultLayout from '@/layouts/default.vue'

const pinia = createPinia()
const head = createHead()

// const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'RMS'

createInertiaApp({
//   title: title => `${title} - ${appName}`,
//   resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue') as any),
  resolve: (name) => {
    const page = resolvePageComponent(
            `./views/${name}.vue`,
            import.meta.glob('./views/**/*.vue'),
    )

    page.then((module) => {
      module.default.layout = module.default.layout || DefaultLayout
    })

    return page
  },
  //   setup
  setup({ el, app, props, plugin }) {
    createApp({ render: () => h(app, props) })
      .use(plugin)
      .use(pinia)
      .use(head)
      .use(ZiggyVue, Ziggy)
      .component('Link', Link)
      .mount(el)
  },
})

InertiaProgress.init({
  color: 'red',
  showSpinner: true,
})
