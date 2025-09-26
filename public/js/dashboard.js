// public/js/dashboard.js




const cepInput = document.getElementById('cep');
const logradouroInput = document.getElementById('logradouro');
const bairroInput = document.getElementById('bairro');
const cidadeInput = document.getElementById('cidade');
const estadoInput = document.getElementById('estado');

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