import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { Head, createInertiaApp } from '@inertiajs/inertia-vue3'
import createServer from '@inertiajs/server'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import HighchartsVue from 'highcharts-vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'RMS'

createServer(page =>
  createInertiaApp({
    page,
    render: renderToString,
    title: title => `${title} - ${appName}`,
    resolve: name => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')),
    setup({ app, props, plugin }) {
      return createSSRApp({ render: () => h(app, props) })
        .use(plugin)
        .use(HighchartsVue, { tagName: 'highcharts' })
        .use(ZiggyVue, {
          ...page.props.ziggy,
          location: new URL(page.props.ziggy.location),
        })
        .component('Head', Head)
    },
  }),
)
