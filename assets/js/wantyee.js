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

    function wtLimitFileUploadSize() {
        const uploadFields = document.querySelectorAll('input[type="file"]');

        Array.from(uploadFields).forEach(uploadField => {
            uploadField.onchange = function () {
                if (this.files[0].size > 2097152) {
                    alert('O arquivo é muito pesado, o tamanho máximo permitido é de 2MB.');
                    this.value = "";
                }
            };
        });
    }

    function wtFaq() {
        const faqs = document.querySelectorAll('.wt-faq-group');
        Array.from(faqs).forEach(faq => {
            const listItems = faq.querySelector('.wt-faq-group-list');
            const items = faq.querySelectorAll('.list-group-item');
            const addItemBtn = faq.querySelector('.wt-group-new-item-btn');

            if (typeof items === undefined || !items || items.length <= 0) {
                console.error('Não foi encontrado nenhum item da lista de perguntas e respostas (FAQ).');
                return;
            }
            if (typeof listItems === undefined || !listItems) {
                console.error('Não foi encontrado a lista de itens de perguntas e respostas (FAQ).');
                return;
            }
            if (typeof addItemBtn === undefined || !addItemBtn) {
                console.error('Não foi encontrado o botão para adicionar novos itens na lista de perguntas e respostas (FAQ).');
                return;
            }

            wtAddNewFaqItemEvent(addItemBtn, faq);
            wtAddRemoveFaqItemEvent(faq);
        });
    }

    function wtRecalcFaqItems(faq) {
        const faqList = faq.querySelector('.wt-faq-group-list');
        const items = faq.querySelectorAll('.list-group-item');

        if (typeof items === undefined || !items || items.length <= 0) {
            console.error('Não foi encontrado nenhum item da lista de perguntas e respostas (FAQ).');
            return;
        }
        if (typeof faqList === undefined || !faqList) {
            console.error('Não foi encontrado a lista de itens de perguntas e respostas (FAQ).');
            return;
        }


        Array.from(items).forEach((item, i) => {
            item.dataset.faqGroupItemId = i;
            const perguntaId = `anuncio_faq-pergunta-${i}`;
            const respostaId = `anuncio_faq-resposta-${i}`;
            const labels = item.querySelectorAll('label');
            const inputs = item.querySelectorAll('input');
            const textareas = item.querySelectorAll('textarea');
            labels.forEach((label, i) => {
                if (i === 0) {
                    label.setAttribute('for', perguntaId);
                } else {
                    label.setAttribute('for', respostaId);
                }
            });
            inputs.forEach((input, i) => {
                if (i === 0) {
                    input.id = perguntaId;
                }
            });
            textareas.forEach((textarea, i) => {
                if (i === 0) {
                    textarea.id = respostaId;
                }
            });
            console.log('i', i);
        });
        console.log('items.length', items.length);
        return items.length;
    }

    function wtAddNewFaqItemEvent(addItemBtn, faq) {
        const listItems = faq.querySelector('.wt-faq-group-list');

        if (typeof listItems === undefined || !listItems) {
            console.error('Não foi encontrado a lista de itens de perguntas e respostas (FAQ).');
            return;
        }

        addItemBtn.addEventListener('click', wtAddNewFaqItem.bind(null, listItems, faq));
    }

    function wtAddNewFaqItem(listItems, faq, e) {
        e.preventDefault();

        // Item da lista
        const listItem = document.createElement('li');
        listItem.classList.add('wt-faq-group-item');
        listItem.classList.add('list-group-item');
        listItem.id = 'wt-faq-group-item-';
        listItem.dataset.faqGroupItemId = '';

        // Pergunta label
        const perguntaLabel = document.createElement('label');
        perguntaLabel.setAttribute('for', 'anuncio_faq-pergunta-');
        perguntaLabel.classList.add('form-label');
        perguntaLabel.innerText = 'Pergunta';

        listItem.append(perguntaLabel);

        // Pergunta input
        const perguntaInput = document.createElement('input');
        perguntaInput.setAttribute('type', 'text');
        perguntaInput.classList.add('form-control');
        perguntaInput.id = 'anuncio_faq-pergunta-';
        perguntaInput.name = 'anuncio_faq-perguntas[]';
        // perguntaInput.setAttribute('required', '');

        listItem.append(perguntaInput);

        // Resposta label
        const respostaLabel = document.createElement('label');
        respostaLabel.setAttribute('for', 'anuncio_faq-resposta-');
        respostaLabel.classList.add('form-label');
        respostaLabel.innerText = 'Resposta';

        listItem.append(respostaLabel);

        // Resposta textarea
        const respostaTextarea = document.createElement('textarea');
        respostaTextarea.setAttribute('type', 'text');
        respostaTextarea.classList.add('form-control');
        respostaTextarea.id = 'anuncio_faq-resposta-';
        respostaTextarea.name = 'anuncio_faq-respostas[]';
        // respostaTextarea.setAttribute('required', '');

        listItem.append(respostaTextarea);

        // Div com mensagem de validação
        const divInvalidFeedback = document.createElement('div');
        divInvalidFeedback.classList.add('invalid-feedback');
        divInvalidFeedback.innerText = 'Campo obrigatório';

        listItem.append(divInvalidFeedback);

        // Div de container do botão de exclusão do item
        const divBtnWrapper = document.createElement('div');
        divBtnWrapper.classList.add('d-flex');

        // Botão de exclusão do item
        const btnRemoveItem = document.createElement('a');
        btnRemoveItem.classList.add('wt-delete-faq-group');
        btnRemoveItem.classList.add('btn');
        btnRemoveItem.classList.add('btn-danger');
        btnRemoveItem.classList.add('btn-sm');
        btnRemoveItem.classList.add('mt-2');
        btnRemoveItem.classList.add('ms-auto');
        btnRemoveItem.innerHTML = '<i class="bi bi-x-circle-fill"></i> Remover item';
        // btnRemoveItem.addEventListener('click', wtRemoveFaqItem);

        divBtnWrapper.append(btnRemoveItem);

        listItem.append(divBtnWrapper);
        listItems.append(listItem);
        wtAddRemoveFaqItemEvent(faq);
        wtRecalcFaqItems(faq);
    }

    function wtAddRemoveFaqItemEvent(faq) {
        const removeBtns = document.querySelectorAll('.wt-delete-faq-group');
        Array.from(removeBtns).forEach(removeBtn => {
            removeBtn.removeEventListener('click', wtRemoveFaqItem);
            removeBtn.addEventListener('click', wtRemoveFaqItem.bind(null, faq));
        });
    }

    function wtRemoveFaqItem(faq, e) {
        e.preventDefault();
        const itemsLength = wtRecalcFaqItems(faq);
        const item = e.target.closest('.wt-faq-group-item');
        if (itemsLength > 1) {
            item.remove();
        } else {
            const input = item.querySelector('input');
            const textarea = item.querySelector('textarea');
            input.value = '';
            textarea.value = '';
        }
    }

    function wtTooltips() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    }

    function wtEditorRequired() {
        const wtEditors = document.querySelectorAll('textarea[name="anuncio-content"]');
        wtEditors.forEach(item => {
            item.required = true;
        });
    }

    function wtFileImagePreview() {
        const containers = document.querySelectorAll('.wt-file-image-preview');
        containers.forEach(container => {
            const fileInput = container.querySelector('input[type="file"]');
            const imagePreview = container.querySelector('.image-preview');
            const btnClearImage = container.querySelector('.btn-clear-image');
            const changedThumbnail = container.querySelector('input[name="changed-thumbnail"]');
            btnClearImage.addEventListener('click', e => {
                e.preventDefault();
                fileInput.value = null;
                imagePreview.src = '';
                btnClearImage.style.display = 'none';
                changedThumbnail.value = 'true';
                console.log('changedThumbnail', changedThumbnail.value);
            });
            fileInput.addEventListener('change', e => {
                imagePreview.src = URL.createObjectURL(event.target.files[0]);
                btnClearImage.style.display = 'block';
                changedThumbnail.value = 'true';
                console.log('changedThumbnail', changedThumbnail.value);
            });
            console.log('imagePreview', imagePreview.src);
            // fileInput.value = imagePreview.src;
            console.log('changedThumbnail', changedThumbnail.value);
            console.log('fileInput', fileInput.value);
            // const event = new Event('change');
            // fileInput.dispatchEvent(event);
        });
    }

    function wtSortTableList() {

        const defaultOptions = {
            page: 10,
            pagination: [{
                item: `<li class="page-item"><a class="page page-link"></a></li>`
            }]
        };

        const optionsListAnuncios = {
            ...defaultOptions,
            valueNames: ['titulo', 'data', 'status']
        };

        const optionsLeads = {
            ...defaultOptions,
            valueNames: ['nome', 'email', 'titulo', 'data'],
        };

        const optionsFollowingTermsAnuncios = {
            ...defaultOptions,
            valueNames: ['nome', 'categorias', 'titulo', 'data'],
        };

        const optionsContactedAnuncios = {
            ...defaultOptions,
            valueNames: ['titulo', 'nome', 'data', 'status'],
        };

        const tableAnuncios = document.getElementById('table-anuncios');
        const tableListAnuncios = new List(tableAnuncios, optionsListAnuncios);

        const tableLeads = document.getElementById('table-leads');
        const tableListLeads = new List(tableLeads, optionsLeads);

        const tableFollowingTermsAnuncios = document.getElementById('table-following-terms-anuncios');
        const tableListFollowingTermsAnuncios = new List(tableFollowingTermsAnuncios, optionsFollowingTermsAnuncios);

        const tableContactedAnuncios = document.getElementById('table-contacted-anuncios');
        const tableListContactedAnuncios = new List(tableContactedAnuncios, optionsContactedAnuncios);
    }

    function wtSelectForm() {
        const selectForms = document.querySelectorAll('.filters-form');
        selectForms.forEach(selectForm => {
            const select = selectForm.querySelector('select');
            select.addEventListener('change', e => {
                selectForm.requestSubmit();
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        wtFormsValidation();
        wtPasswordStrength();
        wtLimitFileUploadSize();
        wtInitToasts();
        inputMasks();
        wtGoBackBtn();
        checkboxTermsList();
        wtFaq();
        wtTooltips();
        wtFileImagePreview();
        wtSortTableList();
        // wtSelectForm();
    }, false);

})();