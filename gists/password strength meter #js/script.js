export default class passwordStrength {
    constructor() {
        this.init();
    }

    init() {
        if (document.querySelector('.password-strength')) {
            document.querySelectorAll('.password-strength').forEach(el => {
                if (
                    el.nextElementSibling === null ||
                    !el.nextElementSibling.classList.contains('password-strength-meter')
                ) {
                    let meter = document.createElement('div');
                    meter.classList.add('password-strength-meter');
                    el.after(meter);
                }
                this.updateMeter(el);
                el.addEventListener('keyup', e => {
                    this.updateMeter(e.target);
                });
            });
        }
    }

    updateMeter(el) {
        let password = el.value,
            meter = el.nextElementSibling;
        if (password.length === 0) {
            meter.removeAttribute('level');
            meter.textContent = '';
        } else if (password.length < 8) {
            meter.setAttribute('level', 1);
            meter.textContent = 'Unsicher';
        } else if (
            password.indexOf('$') === -1 &&
            password.indexOf('%') === -1 &&
            password.indexOf('@') === -1
        ) {
            meter.setAttribute('level', 2);
            meter.textContent = 'Mittel';
        } else {
            meter.setAttribute('level', 3);
            meter.textContent = 'Sicher';
        }
    }
}
