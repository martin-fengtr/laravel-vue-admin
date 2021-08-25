<template>
  <inertia-link
    as="button"
    type="button"
    v-if="href"
    class="inline px-4 py-2 rounded-lg text-sm uppercase focus:ring-0 focus:outline-none"
    :class="[colorStyle]"
    :href="href"
    @click="$emit('click')"
  >
    <slot></slot>
  </inertia-link>
  <button
    type="button"
    class="inline px-4 py-2 rounded-lg text-sm uppercase focus:ring-0 focus:outline-none"
    :class="[colorStyle]"
    @click="$emit('click')"
    v-else
  >
    <slot></slot>
  </button>
</template>

<script lang="ts">
export default {
  props: ['href', 'variant'],

  emits: ['click'],

  computed: {
    colorStyle() {
      return this.variant === 'primary'
        ? 'bg-lightBlue-700 focus-within:bg-lightBlue-600 active:bg-lightBlue-800 text-blueGray-50'
        : this.variant === 'secondary'
        ? 'bg-blueGray-200 focus-within:bg-blueGray-100 active:bg-blueGray-300 text-blueGray-900'
        : 'bg-orange-700 focus-within:bg-orange-600 active:bg-orange-800 text-blueGray-50';
    },
  },
};
</script>
