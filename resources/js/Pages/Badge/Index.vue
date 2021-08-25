<template>
  <app-layout>
    <template #title>Upload Badge IDs</template>

    <form class="flex flex-col flex-grow justify-center items-center text-3xl text-center space-y-16">
      <div class="space-y-4" v-if="count > 0">
        <p>You have already uploaded</p>
        <p class="text-orange-700 text-6xl font-bold">{{ count.toLocaleString() }}</p>
        <p>Badge IDs to the database</p>
        <p>
          Last upload: <em>{{ latestDate() }} ({{ latest.length }} tags)</em>
        </p>
      </div>
      <div class="" v-else>You don't have uploaded any badge yet.</div>

      <div class="mt-8 space-y-4">
        <p>File to upload should be in comma-separated CSV format</p>
        <p>RFID,Badge ID</p>
        <p><em>e.g. 09002E4EA2CB</em>,<em>123456</em></p>
      </div>

      <div class="mt-4">
        <btn class="relative text-2xl font-semibold">
          <input
            type="file"
            name="form.file"
            class="absolute left-0 top-0 w-full h-full opacity-0"
            accept=".csv"
            @input="form.file = $event.target.files[0]"
            @change="submit"
          />
          Upload Badge IDs
        </btn>
        <div class="mt-1 text-rose-700 text-base" v-if="errors.file">{{ errors.file }}</div>
      </div>
    </form>

    <!-- delete confirm modal -->
    <!-- <confirmation-modal :show="isOpenModal" @close="showModal(false)">
      <template #title>Success</template>
      <template #content>Upload {{ successCount }} tags successfully!</template>
      <template #footer>
        <btn variant="secondary" @click="showModal(false)">Close</btn>
      </template>
    </confirmation-modal> -->
    <!-- <action-message on="isOpenAlert"> Upload {{ successCount }} tags successfully! </action-message> -->
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import SearchInput from '@/Components/SearchInput';
import Btn from '@/Components/Button';
import ConfirmationModal from '@/Jetstream/ConfirmationModal';
import ActionMessage from '@/Jetstream/ActionMessage';
import fnsParseISO from 'date-fns/parseISO';
import fnsFormat from 'date-fns/format';

export default {
  components: {
    AppLayout,
    SearchInput,
    Btn,
    ConfirmationModal,
    ActionMessage,
  },

  props: {
    count: Number,
    latest: Array,
    uploadUrl: String,
    errors: Object,
    successCount: Number | null,
  },

  data() {
    return {
      isOpenAlert: false,
      form: this.$inertia.form({
        file: '',
      }),
    };
  },

  methods: {
    latestDate() {
      return this.latest.length ? fnsFormat(fnsParseISO(this.latest[0].created_at), 'dd/MM/yyyy') : '';
    },

    showAlert(show) {
      this.isOpenAlert = show;
    },

    showModal(show) {
      this.isOpenModal = show;
    },

    submit() {
      this.form.post(this.uploadUrl);
    },
  },

  mounted() {
    if (typeof this.successCount === 'number') {
      // showModal(true);
      showAlert(true);
    }
  },
};
</script>
