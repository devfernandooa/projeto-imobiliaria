// public/js/main.js

// Script para fechar modal de login se o de cadastro for aberto (se ainda for o caso)
document.addEventListener('DOMContentLoaded', function () {
    var registerModal = document.getElementById('registerModal');
    var loginModal = document.getElementById('loginModal');

    if (registerModal && loginModal) {
        registerModal.addEventListener('show.bs.modal', function () {
            var bsModal = bootstrap.Modal.getInstance(loginModal);
            if (bsModal) {
                bsModal.hide();
            }
        });
    }


    const passwordTogglesContainer = document.querySelector('body'); // Pode ser qualquer contêiner pai

    if (passwordTogglesContainer) {
        passwordTogglesContainer.addEventListener('click', function (event) {
            // Verifica se o clique ocorreu em um elemento com a classe 'js-toggle-password'
            if (event.target.closest('.js-toggle-password')) {
                // Encontra o input de senha correspondente
                const toggleButton = event.target.closest('.js-toggle-password');
                const inputGroup = toggleButton.closest('.input-group');
                const passwordInput = inputGroup.querySelector('.js-password-input');

                // Encontra o ícone de olho
                const eyeIcon = toggleButton.querySelector('i');

                if (passwordInput && eyeIcon) {
                    // Alterna o tipo do input (password <-> text)
                    /**
                     * @type {string} type - The type of the input element, either 'password' or 'text'.
                     */
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Alterna o ícone de olho
                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                }
            }
        });
    }
    // --- Fim: Lógica para mostrar/esconder senha ---

});