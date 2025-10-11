document.addEventListener('alpine:init', () => {
    Alpine.data('authPopup', () => ({
        open: false,
        mode: 'signin',
        showPass: false,
        email: '',
        emailError: '',
        existingUser: false,

        close() {
            this.open = false;
        },
        switchTo(newMode) {
            this.mode = newMode;
        },
        submitEmail() {
            this.emailError = '';
            if (!this.email.trim()) {
                this.emailError = 'Please enter your email address';
                return;
            }
            // Replace with real AJAX
            fetch(`/check-email?email=${encodeURIComponent(this.email)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.exists) {
                        this.existingUser = true;
                        this.mode = 'signin';
                    } else {
                        this.mode = 'register';
                    }
                });
        }
    }))
})
