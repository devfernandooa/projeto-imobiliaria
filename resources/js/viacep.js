        function consultarCEP() {
            var cep = $('#cep').val();
            $.ajax({
                url: '/consulta-cep/' + cep,
                type: 'GET',
                success: function(response) {
                    if (response.erro) {
                        alert(response.erro);
                    } else {
                        $('#logradouro').val(response.logradouro);
                        $('#bairro').val(response.bairro);
                        $('#localidade').val(response.localidade);
                        $('#uf').val(response.uf);
                    }
                },
                error: function(error) {
                    alert('Erro ao consultar o CEP.');
                }
            });
        }
