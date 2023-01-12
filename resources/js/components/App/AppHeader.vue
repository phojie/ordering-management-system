<script  setup lang="ts">
const currencies = ['PHP']

interface featuredItem {
  name: string
  href: string
  imageSrc: string
  imageAlt: string
}

const navigation = {
  categories: [
    {
      name: 'Category',
      featured: [] as Array<featuredItem>,
      exploreHref: 'categories.index',
    },
    {
      name: 'Products',
      featured: [] as Array<featuredItem>,
      exploreHref: 'products.index',
    },
  ],
  pages: [
    { name: 'Contact us', href: 'contact-us' },
    { name: 'About', href: 'about' },
  ],
}

onMounted(async () => {
  await useFetch(route('components.categories.random')).get().json().then(({ data }) => {
    // map data
    navigation.categories[0].featured = _.map(data.value, (category) => {
      return {
        name: category.name,
        href: route('categories.show', {
          slug: category.slug,
        }),
        imageSrc: category.image,
        imageAlt: category.name,
      }
    }) as Array<{ name: string; href: string; imageSrc: string; imageAlt: string }>
  })

  await useFetch(route('components.products.random')).get().json().then(({ data }) => {
    // map data
    navigation.categories[1].featured = _.map(data.value, (product) => {
      return {
        name: product.name,
        href: route('products.show', {
          slug: product.slug,
        }),
        imageSrc: product.image,
        imageAlt: product.name,
      }
    })
  })
})
</script>

<template>
  <header class="relative">
    <nav aria-label="Top">
      <!-- Top navigation -->
      <div class="bg-gray-900">
        <div
          class="flex items-center justify-between h-10 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8"
        >
          <!-- Currency selector -->
          <form>
            <div>
              <label for="desktop-currency" class="sr-only">Currency</label>
              <div
                class="relative -ml-2 bg-gray-900 border-transparent rounded-md group focus-within:ring-2 focus-within:ring-white"
              >
                <select
                  id="desktop-currency"
                  name="currency"
                  class="flex items-center rounded-md border-transparent bg-gray-900 bg-none py-0.5 pl-2 pr-5 text-sm font-medium text-white focus:border-transparent focus:outline-none focus:ring-0 group-hover:text-gray-100"
                >
                  <option v-for="currency in currencies" :key="currency">
                    {{ currency }}
                  </option>
                </select>
                <div
                  class="absolute inset-y-0 right-0 flex items-center pointer-events-none"
                >
                  <heroicons-chevron-down
                    class="w-5 h-5 text-gray-300"
                    aria-hidden="true"
                  />
                </div>
              </div>
            </div>
          </form>

          <div v-if="!useAuthStore().signedIn" class="flex items-center space-x-6">
            <JLink
              :to="route('login')"
              class="text-sm font-medium text-white hover:text-gray-100"
            >
              Sign in
            </JLink>
            <JLink
              :to="route('register')"
              class="text-sm font-medium text-white hover:text-gray-100"
            >
              Create an account
            </JLink>
          </div>
          <div v-else class="flex items-center space-x-6">
            <JLink
              v-if="useGate().can('Customer')"
              :to="route('customer.orders.index')"
              class="text-sm font-medium text-white hover:text-gray-100"
            >
              Orders
            </JLink>

            <JLink
              v-if="useGate().can('Customer')"
              :to="route('customer.settings.index')"
              class="text-sm font-medium text-white hover:text-gray-100"
            >
              My Account
            </JLink>

            <JLink
              v-if="useGate().can('Admin')"
              :to="route('admin.index')"
              class="text-sm font-medium text-white hover:text-gray-100"
            >
              Administrator
            </JLink>
          </div>
        </div>
      </div>

      <!-- Secondary navigation -->
      <div class="bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="flex items-center justify-between h-16">
            <!-- Logo (lg+) -->
            <div class="hidden lg:flex lg:flex-1 lg:items-center">
              <JLink :to="route('index')">
                <AppIcon class="p-1 rounded w-14 h-14" alt="." />
              </JLink>
            </div>

            <div class="hidden h-full lg:flex">
              <!-- Flyout menus -->
              <PopoverGroup class="inset-x-0 bottom-0 px-4">
                <div class="flex justify-center h-full space-x-8">
                  <JLink
                    :to="route('index')"
                    class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800"
                  >
                    Home
                  </JLink>

                  <Popover
                    v-for="category in navigation.categories"
                    :key="category.name"
                    v-slot="{ open }"
                    class="flex"
                  >
                    <div class="relative flex">
                      <PopoverButton
                        class="relative flex items-center justify-center text-sm font-medium transition-colors duration-200 ease-out outline-none"
                        :class="[
                          open ? 'text-primary-600' : 'text-gray-700 hover:text-gray-800',
                        ]"
                      >
                        {{ category.name }}
                        <span
                          class="absolute inset-x-0 -bottom-px z-20 h-0.5 transition duration-200 ease-out"
                          :class="[open ? 'bg-primary-600' : '']"
                          aria-hidden="true"
                        />
                      </PopoverButton>
                    </div>

                    <transition
                      enter-active-class="transition duration-200 ease-out"
                      enter-from-class="opacity-0"
                      enter-to-class="opacity-100"
                      leave-active-class="transition duration-150 ease-in"
                      leave-from-class="opacity-100"
                      leave-to-class="opacity-0"
                    >
                      <PopoverPanel
                        v-slot="{ close }"
                        class="absolute inset-x-0 z-10 text-sm text-gray-500 bg-white top-full"
                      >
                        <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                        <div
                          class="absolute inset-0 bg-white shadow top-1/2"
                          aria-hidden="true"
                        />
                        <!-- Fake border when menu is open -->
                        <div
                          class="absolute inset-0 top-0 h-px px-8 mx-auto max-w-7xl"
                          aria-hidden="true"
                        >
                          <div
                            class="w-full h-px transition-colors duration-200 ease-out"
                            :class="[open ? 'bg-gray-200' : 'bg-transparent']"
                          />
                        </div>

                        <div class="relative">
                          <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                            <div class="grid grid-cols-4 py-16 gap-y-10 gap-x-8">
                              <div
                                v-for="product in category.featured"
                                :key="product.name"
                                class="relative group"
                                @click="close"
                              >
                                <div
                                  class="overflow-hidden bg-gray-100 rounded-md aspect-w-1 aspect-h-1 group-hover:opacity-75"
                                >
                                  <img
                                    :src="product.imageSrc"
                                    :alt="product.imageAlt"
                                    class="object-cover object-center"
                                  >
                                </div>
                                <JLink
                                  :to="product.href"
                                  class="block mt-4 font-medium text-gray-900"
                                >
                                  <span
                                    class="absolute inset-0 z-10"
                                    aria-hidden="true"
                                  />
                                  {{ product.name }}
                                </JLink>
                                <p aria-hidden="true" class="mt-1">
                                  Shop now
                                </p>
                              </div>
                              <div
                                class="relative grid overflow-hidden bg-gray-100 rounded-md place-items-center group group-hover:opacity-75"
                                @click="close"
                              >
                                <div class="flex flex-col space-y-10">
                                  <img
                                    src="/svgs/explore-arrow.svg"
                                    alt="Explore more"
                                    class="bg-blend-darken"
                                  >
                                  <JLink
                                    :to="route(category.exploreHref)"
                                    class="block mt-4 font-medium text-gray-900 group-hover:text-primary-500"
                                  >
                                    <span
                                      class="absolute inset-0 z-10"
                                      aria-hidden="true"
                                    />
                                    Explore more
                                  </JLink>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </PopoverPanel>
                    </transition>
                  </Popover>

                  <JLink
                    v-for="page in navigation.pages"
                    :key="page.name"
                    :to="route(page.href)"
                    class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800"
                  >
                    {{ page.name }}
                  </JLink>
                </div>
              </PopoverGroup>
            </div>

            <!-- Mobile menu and search (lg-) -->
            <div class="flex items-center flex-1 lg:hidden">
              <!-- <button type="button" class="p-2 -ml-2 text-gray-400 bg-white rounded-md" @click="open = true">
                  <span class="sr-only">Open menu</span>
                  <heroicons-bars-3 class="w-6 h-6" aria-hidden="true" />
                </button> -->

              <!-- Logo (mobile-) -->
              <JLink v-if="useRoute().currentRoute !== 'login'" :to="route('index')" class="lg:hidden">
                <AppIcon class="w-auto h-14" alt="." />
              </JLink>

              <!-- Search -->
              <JLink :to="route('products.index')" class="p-2 -ml-2 text-gray-400 hover:text-gray-500">
                <span class="sr-only">Search</span>
                <heroicons-magnifying-glass class="w-6 h-6" aria-hidden="true" />
              </JLink>
            </div>

            <div class="flex items-center justify-end flex-1">
              <JLink
                :to="route('products.index')"
                class="hidden text-sm font-medium text-gray-700 hover:text-gray-800 lg:block"
              >
                Search
              </JLink>

              <div class="flex items-center lg:ml-8">
                <JLink :to="route('about')" class="p-2 text-gray-400 hover:text-gray-500 lg:hidden">
                  <span class="sr-only">About us</span>
                  <heroicons-information-circle class="w-6 h-6" aria-hidden="true" />
                </JLink>
                <JLink :to="route('contact-us')" class="p-2 text-gray-400 hover:text-gray-500 lg:hidden">
                  <span class="sr-only">Contact us</span>
                  <heroicons-phone class="w-6 h-6" aria-hidden="true" />
                </JLink>
                <JLink :to="route('help')" class="p-2 text-gray-400 hover:text-gray-500 lg:hidden">
                  <span class="sr-only">Help</span>
                  <heroicons-question-mark-circle class="w-6 h-6" aria-hidden="true" />
                </JLink>
                <JLink
                  :to="route('help')"
                  class="hidden text-sm font-medium text-gray-700 hover:text-gray-800 lg:block"
                >
                  Help
                </JLink>

                <!-- Cart -->
                <div class="flow-root ml-4 lg:ml-8">
                  <JLink :to="route('customer.carts.index')" class="flex items-center p-2 -m-2 group">
                    <heroicons-shopping-cart
                      class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-gray-500"
                      aria-hidden="true"
                    />
                    <span
                      class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800"
                    >{{ $page.props.cartCount ?? 0 }}</span>
                    <span class="sr-only">products in cart, view bag</span>
                  </JLink>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>
