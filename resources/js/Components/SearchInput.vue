<template>
  <div class="relative text-blueGray-600 focus-within:text-blueGray-900">
    <button
      class="absolute w-10 h-10 inset-y-1/2 transform -translate-y-1/2 left-0 flex justify-center items-center focus:outline-none"
      @click="$emit('update:modelValue', modelValue)"
    >
      <svg
        fill="none"
        stroke="currentColor"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        viewBox="0 0 24 24"
        class="w-5 h-5"
      >
        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
      </svg>
    </button>
    <input
      type="search"
      name="q"
      class="pl-11 py-2 bg-blueGray-100 focus:bg-white text-blueGray-600 focus:text-blueGray-900 text-sm border-blueGray-300 focus-within:border-indigo-300 focus-within:ring focus-within:ring-indigo-200 focus-within:ring-opacity-50 rounded-md shadow-sm"
      placeholder="Search..."
      autocomplete="off"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      ref="input"
    />
  </div>
</template>

<script>
export default {
  props: ['modelValue'],

  emits: ['update:modelValue'],

  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
};
</script>

