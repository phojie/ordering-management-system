import { defineConfig } from 'vite'
import Laravel from 'laravel-vite-plugin'
import Vue from '@vitejs/plugin-vue'
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import Icons from 'unplugin-icons/vite'
import IconsResolver from 'unplugin-icons/resolver'
import VueMacros from 'unplugin-vue-macros/vite'
// import { VitePWA } from 'vite-plugin-pwa'

import { HeadlessUiResolver, VueUseComponentsResolver } from 'unplugin-vue-components/resolvers'

export default defineConfig({
  plugins: [
    Laravel({
      input: 'resources/js/app.js',
      ssr: 'resources/js/ssr.js',
      refresh: true,
    }),
    Vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
      reactivityTransform: true,
    }),
    AutoImport({
      // targets to transform
      include: [
        /\.[tj]sx?$/, // .ts, .tsx, .js, .jsx
        /\.vue$/, /\.vue\?vue/, // .vue
        /\.md$/, // .md
      ],

      // global imports to register
      imports: [
        // presets
        'vue',
        '@vueuse/core',
        {
          '@inertiajs/inertia-vue3': [
            'useForm',
            'usePage',
          ],
          '@vuelidate/core': [
            'useVuelidate',
          ],
          '@inertiajs/inertia': [
            'Inertia',
          ],
          'highcharts-vue': [
            ['Chart', 'highcharts'],
          ],
          'lodash': [
            ['*', '_'],
          ],
          'ziggy-js': [
            ['default', 'route'],
          ],
          'pinia': [
            'defineStore',
            'acceptHMRUpdate',
          ],
          '@/layouts/AdminLayout.vue': [
            ['default', 'AdminLayout'],
          ],
        },
      ],

      // Auto import for module exports under directories
      // by default it only scan one level of modules under the directory
      dirs: [
        'resources/js/store/',
        'resources/js/composables/*',
        'resources/js/composables/*/**',
        'resources/js/j-components/',
      ],

      // Filepath to generate corresponding .d.ts file.
      // Defaults to './auto-imports.d.ts' when `typescript` is installed locally.
      // Set `false` to disable.
      dts: 'resources/js/auto-imports.d.ts',

      // Auto import inside Vue template
      // see https://github.com/unjs/unimport/pull/15 and https://github.com/unjs/unimport/pull/72
      vueTemplate: true,

      // see https://github.com/antfu/unplugin-auto-import/pull/23/
      resolvers: [
        /* ... */
      ],

      // Generate corresponding .eslintrc-auto-import.json file.
      // eslint globals Docs - https://eslint.org/docs/user-guide/configuring/language-options#specifying-globals
      eslintrc: {
        enabled: false, // Default `false`
        filepath: 'resources/js/.eslintrc-auto-import.json', // Default `./.eslintrc-auto-import.json`
        globalsPropValue: true, // Default `true`, (true | false | 'readonly' | 'readable' | 'writable' | 'writeable')
      },
    }),
    Components({
      // relative paths to the directory to search for components.
      dirs: [
        'resources/js/components/**',
        'resources/js/j-components/**',
      ],
      dts: 'resources/js/components.d.ts',
      types: [
        {
          from: 'highcharts-vue',
          names: ['Chart', 'highcharts'],
        // alias
        },
      ],
      resolvers: [
        HeadlessUiResolver(),
        IconsResolver({
          prefix: false,
        }),
        VueUseComponentsResolver(),
      ],
    }),
    Icons({
      compiler: 'vue3',
      autoInstall: true,
      scale: 1.6,
    }),
    VueMacros(),
    // VitePWA(),
  ],
  ssr: {
    noExternal: ['@inertiajs/server'],
  },
})
