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
import FloatingVue from 'floating-vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import { Ziggy } from './ziggy'
import DefaultLayout from '@/layouts/Default.vue'
import 'floating-vue/dist/style.css'

const pinia = createPinia()
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'RMS'

createInertiaApp({
  title: title => `${title} - ${appName}`,
  // resolve: name => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')),
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
      .use(plugin)
      .use(pinia)
      .use(HighchartsVue)
      .use(ZiggyVue, Ziggy)
      .use(FloatingVue, {
        container: '#app',
        themes: {
          tooltip: {
            // Default tooltip placement relative to target element
            placement: 'top',
            // Default events that trigger the tooltip
            triggers: ['hover', 'focus', 'touch'],
            // Close tooltip on click on tooltip target
            hideTriggers: events => [...events, 'click'],
            // Delay (ms)
            delay: {
              show: 200,
              hide: 100000,
            },
            // Update popper on content resize
            handleResize: false,
            // Enable HTML content in directive
            html: false,
            // Displayed when tooltip content is loading
            loadingContent: '...',
          },
        },
      })

      .component('Link', Link)
      .component('Head', Head)

      .mount(el)
  },
})

// init area
exportingInit(Highcharts)

InertiaProgress.init({
  color: '#3b82f6',
  showSpinner: true,
})
