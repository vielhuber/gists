methods: {
	example() {
      this.$router.push({ name: 'editor' }, () => {
        this.$nextTick(() => {
        	console.log('DONE!');
        });
      });
	}
}
