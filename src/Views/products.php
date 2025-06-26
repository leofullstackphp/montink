<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= $_ENV['APP_NAME'] ?></title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/assets/css/bootstrap.css">

    <link rel="stylesheet" href="src/assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="src/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="src/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="src/assets/css/app.css">
    <link rel="stylesheet" href="src/assets/vendors/simple-datatables/style.css">
    <link rel="shortcut icon" href="" type="image/x-icon">
    <link rel="icon" href="https://sou.montink.com/wp-content/uploads/2021/09/cropped-Design-sem-nome-1-32x32.png" sizes="32x32" />
</head>

<body>
    <div id="app">
        <?php include __DIR__ . "/layouts/sidebar.php"; ?>
        <div id="main" class='layout-navbar'>
            <?php include __DIR__ . "/layouts/header.php"; ?>
            <div id="main-content">

                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Produtos</h3>
                                <p class="text-subtitle text-muted">Olá <?= $_SESSION['document'] ?> ,

                                </p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Criar Produto
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-content">
                    <section id="multiple-column-form">
                        <div class="row">
                            <div class="col-12">

                                <!-- FORMULÁRIO PRODUTO -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Adicionar / Editar Produto</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="form-produto">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Nome</label>
                                                    <input type="text" name="nome" class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Preço</label>
                                                    <input type="text" name="preco" class="form-control js-preco">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Estoque</label>
                                                    <input type="text" name="estoque" class="form-control js-estoque">
                                                </div>
                                                <!-- Variações -->
                                                <div class="col-12 mt-4">
                                                    <h6>Variações do Produto</h6>
                                                    <div id="variacoes-container">
                                                        <div class="row mb-2 variacao-item">
                                                            <div class="col-md-5">
                                                                <input type="text" name="variacao_tipo[]" class="form-control" placeholder="Tipo (Ex.: Cor)">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="variacao_valores[]" class="form-control" placeholder="Valores (Ex.: Azul, Vermelho)">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-danger btn-remover-variacao">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-secondary" id="btn-add-variacao">
                                                        <i class="bi bi-plus-circle"></i> Adicionar Variação
                                                    </button>
                                                </div>

                                                <div class="col-12 d-flex justify-content-end mt-3">
                                                    <button type="submit" class="btn btn-primary">Salvar Produto</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- LISTAGEM PRODUTOS -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Lista de Produtos</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped" id="produtos-table">
                                            <thead>
                                                <tr class="">
                                                    <th>ID</th>
                                                    <th>Nome</th>
                                                    <th>Preço</th>
                                                    <th>Estoque</th>
                                                    <th>Variações</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody class=""></tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="mb-0">Carrinho de Compras</h4>
                                    </div>
                                    <div class="card-body">

                                        <!-- Lista de Itens -->
                                        <div id="itens-carrinho" style="display: none;">
                                            <h5 class="mb-3">Itens do Pedido</h5>
                                            <table class="table table-bordered table-striped table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Produto</th>
                                                        <th class="text-center">Qtd</th>
                                                        <th class="text-end">Unitário</th>
                                                        <th class="text-end">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="lista-itens-carrinho">
                                                    <!-- Itens serão adicionados aqui -->
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Resumo -->
                                        <div id="resumo-carrinho" class="mt-4" style="display: none;">
                                            <h5 class="mb-3">Resumo do Pedido</h5>
                                            <div class="border rounded p-3 bg-light">
                                                <div class="d-flex justify-content-between">
                                                    <span>Subtotal:</span>
                                                    <span id="subtotal">R$ 0,00</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Frete:</span>
                                                    <span id="frete">R$ 0,00</span>
                                                </div>
                                                <!-- Cupom aplicado -->
                                                <div id="cupom-container" class="d-flex justify-content-between text-success fw-bold" style="display: none;">
                                                    <span id="cupom-label"></span>
                                                    <span id="cupom-desconto"></span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between fw-bold fs-5">
                                                    <span>Total:</span>
                                                    <span id="total">R$ 0,00</span>
                                                </div>
                                            </div>
                                             <!-- Botões de Ações do Carrinho -->
                                            <div class="mt-4 d-flex flex-column flex-md-row gap-2">
                                                <button id="btn-finalizar" class="btn btn-success w-100">
                                                    <i class="bi bi-check-circle-fill me-1"></i> Finalizar Pedido
                                                </button>

                                                <button id="btn-limpar" class="btn btn-outline-danger w-100">
                                                    <i class="bi bi-trash-fill me-1"></i> Limpar Carrinho
                                                </button>

                                                <button id="btn-cupom" class="btn btn-primary w-100">
                                                    <i class="bi bi-tag-fill me-1"></i> Incluir Cupom
                                                </button>
                                            </div>
                                        </div>

                                       

                                    </div>
                                </div>


                            </div>
                        </div>
                    </section>
                </div>

                <?php include __DIR__ . "/layouts/footer.php"; ?>
            </div>
        </div>
    </div>
    <script src="src/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="src/assets/js/bootstrap.bundle.min.js"></script>

    <script src="src/assets/vendors/simple-datatables/simple-datatables.js"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="src/assets/js/main.js"></script>

    <script>
        let tabelaProdutos = new simpleDatatables.DataTable("#produtos-table");
        let produtos = [];
        let pedidos = [];
        let carrinho = [];
        let editandoId = null;
        let pedidoId = null;

        const api = {
            listarProdutos: () => {
                return new Promise((resolve, reject) => {
                    $.ajax({
                            url: '/api/produtos',
                            method: 'GET',
                            dataType: 'json'
                        })
                        .done(function(response) {
                            if (response.status && Array.isArray(response.produtos)) {
                                produtos = response.produtos;
                                resolve(produtos);
                            } else {
                                reject('Erro no retorno da API');
                            }
                        })
                        .fail(function() {
                            reject('Erro na conexão');
                        });
                });
            },

            salvarProduto: (produto) => {
                const metodo = produto.id ? 'PUT' : 'POST';
                const url = produto.id ? `/api/produtos/${produto.id}` : '/api/produtos';

                const isEditar = metodo === 'PUT';

                return $.ajax({
                        url: url,
                        method: metodo,
                        data: isEditar ? JSON.stringify(produto) : produto,
                        contentType: isEditar ? 'application/json' : 'application/x-www-form-urlencoded; charset=UTF-8',
                        dataType: 'json'
                    })
                    .then(response => {
                        if (response.status) return response;
                        return Promise.reject('Erro na API');
                    })
                    .catch(() => Promise.reject('Erro na conexão'));
            },

            excluirProduto: (id) => {
                return $.ajax({
                        url: `/api/produtos/${id}`,
                        method: 'DELETE'
                    })
                    .then(response => {
                        if (response.status) return response;
                        return Promise.reject('Erro na API');
                    })
                    .catch(() => Promise.reject('Erro na conexão'));
            },

            consultarCEP: (cep) => {
                return $.ajax({
                    url: `https://viacep.com.br/ws/${cep.replace(/\D/g, '')}/json/`,
                    method: "GET"
                });
            },
        };

        const gerarVariacaoHtml = (tipo = '', valores = '') => `
            <div class="row mb-2 variacao-item">
                <div class="col-md-5">
                    <input type="text" name="variacao_tipo[]" class="form-control" placeholder="Tipo (Ex.: Cor)" value="${tipo}">
                </div>
                <div class="col-md-5">
                    <input type="text" name="variacao_valores[]" class="form-control" placeholder="Valores (Ex.: Azul, Vermelho)" value="${valores}">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-remover-variacao">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>`;

        const limparVariacoes = () => {
            $('#variacoes-container').html('');
        };

        const gerarTextoVariacoes = (variacoes) => {
            if (!variacoes || !Array.isArray(variacoes) || variacoes.length === 0) {
                return '';
            }
            return variacoes.map(v => `${v.tipo}: ${v.valor}`).join(' | ');
        };

        const resetarFormulario = () => {
            $('#form-produto')[0].reset();
            limparVariacoes();
            editandoId = null;
            $('input[name="nome"]').focus();
        };

        const atualizarResumoCarrinho = (carrinho) => {
            if (!carrinho || !carrinho.pedidos_itens || carrinho.pedidos_itens.length === 0) {
                $('#resumo-carrinho').hide();
                $('#itens-carrinho').hide();
                return;
            }

            let subtotal = carrinho.total_geral;
            let frete = parseFloat(carrinho.frete);
            let desconto = 0;

            // Se houver cupom, calcula desconto
            if (carrinho.cupom) {
                desconto = parseFloat(carrinho.cupom.desconto_aplicado || 0);

                // Exibe o cupom no layout
                $('#cupom-label').text(`Cupom: ${carrinho.cupom.codigo}`);
                $('#cupom-desconto').text(`− R$ ${desconto.toFixed(2).replace('.', ',')}`);
                $('#cupom-container').show();
            } else {
                $('#cupom-container').hide();
            }

            let total = subtotal + frete - desconto;

            // Atualiza os valores
            $('#subtotal').text('R$ ' + subtotal.toFixed(2).replace('.', ','));
            $('#frete').text(frete === 0 ? 'Grátis' : 'R$ ' + frete.toFixed(2).replace('.', ','));
            $('#total').text('R$ ' + total.toFixed(2).replace('.', ','));

            // Lista de itens
            const listaItens = $('#lista-itens-carrinho');
            listaItens.empty();

            carrinho.pedidos_itens.forEach(item => {
                const precoUnitario = parseFloat(item.preco_unitario);
                const quantidade = parseFloat(item.quantidade);
                const subtotalItem = precoUnitario * quantidade;

                const linha = `
                <tr>
                    <td>${item.produto_nome ?? 'Produto ' + item.produto_id}</td>
                    <td class="text-center">${quantidade}</td>
                    <td class="text-end">R$ ${precoUnitario.toFixed(2).replace('.', ',')}</td>
                    <td class="text-end">R$ ${subtotalItem.toFixed(2).replace('.', ',')}</td>
                </tr>
                `;
                listaItens.append(linha);
            });

            $('#itens-carrinho').show();
            $('#resumo-carrinho').show();
        };



        const carregarProdutos = () => {
            api.listarProdutos().then(data => {
                produtos = data;
                if (tabelaProdutos) {
                    tabelaProdutos.destroy();
                }

                tabelaProdutos = new simpleDatatables.DataTable("#produtos-table");

                produtos.forEach(p => {
                    tabelaProdutos.rows().add([
                        p.id.toString(),
                        p.nome,
                        'R$ ' + parseFloat(p.preco).toFixed(2).replace('.', ','),
                        (p.estoque || 0).toString().padStart(2, '0'),
                        gerarTextoVariacoes(p.variacoes),
                        `
                        <button class="btn btn-sm btn-success btn-comprar" data-id="${p.id}"><i class="bi bi-cart"></i></button>
                        <button class="btn btn-sm btn-primary btn-editar" data-id="${p.id}"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-danger btn-excluir" data-id="${p.id}"><i class="bi bi-trash"></i></button>
                        `
                    ]);
                });
            }).catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Não foi possível obter produtos.',
                });
            })
        };


        $('#form-produto').submit(function(e) {
            e.preventDefault();

            let nome = $('input[name="nome"]').val();
            let preco = parseFloat($('input[name="preco"]').maskMoney('unmasked')[0]);
            let estoque = $('input[name="estoque"]').val();

            let tipos = $('input[name="variacao_tipo[]"]').map((i, el) => $(el).val().trim()).get();
            let valores = $('input[name="variacao_valores[]"]').map((i, el) => $(el).val().trim()).get();

            let variacoes = [];

            // Validar
            if (nome == '' || preco == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atenção',
                    text: 'Preencha o nome e o preço do produto.'
                });
                return;
            }

            for (let i = 0; i < tipos.length; i++) {
                let tipo = tipos[i];
                let valor = valores[i];

                if ((tipo && !valor) || (!tipo && valor)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção',
                        text: 'Preencha o tipo e o valor da variação juntos ou deixe ambos vazios.'
                    });
                    return;
                }

                if (tipo && valor) {
                    variacoes.push({
                        tipo,
                        valor
                    });
                }
            }

            // Processar
            const produto = {
                id: editandoId,
                nome,
                preco,
                estoque,
                variacoes
            };

            api.salvarProduto(produto).then(() => {
                carregarProdutos();
                resetarFormulario();

            }).catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Erro ao salvar o produto.'
                });
            });
        });

        $(document).on('click', '.btn-editar', function() {
            let id = parseInt($(this).data('id'));
            let produto = produtos.find(p => p.id === id);

            $('input[name="nome"]').val(produto.nome);
            $('input[name="preco"]').val(produto.preco);
            $('input[name="estoque"]').val(produto.estoque);

            limparVariacoes();
            produto.variacoes.forEach(v => {
                $('#variacoes-container').append(gerarVariacaoHtml(v.tipo, v.valor));
            });


            editandoId = id;
        });

        $(document).on('click', '.btn-excluir', function() {
            const id = parseInt($(this).data('id'));

            Swal.fire({
                title: 'Tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    api.excluirProduto(id).then(() => {
                        carregarProdutos();
                        Swal.fire(
                            'Excluído!',
                            'O produto foi excluído com sucesso.',
                            'success'
                        );
                    }).catch(() => {
                        Swal.fire(
                            'Erro!',
                            'Não foi possível excluir o produto.',
                            'error'
                        );
                    });
                }
            });
        });

        $(document).on('click', '.btn-comprar', function() {
            const id = parseInt($(this).data('id'));
            const produto = produtos.find(p => p.id === id);

            if (!produto) {
                Swal.fire('Erro!', 'Produto não encontrado!', 'error');
                return;
            }

            Swal.fire({
                title: `Comprar "${produto.nome}"`,
                input: 'number',
                inputLabel: 'Informe a quantidade',
                inputValue: 1,
                inputAttributes: {
                    min: 1
                },
                showCancelButton: true,
                confirmButtonText: 'Continuar',
                cancelButtonText: 'Cancelar',
                preConfirm: (quantidade) => {
                    quantidade = parseInt(quantidade);
                    if (isNaN(quantidade) || quantidade < 1) {
                        Swal.showValidationMessage('Quantidade inválida');
                        return false;
                    }
                    if (quantidade > produto.estoque) {
                        Swal.showValidationMessage('Estoque insuficiente');
                        return false;
                    }
                    return quantidade;
                }
            }).then(result => {
                if (!result.isConfirmed) return;

                const quantidade = result.value;

                Swal.fire({
                    title: 'Informe seu CEP',
                    input: 'text',
                    inputLabel: 'CEP (Ex.: 00000-000)',
                    inputPlaceholder: '00000-000',
                    showCancelButton: true,
                    confirmButtonText: 'Finalizar compra',
                    cancelButtonText: 'Cancelar',
                    preConfirm: (cep) => {
                        if (!cep || !cep.match(/^\d{5}-?\d{3}$/)) {
                            Swal.showValidationMessage('CEP inválido');
                            return false;
                        }
                        return cep;
                    }
                }).then(cepResult => {
                    if (!cepResult.isConfirmed) return;

                    const cep = cepResult.value;

                    api.consultarCEP(cep).then(data => {
                        if (data.erro) {
                            Swal.fire('Erro!', 'CEP não encontrado!', 'error');
                            return;
                        }

                        Swal.fire(
                            'Endereço encontrado!',
                            `${data.logradouro}, ${data.bairro}, ${data.localidade}-${data.uf}`,
                            'info'
                        );

                        // Iniciar requisição
                        $.ajax({
                                url: `/api/carrinho`,
                                method: 'POST',
                                data: {
                                    produto_id: produto.id,
                                    quantidade: quantidade,
                                    cep: cep
                                },
                            })
                            .done(response => {
                                if (response.status) {
                                    const carrinhoBackend = response.carrinho;
                                    pedidoId = response.carrinho.id_pedido;

                                    atualizarResumoCarrinho(carrinhoBackend);
                                    carregarProdutos();
                                    carrinho = [];

                                    Swal.fire('Adicionado no carrinho !', 'Adicionado com sucesso.', 'success');
                                } else {
                                    Swal.fire('Erro!', response.message || 'Erro ao processar a compra.', 'error');
                                }
                            })
                            .fail(() => {
                                Swal.fire('Erro!', 'Erro na comunicação com o servidor.', 'error');
                            });

                        // Fim Requisição

                    });
                });
            });
        });

        $(document).on('click', '#btn-limpar', function() {
            $.ajax({
                url: '/api/carrinho',
                method: 'DELETE'
            })
            .then(response => {
                if (response.status) {
                    // Se o backend respondeu sucesso, limpa o carrinho e atualiza
                    carrinho = [];
                    atualizarResumoCarrinho();
                    swal.fire('Carrinho limpo!', 'O carrinho foi limpo com sucesso.', 'success');
                } else {
                    alert('Não foi possível limpar o carrinho.');
                }
            })
            .catch(() => {
                alert('Erro na conexão ao tentar limpar o carrinho.');
            });
        });

        $(document).on('click', '#btn-finalizar', function () {
            Swal.fire({
                title: 'Finalizar Pedido',
                html: `
                    <input type="text" id="swal-cep" class="swal2-input" placeholder="CEP">
                    <input type="text" id="swal-endereco" class="swal2-input" placeholder="Endereço">
                    <input type="text" id="swal-cidade" class="swal2-input" placeholder="Cidade">
                    <input type="text" id="swal-estado" class="swal2-input" placeholder="UF">
                    <input type="email" id="swal-email" class="swal2-input" placeholder="Seu e-mail">
                `,
                confirmButtonText: 'Confirmar Pedido',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                didOpen: () => {
                    const inputCEP = document.getElementById('swal-cep');

                    inputCEP.addEventListener('blur', async () => {
                        const cep = inputCEP.value.replace(/\D/g, '');
                        if (cep.length !== 8) return;

                        const data = await api.consultarCEP(cep);
                        if (data && !data.erro) {
                            document.getElementById('swal-endereco').value = `${data.logradouro} ${data.bairro}`.trim();
                            document.getElementById('swal-cidade').value = data.localidade;
                            document.getElementById('swal-estado').value = data.uf;
                        }
                    });
                },
                preConfirm: () => {
                    const email = document.getElementById('swal-email').value.trim();
                    const endereco = document.getElementById('swal-endereco').value.trim();
                    const cidade = document.getElementById('swal-cidade').value.trim();
                    const estado = document.getElementById('swal-estado').value.trim();
                    const cep = document.getElementById('swal-cep').value.trim();

                    if (!email || !endereco || !cidade || !estado || !cep) {
                        Swal.showValidationMessage('Por favor, preencha todos os campos.');
                        return false;
                    }

                    return { email, endereco, cidade, estado, cep };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const dadosCliente = result.value;

                    $.ajax({
                        url: '/api/carrinho/' + pedidoId,
                        method: 'PUT',
                        contentType: 'application/json',
                        data: JSON.stringify(dadosCliente),
                        dataType: 'json'
                    })
                        .then(response => {
                            if (response.status) {
                                carrinho = [];
                                atualizarResumoCarrinho();
                                Swal.fire('Pedido realizado!', 'Seu pedido foi efetuado com sucesso.', 'success');
                            } else {
                                Swal.fire('Erro!', 'Não foi possível finalizar o pedido.', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Erro!', 'Erro na conexão ao tentar finalizar o pedido.', 'error');
                        });
                }
            });
        });

        $(document).on('click', '#btn-cupom', function() {
            
            Swal.fire({
                title: 'Incluir Cupom',
                html: `
                    <input type="text" id="swal-cupom" class="swal2-input" placeholder="Cupom">
                `,
                confirmButtonText: 'Incluir Cupom',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const cupom = document.getElementById('swal-cupom').value.trim();

                    if (!cupom) {
                        Swal.showValidationMessage('Por favor, preencha todos os campos.');
                        return false;
                    }

                    return { cupom };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const cupom = result.value;

                    $.ajax({
                        url: '/api/carrinho/' + pedidoId +'/cupom',
                        method: 'PUT',
                        contentType: 'application/json',
                        data: JSON.stringify(cupom),
                        dataType: 'json'
                    })
                        .then(response => {
                            if (response.status) {
                                atualizarResumoCarrinho(response.carrinho);
                                Swal.fire('Cupom incluido!', 'Seu cupom foi incluido com sucesso.', 'success');
                            } else {
                                Swal.fire('Erro!', 'Não foi possível incluir o cupom.', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Erro!', 'Erro na conexão ao tentar incluir o cupom.', 'error');
                        });
                }
            });
        });


        $('#btn-add-variacao').click(() => {
            $('#variacoes-container').append(gerarVariacaoHtml());
        });

        $(document).on('click', '.btn-remover-variacao', function() {
            $(this).closest('.variacao-item').remove();
        });

        $(document).ready(() => {
            const carrinhoSessao = <?= json_encode($carrinho) ?>;
            console.log(carrinhoSessao);
            pedidoId = carrinhoSessao.id_pedido;
            $('.js-preco').maskMoney({
                prefix: 'R$ ',
                allowNegative: false,
                thousands: '.',
                decimal: ',',
                affixesStay: true
            });

            // Permitir apenas números no estoque
            $('.js-estoque').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            carregarProdutos();
            atualizarResumoCarrinho(carrinhoSessao);
        });
    </script>

</body>

</html>