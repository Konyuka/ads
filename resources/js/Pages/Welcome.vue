<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import axios from "axios";

const props = defineProps({
  ad: Object,
  images: Array,
  relatedAds: Array,
  relatedAdsImages: Array,
});

const currentIndex = ref(0)
const openMenu = ref(false)
const form = useForm({
  fname: null,
  lname: null,
  email: null,
  phone: null,
  message: null,
})

const currentImageUrl = computed(() => {
  return props.images[currentIndex.value].file_name
});

const currentImageUrl2 = computed(() => {
  const count = props.images.length - 1
  if (currentIndex.value == count) {
    return props.images[currentIndex.value].file_name
  } else {
    return props.images[currentIndex.value + 1].file_name
  }
});

onMounted(() => {
  // typeof(props.ad, props.images, props.relatedAds, props.relatedAdsImages)
});

const amenities = computed(() => {
  return JSON.parse(props.ad.amenities)
})

const removeTags = (str) => {
  if ((str === null) || (str === '')) {
    return false;
  } else {
    str = str.toString();
    return str.replace(/(<([^>]+)>)/ig, '');
  }
}

const getMap = (map) => {
  if (map != null) {
    const str = map;
    const srcRegex = /src="(.+?)"/;
    const srcValue = str.match(srcRegex)[1];
    return srcValue
  }
}

const formatMoney = (x) => {
  let number = x;
  let nf = new Intl.NumberFormat("en-US");
  return nf.format(number);
}

const slider = (direction) => {
  const count = props.images.length - 1
  if (direction == "next") {
    if (currentIndex.value == count) {
      currentIndex.value = 0
    } else {
      currentIndex.value++
    }
  }
  if (direction == "previous") {
    if (currentIndex.value == 0) {
      currentIndex.value = count
    } else {
      currentIndex.value--
    }
  }

}

const getRelatedImages = (adNumber) => {
  const rightImage = props.relatedAdsImages.find(item => item.productID === adNumber);
  const normalObj = Object.assign({}, rightImage);
  if (normalObj != undefined) {
    const link = normalObj.file_name
    return 'https://crm.rochman-properties.co.ke/public/media/products/' + link
  }
}

const send = () => {

  axios
    .get('/mail')
    .then((response) => {
      // topics.value = response.data;
      console.log(response.data)
    })
    .catch((error) => console.log(error));

  // this.$Inertia.get("/mail");

  // form.post(route(mail), {
  //   // preserveScroll: true,
  //   // onSuccess: () => {
  //   //   form.reset();
  //   //   alert("Product Added");
  //   // },
  // });

  // form.post('/mail', {
  //   preserveScroll: true,
  //   onSuccess: () => form.reset(),
  // })
}

</script>


<template>
  <Head title="Welcome" />

  <div class="bg-white mt-10">

    <header class="bg-white shadow-xl fixed inset-x-0 top-0 z-50">
      <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
          <a href="#" class="shadow-xl -m-1.5 p-1.5">
            <span class="sr-only">Your Company</span>
            <img class=" h-16 w-auto" src="/img/logo.png" alt="">
          </a>
        </div>
        <div class="flex lg:hidden">
          <button @click="openMenu = !openMenu" type="button"
            class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
            <span class="sr-only">Open main menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
              aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
          </button>
        </div>

        <div class="hidden lg:flex lg:gap-x-12">
          <a href="https://rochman-properties.co.ke/"
            class="transform translate hover:scale-150 duration-700 ease-in-out text-lg font-extrabold leading-6 text-black hover:text-green-700">
            HOME
          </a>
          <a href="https://rochman-properties.co.ke/properties/type/land-for-sale"
            class="transform translate hover:scale-150 duration-700 ease-in-out text-lg font-extrabold leading-6 text-black hover:text-green-700">
            LAND
          </a>
          <a href="https://rochman-properties.co.ke/properties/type/for-sale"
            class="transform translate hover:scale-150 duration-700 ease-in-out text-lg font-extrabold leading-6 text-black hover:text-green-700">
            APARTMENTS
          </a>
          <a href="https://rochman-properties.co.ke/about-us"
            class="transform translate hover:scale-150 duration-700 ease-in-out text-xl font-semibold leading-6 text-black hover:text-green-700">
            ABOUT US</a>
          <a href="https://rochman-properties.co.ke/contact-us"
            class="transform translate hover:scale-150 duration-700 ease-in-out text-xl font-semibold leading-6 text-black hover:text-green-700">
            CONTACTS</a>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
          <!-- <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a> -->
        </div>
      </nav>

      <!-- Mobile menu, show/hide based on menu open state. -->
      <div v-if="openMenu" class="lg:hidden" role="dialog" aria-modal="true">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class="fixed inset-0 z-50"></div>
        <div
          class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
          <div class="flex items-center justify-between">
            <a href="#" class="-m-1.5 p-1.5">
              <span class="sr-only">Your Company</span>
              <img class="h-8 w-auto" src="/img/logo.png" alt="">
            </a>
            <button @click="openMenu = !openMenu" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
              <span class="sr-only">Close menu</span>
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10">
              <div class="space-y-2 py-6">
                <a href="https://rochman-properties.co.ke/"
                  class="-mx-3 block rounded-lg py-2 px-3 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">HOME</a>

                <a href="https://rochman-properties.co.ke/properties/type/land-for-sale"
                  class="-mx-3 block rounded-lg py-2 px-3 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">LAND</a>

                <a href="https://rochman-properties.co.ke/properties/type/to-let"
                  class="-mx-3 block rounded-lg py-2 px-3 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">APARTMENTS</a>

                <a href="https://rochman-properties.co.ke/about-us"
                  class="-mx-3 block rounded-lg py-2 px-3 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">ABOUT</a>

                <a href="https://rochman-properties.co.ke/contact-us"
                  class="-mx-3 block rounded-lg py-2 px-3 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">CONTACTS</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </header>

    <div class="bg-gray-50 mt-32 z-10">
      <div class="">

        <!-- Image gallery -->
        <div class="py-7 relative w-auto">
          <!-- Carousel wrapper -->
          <!-- <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                        <div class="">
                          <img :src="`https://crm.rochman-properties.co.ke/public/media/products/${currentImageUrl}`"
                            class="object-none absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                        </div>
                      </div> -->

          <div class="px-2 sm:px-32 grid gap-4">
            <h1
              class="mb-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
              {{ ad.product_name }}
            </h1>

            <div class="grid grid-cols-2 gap-4">
              <img class="shadow-2xl object-cover  block h-auto max-w-full rounded-lg"
                :src="`https://crm.rochman-properties.co.ke/public/media/products/${currentImageUrl}`" alt="">
              <img class="shadow-2xl object-cover  block h-auto max-w-full rounded-lg"
                :src="`https://crm.rochman-properties.co.ke/public/media/products/${currentImageUrl2}`" alt="">
            </div>


            <div class="grid grid-cols-5 gap-4">
              <div v-for="(image, index) in images" :key="index">
                <img class="shadow-2xl h-auto max-w-full rounded-lg"
                  :src="`https://crm.rochman-properties.co.ke/public/media/products/${image.file_name}`" alt="">
              </div>
            </div>
          </div>



          <button @click="slider('previous')" type="button"
            class="transform translate hover:scale-150 duration-700 ease-in-out absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
            <span
              class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
              <svg aria-hidden="true" class="w-5 h-5 text-green-700 sm:w-10 sm:h-10 dark:text-gray-800" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
              <span class="sr-only">Previous</span>
            </span>
          </button>

          <button @click="slider('next')" type="button"
            class="transform translate hover:scale-150 duration-700 ease-in-out absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
            <span
              class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
              <svg aria-hidden="true" class="w-5 h-5 text-green-700 sm:w-10 sm:h-10 dark:text-gray-800" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
              <span class="sr-only">Next</span>
            </span>
          </button>

        </div>

        <!-- Product info -->
        <div
          class="mx-auto max-w-2xl px-4 pt-10 pb-16 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pt-16 lg:pb-24">
          <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
              {{ ad.product_name }}
            </h1>
          </div>

          <!-- Options -->
          <div class="mt-4 lg:row-span-3 lg:mt-0">
            <h2 class="sr-only">Product information</h2>
            <p class="text-3xl tracking-tight text-gray-900">KES {{ formatMoney(ad.price) }}</p>

            <div v-if="ad.type == 'House'">
              <div class="mt-10">
                <h2 class="text-lg font-bold text-gray-900">Amenities</h2>

                <div class="mt-4 space-y-2">

                  <button v-for="item in amenities" data-tooltip-target="tooltip-light" data-tooltip-style="light"
                    type="button"
                    class="mr-2 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{ item }}
                  </button>
                </div>
              </div>

              <div class="mb-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pt-6 lg:pr-8">
                <!-- Description and details -->
                <div>


                  <div class="mt-10">
                    <div>
                      <ul role="list" class="mt-3 grid grid-cols-2 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-2">
                        <li class="shadow-xl col-span-1 flex rounded-md shadow-sm">
                          <div
                            class="flex w-16 flex-shrink-0 items-center justify-center bg-black rounded-l-md text-sm font-medium text-white">
                            <i class="text-xs fas fa-bed text-green-600"></i>
                          </div>
                          <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-2 text-xs">
                              <a href="#" class="font-medium text-gray-900 hover:text-gray-600">Bedrooms</a>
                              <p class="text-gray-500">{{ ad.bedrooms }}</p>
                            </div>
                          </div>
                        </li>

                        <li class="shadow-xl col-span-1 flex rounded-md shadow-sm">
                          <div
                            class="flex w-16 flex-shrink-0 items-center justify-center bg-black rounded-l-md text-sm font-medium text-white">
                            <i class="fas fa-shower text-green-600"></i>
                          </div>
                          <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-2 text-xs">
                              <a href="#" class="font-medium text-gray-900 hover:text-gray-600">Bathrooms</a>
                              <p class="text-gray-500">{{ ad.bathrooms }}</p>
                            </div>
                          </div>
                        </li>

                        <li class="shadow-xl col-span-1 flex rounded-md shadow-sm">
                          <div
                            class="flex w-16 flex-shrink-0 items-center justify-center bg-black rounded-l-md text-sm font-medium text-white">
                            <i class="fas fa-warehouse text-green-600"></i>
                          </div>
                          <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-2 text-xs">
                              <a href="#" class="font-medium text-gray-900 hover:text-gray-600">Garadge</a>
                              <p class="text-gray-500">{{ ad.garadge }}</p>
                            </div>
                          </div>
                        </li>

                        <li class="shadow-xl col-span-1 flex rounded-md shadow-sm">
                          <div
                            class="flex w-16 flex-shrink-0 items-center justify-center bg-black rounded-l-md text-sm font-medium text-white">
                            <i class="fas fa-layer-group text-green-600"></i>
                          </div>
                          <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-2 text-xs">
                              <a href="#" class="font-medium text-gray-900 hover:text-gray-600">Size</a>
                              <p class="text-gray-500">{{ ad.size }}</p>
                            </div>
                          </div>
                        </li>

                        <li class="shadow-xl col-span-1 flex rounded-md shadow-sm">
                          <div
                            class="flex w-16 flex-shrink-0 items-center justify-center bg-black rounded-l-md text-sm font-medium text-white">
                            <i class="fas fa-building-flag text-green-600"></i>
                          </div>
                          <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-2 text-xs">
                              <a href="#" class="font-medium text-gray-900 hover:text-gray-600">Stories</a>
                              <p class="text-gray-500">{{ ad.stories }}</p>
                            </div>
                          </div>
                        </li>

                        <li class="shadow-xl col-span-1 flex rounded-md shadow-sm">
                          <div
                            class="flex w-16 flex-shrink-0 items-center justify-center bg-black rounded-l-md text-sm font-medium text-white">
                            <i class="fas fa-arrow-up-wide-short text-green-600"></i>
                          </div>
                          <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-2 text-xs">
                              <a href="#" class="font-medium text-gray-900 hover:text-gray-600">Type</a>
                              <p class="text-gray-500">{{ ad.type }}</p>
                            </div>
                          </div>
                        </li>


                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>


          </div>

          <div class="lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pt-6 lg:pr-8">
            <!-- Description and details -->
            <div>
              <h3 class="sr-only">Description</h3>

              <div class="space-y-6">
                <p class="text-base text-gray-900">
                  {{ removeTags(ad.description) }}
                </p>
              </div>




            </div>


          </div>

        </div>
      </div>
    </div>

    <!-- map -->
    <div class="p-3 sm:p-10">
      <section class="text-gray-600 body-font relative p-10">
        <div class="absolute inset-0 bg-gray-300">
          <iframe width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0" title="map" scrolling="no"
            :src="getMap(ad.map)" style="">
          </iframe>
        </div>
        <div class="container px-5 py-24 mx-auto flex">
          <div
            class="lg:w-1/3 md:w-1/2 bg-white rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0 relative z-10 shadow-md">
            <div class="relative mb-4">
            </div>
            <div class="relative mb-4">
            </div>
            <button
              class="text-white bg-green-700 border-0 py-1 sm:py-2 px-1 sm:px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">
              View on Google Maps
            </button>
          </div>
        </div>
      </section>
    </div>

    <div class="mb-10 relative isolate bg-white">
      <div class="mx-auto grid max-w-7xl grid-cols-1 lg:grid-cols-2">

        <div class="shadow-2xl px-6 pb-24 sm:pb-32 lg:py-28 lg:px-8">
          <h2 class="mb-16 ml-14 text-6xl font-bold tracking-tight text-gray-900">Enquiries</h2>
          <form method="POST" class="">
            <div class="mx-auto max-w-xl lg:mr-0 lg:max-w-lg">
              <div class="grid grid-cols-1 gap-y-6 gap-x-8 sm:grid-cols-2">
                <div>
                  <label for="first-name" class="block text-sm font-semibold leading-6 text-gray-900">First name</label>
                  <div class="mt-2.5">
                    <input v-model="form.fname" type="text" name="first-name" id="first-name" autocomplete="given-name"
                      class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <div v-if="form.errors.fname">{{ form.errors.fname }}</div>
                  </div>
                </div>
                <div>
                  <label for="last-name" class="block text-sm font-semibold leading-6 text-gray-900">Last name</label>
                  <div class="mt-2.5">
                    <input v-model="form.lname" type="text" name="last-name" id="last-name" autocomplete="family-name"
                      class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
                <div class="sm:col-span-2">
                  <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email</label>
                  <div class="mt-2.5">
                    <input v-model="form.email" type="email" name="email" id="email" autocomplete="email"
                      class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  </div>
                </div>
                <div class="sm:col-span-2">
                  <label for="phone-number" class="block text-sm font-semibold leading-6 text-gray-900">Phone
                    number</label>
                  <div class="mt-2.5">
                    <input v-model="form.phone" type="tel" name="phone-number" id="phone-number" autocomplete="tel"
                      class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <div v-if="form.errors.phone">{{ form.errors.phone }}</div>
                  </div>
                </div>
                <div class="sm:col-span-2">
                  <label for="message" class="block text-sm font-semibold leading-6 text-gray-900">Message</label>
                  <div class="mt-2.5">
                    <textarea v-model="form.message" name="message" id="message" rows="4"
                      class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                  </div>
                </div>
              </div>
              <div class="mt-8 flex justify-end">
                <button @click="send" type="submit"
                  class="rounded-md bg-green-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Send
                  message</button>
              </div>

              <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
              </progress> -->

            </div>
          </form>
        </div>

        <div class="relative px-6 pt-24 pb-20 sm:pt-32 lg:static lg:py-48 lg:px-8">
          <div class="mx-auto max-w-xl lg:mx-0 lg:max-w-lg">
            <div
              class="absolute inset-y-0 left-0 -z-10 w-full overflow-hidden bg-gray-100 ring-1 ring-gray-900/10 lg:w-1/2">
              <svg
                class="absolute inset-0 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
                aria-hidden="true">
                <defs>
                  <pattern id="83fd4e5a-9d52-42fc-97b6-718e5d7ee527" width="200" height="200" x="100%" y="-1"
                    patternUnits="userSpaceOnUse">
                    <path d="M130 200V.5M.5 .5H200" fill="none" />
                  </pattern>
                </defs>
                <rect width="100%" height="100%" stroke-width="0" fill="white" />
                <svg x="100%" y="-1" class="overflow-visible fill-gray-50">
                  <path d="M-470.5 0h201v201h-201Z" stroke-width="0" />
                </svg>
              <rect width="100%" height="100%" stroke-width="0" fill="url(#83fd4e5a-9d52-42fc-97b6-718e5d7ee527)" />
            </svg>
          </div>
          <h2 class="text-6xl font-bold tracking-tight text-gray-900">Get in touch</h2>
          <dl class="mt-10 space-y-4 text-base leading-7 text-gray-600">
            <div class="flex gap-x-4">
              <dt class="flex-none">
                <span class="sr-only">Telephone</span>
                <svg class="h-10 w-10 text-green-800" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                  </svg>
                </dt>
                <dd class="font-extrabold">1st Floor,Morningside Office Park, Ngong Road. <br> P.O. Box 58622-00200 <br>
                  Nairobi, Kenya.</dd>
              </div>
              <hr>
              <div class="flex gap-x-4">
                <dt class="flex-none">
                  <span class="sr-only">Telephone</span>
                  <svg class="h-10 w-10 text-green-800" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                  </svg>
                </dt>
                <dd><a
                    class="hover:text-gray-900 font-extrabold transform translate hover:scale-150 duration-700 ease-in-out hover:italic text-blue-600"
                    href="tel:+254 707 111 777">+254 707 111 777</a></dd>
              </div>
              <hr>
              <div class="flex gap-x-4">
                <dt class="flex-none">
                  <span class="sr-only">Telephone</span>
                  <svg class="h-10 w-10 text-green-800" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                  </svg>
                </dt>
                <dd><a
                    class="hover:text-gray-900 font-extrabold transform translate hover:scale-150 duration-700 ease-in-out hover:italic text-blue-600"
                    href="mailto:sales@rochman-properties.co.ke">sales@rochman-properties.co.ke</a></dd>
              </div>
            </dl>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-white py-24 sm:py-32">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
          <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Related Properties on Sale</h2>
        </div>
        <div
          class="mx-auto mt-16 grid max-w-3xl auto-rows-fr grid-cols-1 gap-2 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-4">

          <article v-for="relatedAd in relatedAds.slice(0, 4)" target="_blank"
            class="shadow-2xl relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-900 px-8 pb-8 pt-80 sm:pt-48 lg:pt-80">
            <img :src="getRelatedImages(relatedAd.id)" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover">
            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
            <div class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>

            <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm leading-6 text-white">
              <div class="-ml-4 flex items-center gap-x-4">
                <svg viewBox="0 0 2 2" class="-ml-0.5 h-0.5 w-0.5 flex-none fill-white/50">
                  <circle cx="1" cy="1" r="1" />
                </svg>
                <div class="text-lg flex gap-x-1 text-white">
                  {{ relatedAd.product_name }}
                </div>
              </div>
            </div>
            <time datetime="2020-03-16" class="text-green-600 mr-8 text-lg font-extrabold">KES {{
              formatMoney(relatedAd.price) }}</time>
            <h3 class="mt-3 text-xs font-semibold leading-6 text-white">
              <div class="flex felx-row justify-between">
                <p>
                  <span class="absolute inset-0"></span>
                  {{ relatedAd.location }}
                </p>
                <a :href="`https://rochman-properties.co.ke/property/` + relatedAd.url + `/details`" target="_blank"
                  class="trasform transition hover:scale-150 duration-700 ease-in-out">
                  <span class="absolute inset-0"></span>
                  View Property <i class="fas fa-caret-right"></i>
                </a>
              </div>
            </h3>
          </article>


        </div>
      </div>
    </div>


  </div>

  <div class="">
    <div class="cursor:pointer fixed z-50 bottom-5 right-8  flex">

      <div class="flex flex-col-reverse">
        <!-- <a class="hover:shadow-2xl transform transition hover:scale-150 duration-700 ease-in-out"
              href="https://www.facebook.com/RochmanPropertiesLtd" target="_blank">
              <i class="text-blue-600 fab fa-facebook fa-2x mb-4"></i>
            </a>
            <a class="hover:shadow-2xl transform transition hover:scale-150 duration-700 ease-in-out"
              href="https://www.instagram.com/rochmanpropertieslimited/" target="_blank">
              <i class="text-orange-400 fab fa-instagram fa-2x mb-4"></i>
            </a>
            <a class="hover:shadow-2xl transform transition hover:scale-150 duration-700 ease-in-out"
              href="https://twitter.com/rochmangroup" target="_blank">
              <i class="text-cyan-400 fab fa-twitter fa-2x mb-4"></i>
            </a> -->
        <a class="hover:animate-pulse hover:shadow-2xl transform transition hover:scale-150 duration-700 ease-in-out"
          href="https://api.whatsapp.com/send?phone=254707111777&text=Hey%20Rochman!%20I%20would%20like%20to%20have%20a%20chat%20concerning%20one%20of%20your%20properties.%20Kindly%20reach%20out.%20Thank%20you"
          target="_blank">
          <i class="text-green-600 fab fa-whatsapp fa-3x mb-4"></i>
        </a>
      </div>
    </div>


  </div>
</template>

<style>
#map {
  height: 180px;
}
</style>
