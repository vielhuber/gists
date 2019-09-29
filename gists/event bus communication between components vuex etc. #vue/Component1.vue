<script>
  /* ... */
  import { EventBus } from '@/helpers/event-bus';
  mounted() {
  	EventBus.$emit('custom-event', 'that rocks');
  }
  /* ... */
</script>