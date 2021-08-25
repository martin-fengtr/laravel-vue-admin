<template>
  <div class="flex flex-row justify-center items-stretch w-screen h-screen">
    <div class="w-1/5 max-w-xs p-4 flex flex-col justify-start items-center bg-blueGray-200 text-blueGray-50">
      <application-mark class="transform scale-75" />

      <nav class="mt-6 px-4 w-full flex flex-col items-start">
        <nav-link class="m-2" :href="route('dashboard')">Dashboard</nav-link>
        <nav-link class="m-2" :href="route('company.index')">Company</nav-link>
        <nav-link class="m-2" :href="route('user.index')">Users</nav-link>
        <nav-link class="m-2" :href="route('project.index')">Projects</nav-link>
        <nav-link class="m-2" :href="route('badge.index')">Upoad Badge</nav-link>
      </nav>
    </div>
    <div class="px-8 py-4 flex flex-col flex-grow bg-white">
      <nav>
        <form class="float-right" method="POST" @submit.prevent="logout">
          <jet-responsive-nav-link as="button">Sign Out</jet-responsive-nav-link>
        </form>
      </nav>
      <div class="py-4 flex flex-row justify-between items-center">
        <p class="text-3xl" v-if="$slots.title"><slot name="title"></slot></p>
        <div class="w-1"></div>
        <div v-if="$slots.search"><slot name="search"></slot></div>
      </div>

      <div class="pb-8 px-2 -mx-2 flex flex-col flex-grow overflow-hidden">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
import JetApplicationMark from '@/Jetstream/ApplicationMark';
import JetBanner from '@/Jetstream/Banner';
import JetDropdown from '@/Jetstream/Dropdown';
import JetDropdownLink from '@/Jetstream/DropdownLink';
import JetNavLink from '@/Jetstream/NavLink';
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink';
import NavLink from '@/Jetstream/NavLink';
import ApplicationMark from '@/Jetstream/ApplicationMark';

export default {
  components: {
    JetApplicationMark,
    JetBanner,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
    NavLink,
    ApplicationMark,
  },

  data() {
    return {
      showingNavigationDropdown: false,
    };
  },

  methods: {
    logout() {
      this.$inertia.post(route('logout'));
    },
  },
};
</script>
