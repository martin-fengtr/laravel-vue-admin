<template>
  <input
    class="flex flex-row justify-center items-center border-blueGray-300 focus-within:border-indigo-300 focus-within:ring focus-within:ring-indigo-200 focus-within:ring-opacity-50 rounded-md shadow-sm"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    ref="input"
  />
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

