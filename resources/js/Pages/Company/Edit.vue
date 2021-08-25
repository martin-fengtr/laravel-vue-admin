<template>
  <app-layout>
    <template #title>Add New Company</template>

    <!-- form -->
    <form class="flex flex-col flex-grow" @submit.prevent="submit">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <jet-label for="name" value="Company Name" />
          <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
          <div class="mt-0.5 text-rose-700 text-xs" v-if="errors.name">{{ errors.name }}</div>
        </div>
        <div>
          <jet-label for="email" value="Email Address" />
          <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
          <div class="mt-0.5 text-rose-700 text-xs" v-if="errors.email">{{ errors.email }}</div>
        </div>
        <div>
          <jet-label for="phone-number" value="Telephone Number" />
          <jet-input id="phone-number" type="tel" class="mt-1 block w-full" v-model="form.phoneNumber" />
          <div class="mt-0.5 text-rose-700 text-xs" v-if="errors.phoneNumber">{{ errors.phoneNumber }}</div>
        </div>
        <div>
          <jet-label for="address" value="Address" />
          <jet-input id="address" type="text" class="mt-1 block w-full" v-model="form.address" />
          <div class="mt-0.5 text-rose-700 text-xs" v-if="errors.address">{{ errors.address }}</div>
        </div>
        <div>
          <jet-label for="status" value="Status" />
          <jet-input id="status" type="text" class="mt-1 block w-full" v-model="form.status" />
          <div class="mt-0.5 text-rose-700 text-xs" v-if="errors.status">{{ errors.status }}</div>
        </div>
      </div>

      <!-- users/projects switch -->
      <div class="mt-8 flex flex-row justify-start items-center">
        <btn
          class="text-xs rounded-l-md rounded-r-none"
          :variant="kind === 'Users' ? 'primary' : 'secondary'"
          @click="kind = 'Users'"
        >
          Users
        </btn>
        <btn
          class="text-xs rounded-r-md rounded-l-none"
          :variant="kind === 'Projects' ? 'primary' : 'secondary'"
          @click="kind = 'Projects'"
        >
          Projects
        </btn>
      </div>

      <!-- search -->
      <div class="mt-4 flex flex-row justify-between items-center">
        <span>{{ kind }}</span>
        <search-input v-model="query" />
      </div>

      <!-- table -->
      <div
        class="mt-4 flex flex-grow flex-col items-stretch border border-blueGray-400 text-blueGray-900 overflow-y-scroll"
      >
        <table class="bg-white">
          <thead>
            <tr>
              <th class="sticky top-0 bg-blueGray-200 font-semibold text-left w-1/2">
                <div class="w-full h-full p-2 border-b-2 border-blueGray-400">Company</div>
              </th>
              <th class="sticky top-0 bg-blueGray-200 font-semibold text-left">
                <div class="w-full h-full p-2 border-b-2 border-blueGray-400">Location</div>
              </th>
              <th class="sticky top-0 bg-blueGray-200 font-semibold text-left w-24">
                <div class="w-full h-full p-2 border-b-2 border-blueGray-400">&nbsp;</div>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="group" v-for="item in filtered" :key="item.id">
              <td class="px-2 py-0.5">{{ item.name }}</td>
              <td class="px-2 py-0.5">n/a</td>
              <td class="flex flex-row justify-end items-center space-x-1 px-2 py-0.5 min-h-2.25">
                <button
                  type="button"
                  class="w-8 h-8 p-2 flex justify-center items-center hidden group-hover:block focus:outline-none focus:shadow-outline"
                  @click="showModal(true, item.deleteUrl)"
                >
                  <svg viewBox="0 0 26 26" fill="#F43F5E">
                    <path
                      d="M 11.5 -0.03125 C 9.542969 -0.03125 7.96875 1.59375 7.96875 3.5625 L 7.96875 4 L 4 4 C 3.449219 4 3 4.449219 3 5 L 3 6 L 2 6 L 2 8 L 4 8 L 4 23 C 4 24.644531 5.355469 26 7 26 L 19 26 C 20.644531 26 22 24.644531 22 23 L 22 8 L 24 8 L 24 6 L 23 6 L 23 5 C 23 4.449219 22.550781 4 22 4 L 18.03125 4 L 18.03125 3.5625 C 18.03125 1.59375 16.457031 -0.03125 14.5 -0.03125 Z M 11.5 2.03125 L 14.5 2.03125 C 15.304688 2.03125 15.96875 2.6875 15.96875 3.5625 L 15.96875 4 L 10.03125 4 L 10.03125 3.5625 C 10.03125 2.6875 10.695313 2.03125 11.5 2.03125 Z M 6 8 L 11.125 8 C 11.25 8.011719 11.371094 8.03125 11.5 8.03125 L 14.5 8.03125 C 14.628906 8.03125 14.75 8.011719 14.875 8 L 20 8 L 20 23 C 20 23.5625 19.5625 24 19 24 L 7 24 C 6.4375 24 6 23.5625 6 23 Z M 8 10 L 8 22 L 10 22 L 10 10 Z M 12 10 L 12 22 L 14 22 L 14 10 Z M 16 10 L 16 22 L 18 22 L 18 10 Z"
                      fill="#F43F5E"
                    />
                  </svg>
                </button>

                <inertia-link
                  class="w-8 h-8 p-2 flex justify-center items-center hidden group-hover:block focus:outline-none focus:shadow-outline"
                  :href="item.editUrl"
                >
                  <svg viewBox="0 0 26 26" fill="currentColor">
                    <path
                      d="M 20.09375 0.25 C 19.5 0.246094 18.917969 0.457031 18.46875 0.90625 L 17.46875 1.9375 L 24.0625 8.5625 L 25.0625 7.53125 C 25.964844 6.628906 25.972656 5.164063 25.0625 4.25 L 21.75 0.9375 C 21.292969 0.480469 20.6875 0.253906 20.09375 0.25 Z M 16.34375 2.84375 L 14.78125 4.34375 L 21.65625 11.21875 L 23.25 9.75 Z M 13.78125 5.4375 L 2.96875 16.15625 C 2.71875 16.285156 2.539063 16.511719 2.46875 16.78125 L 0.15625 24.625 C 0.0507813 24.96875 0.144531 25.347656 0.398438 25.601563 C 0.652344 25.855469 1.03125 25.949219 1.375 25.84375 L 9.21875 23.53125 C 9.582031 23.476563 9.882813 23.222656 10 22.875 L 20.65625 12.3125 L 18 9.65625 L 17.96875 9.65625 L 16.1875 7.84375 Z M 4.15625 17.9375 L 4.6875 18.46875 L 7.28125 18.6875 L 7.40625 21.21875 L 8.0625 21.875 L 3.84375 23.09375 L 2.90625 22.15625 Z"
                      fill="currentColor"
                    />
                  </svg>
                </inertia-link>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="flex flex-grow justify-center items-center" v-if="!filtered.length">Nothing to show</div>
      </div>

      <!-- actions -->
      <div class="mt-4 flex flex-row justify-center items-center space-x-4">
        <btn variant="secondary" :href="backUrl">Cancel</btn>
        <btn variant="primary" type="submit">Save</btn>
      </div>
    </form>

    <!-- delete confirm modal -->
    <confirmation-modal :show="isOpenModal" @close="showModal(false)">
      <template #title>Are you sure?</template>
      <template #content>Are you sure you want to delete this user?</template>
      <template #footer>
        <btn variant="secondary" @click="showModal(false)">Cancel</btn>
        <btn class="ml-2" @click="deleteItem">Delete</btn>
      </template>
    </confirmation-modal>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import JetInput from '@/Jetstream/Input';
import JetLabel from '@/Jetstream/Label';
import SearchInput from '@/Components/SearchInput';
import Btn from '@/Components/Button';
import ConfirmationModal from '@/Jetstream/ConfirmationModal';

export default {
  components: {
    AppLayout,
    JetInput,
    JetLabel,
    SearchInput,
    Btn,
    ConfirmationModal,
  },

  props: {
    company: Object,
    users: Array,
    projects: Array,
    backUrl: String,
    saveUrl: String,
    errors: Object,
  },

  emits: ['update:kind'],

  data() {
    return {
      kind: 'Users',
      query: '',
      isOpenModal: false,
      deleteUrl: '',
      form: this.$inertia.form({
        name: this.company ? this.company.name : '',
        email: '',
        phoneNumber: '',
        address: '',
        status: '',
      }),
    };
  },

  computed: {
    filtered() {
      if (this.kind === 'Users') {
        return this.users.filter(item => item.name.toLowerCase().indexOf(this.query.toLowerCase()) >= 0);
      } else {
        return this.projects.filter(item => item.name.toLowerCase().indexOf(this.query.toLowerCase()) >= 0);
      }
    },
  },

  methods: {
    submit() {
      const form = this.form.transform(data => ({
        name: data.name,
      }));
      if (this.company) {
        form.put(this.saveUrl);
      } else {
        form.post(this.saveUrl);
      }
    },

    showModal(show, deleteUrl = '') {
      this.isOpenModal = show;
      this.deleteUrl = deleteUrl;
    },

    deleteItem() {
      this.$inertia.delete(this.deleteUrl);
      this.deleteUrl = '';
      this.showModal(false);
    },
  },
};
</script>
