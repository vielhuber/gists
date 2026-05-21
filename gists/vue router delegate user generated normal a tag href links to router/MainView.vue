    mounted() {
        // automatically bind links inside user generated content to vue router
        window.addEventListener('click', (event) => {
            if (
                !event.target ||
                !event.target.href ||
                !event.target.matches("a:not([href*='://'])")
            ) {
                return;
            }
            let target = event.target.getAttribute('target');
            if (target && /\b_blank\b/i.test(linkTarget)) {
                return;
            }
            event.preventDefault();
            this.$router.push(new URL(event.target.href).pathname);
        });
    }