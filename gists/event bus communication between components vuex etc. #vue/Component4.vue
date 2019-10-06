<script>
  /* ... */
  import { EventBus } from '@/helpers/event-bus';
  mounted() {
    EventBus.$on('custom-event', data => {});
  }
  beforeDestroy() {
    // this is very important: unsubscribe from the event when destroying (because otherwise the next time you double the triggers!)
    EventBus.$off('custom-event');
  }
  /* ... */
</script>