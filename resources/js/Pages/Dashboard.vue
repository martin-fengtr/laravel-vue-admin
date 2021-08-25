<template>
  <app-layout>
    <template #title>Dashboard</template>
    This is dashboard
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Welcome from '@/Jetstream/Welcome';

export default {
  components: {
    AppLayout,
    Welcome,
  },
};
</script>
