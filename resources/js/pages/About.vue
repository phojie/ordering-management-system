<script setup>
const people = [
  {
    name: 'Edralyn Q. Uga',
    role: 'Owner / Manager',
    imageUrl: '/images/owner.jpg',
    bio: 'Owner and manager of Ronalds Catering & Services',
    facebookUrl: 'https://www.facebook.com/edralyn.uga',
    emailUrl: 'edralyn_73@yahoo.com',
  },
]
</script>

<template>
  <div class="bg-white">
    <div class="px-6 py-12 mx-auto max-w-7xl lg:px-8 lg:py-24">
      <div class="space-y-12 lg:grid lg:grid-cols-3 lg:gap-8 lg:space-y-0">
        <div class="space-y-5 sm:space-y-4">
          <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">
            About Us
          </h2>
          <p class="text-xl text-gray-500">
            Ronalds Catering is one of biggest food catering business in Lanao del Norte, with a strict adherence to the highest standards of food quality, service and cleanliness, Ronalds Catering serves great-tasting, high-quality and affordable food products since 2017. We are currently located along the National Highway beside of Tubod Glass & Aluminum Supply, Purok 1, Sto.Niño Village, Baroy, Lanao del Norte. A dominant market leader in Lanao del Norte.
          </p>
        </div>
        <div class="lg:col-span-2">
          <ul role="list" class="space-y-12 sm:-mt-8 sm:space-y-0 sm:divide-y sm:divide-gray-200 lg:gap-x-8 lg:space-y-0">
            <li v-for="person in people" :key="person.name" class="sm:py-8">
              <div class="space-y-4 sm:grid sm:grid-cols-3 sm:items-start sm:gap-6 sm:space-y-0">
                <div class="aspect-w-3 aspect-h-2 sm:aspect-w-3 sm:aspect-h-4">
                  <img class="object-cover rounded-lg shadow-lg" :src="person.imageUrl" alt="">
                </div>
                <div class="sm:col-span-2">
                  <div class="space-y-4">
                    <div class="space-y-1 text-lg font-medium leading-6">
                      <h3>{{ person.name }}</h3>
                      <p class="text-primary-600">
                        {{ person.role }}
                      </p>
                    </div>
                    <div class="text-lg">
                      <p class="text-gray-500">
                        {{ person.bio }}
                      </p>
                    </div>
                    <ul role="list" class="flex space-x-5">
                      <li>
                        <a :href="person.facebookUrl" class="text-gray-400 hover:text-gray-500">
                          <span class="sr-only">Facebook</span>
                          <brandico-facebook-rect class="w-5 h-5" />
                        </a>
                      </li>
                      <li>
                        <a :href="`mailto:${person.emailUrl}`" class="text-gray-400 hover:text-gray-500">
                          <span class="sr-only">Email</span>
                          <material-symbols-attach-email class="w-6 h-6" />
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
