

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


document.addEventListener('DOMContentLoaded', function() {

    // --- Início: Lógica de atualização de Nível de Acesso por Tipo de Usuário ---
    const tipoUsuarioSelect = document.getElementById('tipo_usuario');
    const nivelAcessoInput = document.getElementById('nivel_acesso');

    if (tipoUsuarioSelect && nivelAcessoInput) {
        // Mapeamento dos níveis de acesso por tipo de usuário
        const niveisPorTipo = {
            'administrador': 1,
            'corretor': 2,
            'funcionario': 3,
            'cliente': 4,
            'proprietario': 4,
            'locatario': 4
        };

        // Função para atualizar o nível de acesso
        function atualizarNivelAcesso() {
            const tipoSelecionado = tipoUsuarioSelect.value;
            const nivelPadrao = niveisPorTipo[tipoSelecionado] || 4; // Usa 4 como padrão se o tipo não for encontrado
            nivelAcessoInput.value = nivelPadrao;

            console.log('Tipo de usuário selecionado:', tipoSelecionado);
            console.log('Novo nível de acesso:', nivelPadrao);
        }

        // Adiciona um listener para o evento 'change' (quando o select muda)
        tipoUsuarioSelect.addEventListener('change', atualizarNivelAcesso);

        // Chama a função uma vez ao carregar a página
        // Isso garante que o valor inicial do input esteja correto
        atualizarNivelAcesso();
    }
    // --- Fim: Lógica de atualização de Nível de Acesso por Tipo de Usuário ---

});
// --- Fim: Lógica de atualização de Nível de Acesso por Tipo de Usuário ---

// --- Início: Lógica para Modal de Confirmação de Exclusão (VERSÃO REFORÇADA) ---
const confirmDeleteModal = document.getElementById('confirmDeleteModal');

if (confirmDeleteModal) {
    // Encontra o formulário e o span para o nome do usuário dentro do modal
    const deleteForm = confirmDeleteModal.querySelector('#deleteForm');
    const modalUserNameSpan = confirmDeleteModal.querySelector('#userNameToDelete');

    // Adiciona um listener para o evento de exibição do modal
    confirmDeleteModal.addEventListener('show.bs.modal', function(event) {
        // O botão que disparou o modal
        const button = event.relatedTarget;
        // Extrai o ID e o nome do usuário dos atributos data-* do botão
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');

        // Verifica se o formulário e o span existem antes de manipulá-los
        if (deleteForm && modalUserNameSpan) {
            // Atualiza o texto no modal com o nome do usuário
            modalUserNameSpan.textContent = userName;

            // Atualiza a action do formulário com a URL correta do usuário a ser excluído
            // Ex: /usuarios/1, /usuarios/2, etc.
            const url = `http://127.0.0.1:8000/usuarios/${userId}`;
            deleteForm.setAttribute('action', url);
        } else {
            console.error('Erro: Formulário ou span não encontrados dentro do modal de exclusão.');
        }
    });
}
// --- Fim: Lógica para Modal de Confirmação de Exclusão ---