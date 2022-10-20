import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { Head, Link, createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createPinia } from 'pinia'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'

const pinia = createPinia()

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

createInertiaApp({
  title: title => `${title} - ${appName}`,
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, app, props, plugin }) {
    return createApp({ render: () => h(app, props) })
      .use(plugin)
      // eslint-disable-next-line no-undef
      .use(ZiggyVue, Ziggy)
      .use(pinia)
      .component('InertiaHead', Head)
      .component('InertiaLink', Link)

      .mount(el)
  },
})

InertiaProgress.init({ color: '#4B5563' })
