import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import createServer from '@inertiajs/server'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createHead } from '@vueuse/head'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'

// const appName = 'RMS'
const head = createHead()
createServer(page =>
  createInertiaApp({
    page,
    render: renderToString,
    // title: title => `${title} - ${appName}`,
    resolve: name => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')),
    setup({ app, props, plugin }) {
      return createSSRApp({ render: () => h(app, props) })
        .use(plugin)
        .use(head)
        .use(ZiggyVue, {
          ...page.props.ziggy,
          location: new URL(page.props.ziggy.location),
        })
    },
  }),
)
