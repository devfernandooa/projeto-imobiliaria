// public/js/main.js

// Script para fechar modal de login se o de cadastro for aberto (se ainda for o caso)
document.addEventListener('DOMContentLoaded', function() {
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

    // Adicione aqui qualquer outro JavaScript customizado para a sua página principal
});