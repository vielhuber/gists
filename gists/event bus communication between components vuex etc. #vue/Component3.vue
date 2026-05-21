<script>
  /* ... */
  import { EventBus } from '@/helpers/event-bus';
  mounted() {
    EventBus.$on('custom-event', data => {
      EventBus.$off('custom-event'); // only listen ONCE
      console.log(data);
    });  
    EventBus.$once('custom-event', data => { // alternative
      console.log(data);
    });
  }
  /* ... */
</script>