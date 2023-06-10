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
import vSelect from 'vue-select'
import VueFilePond from 'vue-filepond'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import FilePondPluginFilePoster from 'filepond-plugin-file-poster'
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
import FilePondPluginImageResize from 'filepond-plugin-image-resize'
import { MotionPlugin } from '@vueuse/motion'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import { Ziggy } from './ziggy'
import HeroiconsXMark20Solid from '~icons/heroicons/x-mark-20-solid'
import IcRoundArrowDropDown from '~icons/ic/round-arrow-drop-down'
import DefaultLayout from '@/layouts/Default.vue'

// floating vue
import 'floating-vue/dist/style.css'

// v-select
import 'vue-select/dist/vue-select.css'

// file pond
import 'filepond/dist/filepond.min.css'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'
import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css'
import 'floating-vue/dist/style.css'
import 'vue-select/dist/vue-select.css'

//  to be added ...
// import FilePondPluginImageCrop from 'filepond-plugin-image-crop'
// import FilePondPluginImageTransform from 'filepond-plugin-image-transform'

const FilePond = VueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFilePoster,
  FilePondPluginFileValidateSize,
  FilePondPluginImageResize,
)

const pinia = createPinia()
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'RMS'

// set default settings to v-select
vSelect.props.components.default = () => ({
  Deselect: {
    render: () => h(HeroiconsXMark20Solid, {
      class: {
        'ml-3 hover:text-danger-500 text-gray-400 w-4 h-4': true,
      },
    }),
  },
  OpenIndicator: {
    render: () => h(IcRoundArrowDropDown, {
      class: {
        'text-gray-400 w-7 h-7': true,
      },
    }),
  },
})

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
        distance: 10,
        themes: {
          tooltip: {
            // reset
            $resetCss: true,
          },
        },
      })
      .use(MotionPlugin)

      .component('FilePond', FilePond)
      .component('Link', Link)
      .component('Head', Head)
      .component('VSelect', vSelect)

      .mount(el)
  },
})

// init area

exportingInit(Highcharts)

InertiaProgress.init({
  color: '#3b82f6',
  showSpinner: true,
})
