<script setup>
const faqs = [
  {
    id: 1,
    question: 'How do I place an order?',
    answer:
      'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa libero labore natus.',

  },
  {
    id: 2,
    question: 'Do you offer Saturday delivery?',
    answer: 'Yes, we offer Saturday delivery.',
  },
  {
    id: 3,
    question: 'Can I find out at what time my order will be delivered?',
    answer:
      'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa libero labore natus.',
  },
  {
    id: 4,
    question: 'What is your return policy?',
    answer:
      'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa libero labore natus.',
  },
  {
    id: 5,
    question: 'How do I track my order?',
    answer:
      'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa libero labore natus.',
  },
  {
    id: 6,
    question: 'How do I cancel my order?',
    answer:
      'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa libero labore natus.',
  },
  {
    id: 7,
    question: 'How do I return an item?',
    answer:
      'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa libero labore natus.',
  },
  {
    id: 8,
    question: 'How do I change my order?',
    answer:
      'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa libero labore natus.',
  },
]
</script>

<template>
  <div class="bg-white">
    <div class="mx-auto max-w-7xl py-16 px-6 sm:py-24 lg:px-8">
      <div class="max-w-2xl lg:mx-auto lg:text-center">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          Frequently asked questions
        </h2>
        <p class="mt-4 text-gray-500">
          Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla nec. Urna, sed a lectus elementum blandit et.
        </p>
      </div>
      <div class="mt-20">
        <dl class="space-y-10 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:gap-y-10 lg:space-y-0">
          <div v-for="faq in faqs" :key="faq.id">
            <dt class="font-semibold text-gray-900">
              {{ faq.question }}
            </dt>
            <dd class="mt-3 text-gray-500">
              {{ faq.answer }}
            </dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</template>
