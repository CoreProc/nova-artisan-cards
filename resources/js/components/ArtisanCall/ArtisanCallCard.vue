<template>
  <Card class="flex flex-col justify-center min-h-8">
    <div class="px-4 py-4 flex justify-between items-center">
      <div class="flex-grow pr-2">
        <h3 class="text-lg font-bold">
          Artisan Call
        </h3>
        <p>This will run the specified artisan command.</p>
      </div>
      <div class="shrink-0 ml-4">
        <Button
          @click="showModal = true"
          state="default"
        >
          Run Command
        </Button>
      </div>
    </div>
    <ArtisanCallModal
      :show="showModal"
      title="Artisan Call"
      message="This will run the artisan command."
      @confirm="handleConfirm"
      confirmButtonState="danger"
      confirmButtonText="Run Command"
      @close="handleClose"
    />
  </Card>
</template>

<script>

import ArtisanCallModal from "./Modals/ArtisanCallModal.vue";
import {Button} from "laravel-nova-ui";

export default {
  components: {
    Button,
    ArtisanCallModal,
  },
  props: [
    'card',
    // The following props are only available on resource detail cards...
    // 'resource',
    // 'resourceId',
    // 'resourceName',
  ],
  data() {
    return {
      loading: false,
      showModal: false,
    };
  },
  methods: {
    async handleConfirm(command) {
      this.loading = true;
      try {
        const response = await Nova.request()
          .post('/nova-vendor/nova-artisan-cards/artisan/artisan-call', {
            'command': command,
          });
        // Redirect user back to /
        alert(response.data.output);
      } catch (error) {
        console.error('Error running the command', error);
        // Handle error here
        alert('Artisan call experienced an error');
      } finally {
        this.showModal = false;
        this.loading = false;
      }
    },
    handleClose() {
      this.showModal = false;
    },
  },
};
</script>
