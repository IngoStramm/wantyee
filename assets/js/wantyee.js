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
            phoneInput.value = wtPhoneMask(phoneInput.value);
            phoneInput.addEventListener('keyup', event => {
                wtHandlePhone(event);
            });
        });

        function wtHandlePhone(event) {
            let input = event.target;
            input.value = wtPhoneMask(input.value);
        }

        function wtPhoneMask(value) {
            if (!value) {
                return '';
            }
            value = value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, "($1) $2");
            value = value.replace(/(\d)(\d{4})$/, "$1-$2");
            return value;
        }
    }

    function wtInitToasts() {
        const toasts = document.querySelectorAll('.toast');
        Array.from(toasts).forEach(toast => {
            console.log('toasts');
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
        });
    }

    function inputMasks() {
        const inputTelefone = document.getElementById('user_phone');
        const maskOptionsTelefone = {
            mask: '(00) 0000-0000[0]'
        };
        if (typeof inputTelefone !== undefined && inputTelefone) {
            const maskTelefone = IMask(inputTelefone, maskOptionsTelefone);
        }

        const inputWhatsApp = document.getElementById('user_whatsapp');
        const maskOptionsWhatsApp = {
            mask: '(00) 0000-00000'
        };
        if (typeof inputWhatsApp !== undefined && inputWhatsApp) {
            const maskWhatsApp = IMask(inputWhatsApp, maskOptionsWhatsApp);
        }
    }

    function wtGoBackBtn() {
        const goBackBtns = document.querySelectorAll('.go-back-btn');
        Array.from(goBackBtns).forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                history.back();
            });
        });
    }

    function checkboxTermsList() {
        const listas = document.querySelectorAll('.checkbox-terms-list');
        Array.from(listas).forEach(lista => {
            const checkboxes = lista.querySelectorAll('input[type="checkbox"]');
            Array.from(checkboxes).forEach(checkbox => {
                const parentCheckboxId = checkbox.dataset.parent;
                // É filho
                if (typeof parentCheckboxId !== undefined && parentCheckboxId) {
                    checkbox.addEventListener('change', e => {
                        const parentCheckbox = document.getElementById(parentCheckboxId);
                        const sameParentCheckboxes = document.querySelectorAll('[data-parent="' + parentCheckboxId + '"]');
                        let isChecked = false;
                        Array.from(sameParentCheckboxes).forEach(sameParentCheckbox => {
                            if (sameParentCheckbox.checked) {
                                isChecked = true;
                            }
                        });
                        if (isChecked) {
                            parentCheckbox.checked = isChecked;
                        }
                    });
                } else {
                    // É pai
                    checkbox.addEventListener('change', e => {
                        const isChecked = checkbox.checked;
                        if (!isChecked) {
                            const childrenCheckboxes = document.querySelectorAll('[data-parent="' + checkbox.id + '"]');
                            Array.from(childrenCheckboxes).forEach(childrenCheckbox => {
                                childrenCheckbox.checked = isChecked;
                            });
                        }
                    });
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        wtFormsValidation();
        wtPasswordStrength();
        // wtInputsMasks();
        wtInitToasts();
        inputMasks();
        wtGoBackBtn();
        checkboxTermsList();
    }, false);

})();