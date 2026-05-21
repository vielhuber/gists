<script>
  /* ... */
  import { EventBus } from '@/helpers/event-bus';
  mounted() {
    EventBus.$on('custom-event', data => {
      console.log(data);
    });
  }
  /* ... */
</script>