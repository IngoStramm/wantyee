(() => {
    'use strict';
    function inputMasks() {
        const inputTelefone = document.getElementById('wt_fone');
        const maskOptionsTelefone = {
            mask: '(00) 0000-0000[0]'
        };
        if (typeof inputTelefone !== undefined && inputTelefone) {
            const maskTelefone = IMask(inputTelefone, maskOptionsTelefone);
        }

        const inputWhatsApp = document.getElementById('wt_whatsapp');
        const maskOptionsWhatsApp = {
            mask: '(00) 0000-00000'
        };
        if (typeof inputWhatsApp !== undefined && inputWhatsApp) {
            const maskWhatsApp = IMask(inputWhatsApp, maskOptionsWhatsApp);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        inputMasks();
    }, false);
})();