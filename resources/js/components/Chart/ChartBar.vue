<script setup lang="ts">
// import { Chart as Highcharts } from 'highcharts-vue'
const data = ref({
  categories: [],
  series: [],
  title: 'Orders per item',
  subtitle: 'Realtime data',
})

// computed
const chartOptions = reactive({
  accessibility: {
    enabled: false,
  },
  chart: {
    type: 'column',
    height: '500px',
  },
  xAxis: {
    categories: data.value.categories,
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Items',
    },
    gridLineDashStyle: 'shortdot',
  },
  credits: {
    href: 'https://pobtubodldn.com/',
    text: 'src: https://www.Pobtubodldn.com',
  },
  legend: {
    enabled: false,
  },
  title: {
    text: data.value.title,
  },
  subtitle: {
    text: data.value.subtitle,
  },
  plotOptions: {
    series: {
      // borderWidth: 06366F1,
    },
  },
  tooltip: {
    headerFormat: '<b>{series.name}</b><br/>',
    pointFormat: '{point.category}: {point.y}',
    borderColor: '#ec4899',
  },
  series: [
    {
      name: 'Total Population',
      data: data.value.series,
      dataLabels: {
        enabled: true,
        style: {
          textOutline: false,
        },
        // rotation: -90,
        align: 'right',
        // format: '{point.y:.0f}', // one decimal
        // // y: 10, // 10 pixels down from the top
        // style: {
        //   fontSize: '1rem',
        //   fontWeight: '600',
        //   fontFamily: 'Jost',
        // },
      },
    },
  ],
},
)
</script>

<template>
  <highcharts :options="chartOptions" :modules="['exporting']" />
</template>

<style lang="postcss">
rect.highcharts-point.highcharts-color-0 {
  @apply !fill-current !text-primary-500;
}
svg.highcharts-root {
  @apply !font-sans;
}

text.highcharts-credits {
  @apply hidden;
}

/* -- */
text.highcharts-title {
  @apply !fill-current !text-gray-900;
}
.dark text.highcharts-title {
  @apply !fill-current !text-white;
}

/* -- */
svg rect.highcharts-background,
svg rect.highcharts-plot-background {
  @apply fill-current text-white;
}

.dark svg rect.highcharts-background,
.dark svg rect.highcharts-plot-background {
  @apply fill-current text-gray-800;
}

/* -- */
svg .highcharts-data-label text {
  @apply !fill-current !text-gray-900;
}
.dark svg .highcharts-data-label text {
  @apply !fill-current !text-gray-50;
}

/* -- */
svg text {
  @apply !fill-current !text-gray-800;
}
.dark svg text {
  @apply !fill-current !text-gray-100;
}

/* -- */
svg .highcharts-grid.highcharts-yaxis-grid .highcharts-grid-line {
  @apply !stroke-current !text-gray-400;
}
.dark svg .highcharts-grid.highcharts-yaxis-grid .highcharts-grid-line {
  @apply !stroke-current !text-gray-600;
}

/* -- */
svg .highcharts-tooltip .highcharts-label-box.highcharts-tooltip-box {
  @apply !fill-current !text-gray-50;
}
.dark svg .highcharts-tooltip .highcharts-label-box.highcharts-tooltip-box {
  @apply !fill-current !text-gray-800;
}

/* -- */
svg .highcharts-button-box {
  @apply !fill-current !text-transparent;
}

/* -- */
svg .highcharts-button-symbol {
  @apply !stroke-current !text-gray-700;
}
.dark svg .highcharts-button-symbol {
  @apply !stroke-current !text-gray-300;
}

/* -- */
/* svg .highcharts-point {
  @apply stroke-current !text-gray-500;
} */
</style>