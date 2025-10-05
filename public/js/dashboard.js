// public/js/dashboard.js

document.addEventListener('DOMContentLoaded', function () {
    // -------------------------------------------------------------
    // DECLARAÇÃO DE VARIÁVEIS PARA VIACEP (Para resolver o ReferenceError)
    // -------------------------------------------------------------
    const cepInput = document.getElementById('cep');
    const logradouroInput = document.getElementById('logradouro');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const estadoInput = document.getElementById('estado'); // <-- Note: O ID correto é 'estado' para o campo UF
    const numeroInput = document.getElementById('numero');

    // -------------------------------------------------------------
    // 1. LÓGICA DE AUTOPREENCHIMENTO COM VIACEP
    // -------------------------------------------------------------


    if (cepInput) {
        cepInput.addEventListener('blur', function () {
            let cep = this.value.replace(/\D/g, '');
            console.log('CEP a ser consultado:', cep);

            if (cep.length === 8) {
                const url = `https://viacep.com.br/ws/${cep}/json/`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Resposta da API:', data);
                        // Adicione esta lógica de depuração para verificar se os campos do formulário existem
                        console.log('Campos do formulário:', logradouroInput, bairroInput, cidadeInput, estadoInput);

                        if (data.erro) {
                            alert('CEP não encontrado ou inválido.');
                        } else {
                            logradouroInput.value = data.logradouro || '';
                            bairroInput.value = data.bairro || '';
                            cidadeInput.value = data.localidade || '';
                            estadoInput.value = data.uf || '';
                            document.getElementById('numero').focus();
                        }
                    })
                    .catch(error => {
                        console.error('Erro na requisição AJAX:', error);
                    });
            }
        });
    }
    // --- Fim: Lógica para autopreenchimento de endereço com ViaCEP ---


    // -------------------------------------------------------------
    // 2. LÓGICA PARA VER/ESCONDER SENHA (EXISTENTE)
    // -------------------------------------------------------------
    const passwordTogglesContainer = document.querySelector('body');

    if (passwordTogglesContainer) {
        passwordTogglesContainer.addEventListener('click', function (event) {
            if (event.target.closest('.js-toggle-password')) {
                const toggleButton = event.target.closest('.js-toggle-password');
                const inputGroup = toggleButton.closest('.input-group');
                const passwordInput = inputGroup.querySelector('.js-password-input');
                const eyeIcon = toggleButton.querySelector('i');

                if (passwordInput && eyeIcon) {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                }
            }
        });
    }
    // ... (Coloque aqui o restante do seu código JavaScript, como a lógica de níveis de acesso) ...

});