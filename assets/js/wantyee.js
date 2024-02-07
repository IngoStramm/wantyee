(() => {
    'use strict';

    // Validação dos forms
    function wtFormsValidation() {
        const forms = document.querySelectorAll('.needs-validation');

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }

    // Verifica a Força da senha
    function wtPasswordStrength() {
        const passwordInput = document.getElementById('user_pass');
        if (typeof passwordInput === undefined || !passwordInput) {
            return;
        }
        const meterSections = document.querySelectorAll('.meter-section');
        if (meterSections.length <= 0) {
            return;
        }
        console.log('meterSections', meterSections);
        passwordInput.addEventListener('input', () => wtUpdateMeter(passwordInput, meterSections));
    }

    // Atualiza o medidor de força da senha
    function wtUpdateMeter(passwordInput, meterSections) {
        const password = passwordInput.value;
        let strength = wtCalculatePasswordStrength(password);

        meterSections.forEach((section) => {
            section.classList.remove('weak', 'medium', 'strong', 'very-strong');
        });

        if (strength >= 1) {
            meterSections[0].classList.add('weak');
        }
        if (strength >= 2) {
            meterSections[1].classList.add('medium');
        }
        if (strength >= 3) {
            meterSections[2].classList.add('strong');
        }
        if (strength >= 4) {
            meterSections[3].classList.add('very-strong');
        }
    }

    // Calcula a força da senha
    function wtCalculatePasswordStrength(password) {
        const lengthWeight = 0.2;
        const uppercaseWeight = 0.5;
        const lowercaseWeight = 0.5;
        const numberWeight = 0.7;
        const symbolWeight = 1;

        let strength = 0;

        // Calculate the strength based on the password length
        strength += password.length * lengthWeight;

        // Calculate the strength based on uppercase letters
        if (/[A-Z]/.test(password)) {
            strength += uppercaseWeight;
        }

        // Calculate the strength based on lowercase letters
        if (/[a-z]/.test(password)) {
            strength += lowercaseWeight;
        }

        // Calculate the strength based on numbers
        if (/\d/.test(password)) {
            strength += numberWeight;
        }

        // Calculate the strength based on symbols
        if (/[^A-Za-z0-9]/.test(password)) {
            strength += symbolWeight;
        }
        return strength;
    }

    // Máscara dos campos
    function wtInputsMasks() {
        const phoneInput = document.querySelectorAll('.phone-input');
        Array.from(phoneInput).forEach(phoneInput => {
            phoneInput.addEventListener('keyup', event => {
                wtHandlePhone(event);
            });
        });

        const wtHandlePhone = (event) => {
            let input = event.target;
            input.value = wtPhoneMask(input.value);
        };

        const wtPhoneMask = (value) => {
            if (!value) {
                return '';
            }
            value = value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, "($1) $2");
            value = value.replace(/(\d)(\d{4})$/, "$1-$2");
            return value;
        };
    }

    function wtInitToasts() {
        console.log('wtInitToasts');
        const toasts = document.querySelectorAll('.toast');
        Array.from(toasts).forEach(toast => {
            console.log('toasts');
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        wtFormsValidation();
        wtPasswordStrength();
        wtInputsMasks();
        wtInitToasts();
    }, false);

})();