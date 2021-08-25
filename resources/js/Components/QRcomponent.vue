<template>
  <qrcode-vue />
</template>
<script>
  import QrcodeVue from 'qrcode.vue'

  export default {
    data() {
      return {
        // value: 'http://192.168.1.4:8000/api/project/ajjsdaw445are',
        // size: 200,
      }
    },
    components: {
      QrcodeVue,
    },
  }
</script>