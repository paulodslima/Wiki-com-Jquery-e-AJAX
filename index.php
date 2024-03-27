<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QueryWiki</title>

    <!-- BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>

        $('document').ready(() => {

            //Carrega todos os conteudos salvos no banco de dados na página
            function carregarPagina(){

                $('main').html('<div id="conteudos" class="container py-5"></div>')

                $.ajax({
                    type: 'POST',
                    url: 'php/pesquisarConteudo.php',
                    data: 'titulo=',
                    dataType: 'json',
                    success: (dados) => { 
                        dados.forEach(index => {
                            //console.log(index.id);
                            //console.log(index.autor);
                            //console.log(index.titulo);
                            //console.log(index.conteudo);

                            let adicao_conteudo = '<div class="row border border-4 border-white rounded m-3"><div class="col-12 bg-primary p-3 topico"><h2>' + index.titulo + '</h2><p>Descrição: ' + index.conteudo + '.</p><p>Autor: ' + index.autor + '.</p><button type="button" data-id="' + index.id + '" data-tipo="acessar">Acessar</button></div></div>'
                            
                            $('#conteudos').append(adicao_conteudo)
                        })
                        tratarParagrafo()
                        ;
                     },
                    error: () => { 
                        console.log('não foi possível carregar nenhum conteúdo');
                     }
                });
            }

            //Pesquisar o conteudo digitado pelo usuário e exibe na página
            $('#barra-pesquisa').on('submit', (e) => {
                e.preventDefault();

                let valores_formulario = $('form').serialize();
                //console.log(valores_formulario);

                $.ajax({
                    type: 'POST',
                    url: 'php/pesquisarConteudo.php',
                    data: valores_formulario,
                    dataType: 'json',
                    success: (dados) => { 
                        $('#conteudos').html('')
                        dados.forEach(index => {
                            //console.log(index.id);
                            //console.log(index.autor);
                            //console.log(index.titulo);
                            //console.log(index.conteudo);

                            let adicao_conteudo = '<div class="row border border-4 border-white rounded m-3"><div class="col-12 bg-primary p-3 topico"><h2>' + index.titulo + '</h2><p>Descrição: ' + index.conteudo + '.</p><p>Autor: ' + index.autor + '.</p><button type="button" data-id="' + index.id + '" data-tipo="acessar">Acessar</button></div></div>'
                            
                            $('#conteudos').append(adicao_conteudo)
                        })
                        tratarParagrafo()
                        ;
                     },
                    error: () => { 
                        console.log('não foi possível carregar nenhum conteúdo');
                     }
                });
            });

            //Carrega o tópico solicitado na tela
            function pesquisar(id){
                //console.log(id)
                $.ajax({
                    type: 'POST',
                    url: 'php/pesquisarConteudo.php',
                    data: 'id=' + id,
                    dataType: 'json',
                    success: (dados) => { 
                        dados.forEach(index => {
                            //console.log(index.id);
                            //console.log(index.autor);
                            //console.log(index.titulo);
                            //console.log(index.conteudo);

                            let adicao_conteudo = '<button class="btn btn-dark m-2" data-tipo="voltar"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/></svg> Voltar</button><div class="container py-5"><div data-id="' + index.id + '" data-titulo="' + index.titulo + '"  id="titulo-topico" class="border-bottom border-2 border-dark d-flex justify-content-between px-2 py-1"><h1 class="h1 mr-auto">' + index.titulo + '</h1><button class="btn btn-md btn-primary" data-tipo="editar">Editar</button></div><div id="conteudo-topico" data-conteudo="' + index.conteudo + '" class="border-bottom border-2 border-dark p-3"><p>' + index.conteudo + '</p></div><div id="autor-topico" data-autor="' + index.autor + '" class="p-3"><p>Autor(es): ' + index.autor + '</p></div></div>'
                            
                            $('main').html(adicao_conteudo)
                        })
                        $(window).scrollTop($('nav').offset().top);
                        ;
                     },
                    error: () => { 
                        console.log('não foi possível carregar nenhum conteúdo');
                     }
                });
            }

            //Habilita a edição de conteúdo
            function editarConteudo(titulo, conteudo, autor){
                
                $('#titulo-topico').html('<h1 class="h1 mr-auto"><input id="titulo-novo" value="' + titulo + '" type="text"></h1><button class="btn btn-md btn-primary" data-tipo="salvar">salvar</button>')
                
                $('#conteudo-topico').html('<p>Conteúdo: <textarea id="conteudo-novo" style="width: 100%; min-height: 400px;">' + conteudo + '</textarea></p>')

                $('#autor-topico').html('<p>Autor(es): <input id="autor-novo" type="text" value="' + autor + '"></p>')
            }

            function salvarConteudo(titulo, conteudo, autor){

                let valor_id = $('#titulo-topico').data('id')
                let dados = ''
                //console.log("entrei na função!")
                if(valor_id == null || valor_id == undefined){
                    dados = 'titulo=' + titulo + '&conteudo=' + conteudo + '&autor=' + autor + '&id=""'
                }else{
                    dados = 'titulo=' + titulo + '&conteudo=' + conteudo + '&autor=' + autor + '&id=' + valor_id
                }
                $.ajax({
                    type: 'POST',
                    url: 'php/salvarTopico.php',
                    data: dados,
                    dataType: 'json',
                    success: (retorno) => { 
                        console.log(retorno[1])
                        if(retorno[1] !== '' && retorno[1] !== undefined){
                            alert(retorno[0])
                            pesquisar(retorno[1])
                        }
                        
                        if(retorno[1] == '' || retorno[1] == undefined){
                            carregarPagina()
                            alert(retorno[0])
                        }
                     },
                    error: () => { 
                        console.log('não foi possível carregar nenhum conteúdo');
                     }
                });
            }

            //Executa funções de acordo com o tipo de botão clicado
            $('body').on('click', 'button', e => {
                //Carrega o conteúdo do tópico solicitado
                if($(e.target).data('tipo') == 'acessar'){
                    //console.log($(e.target).data('id'));
                    pesquisar($(e.target).data('id'));
                }else if($(e.target).data('tipo') == 'editar'){
                    valor_titulo = $('#titulo-topico').data('titulo')
                    valor_conteudo = $('#conteudo-topico').data('conteudo')
                    valor_autor = $('#autor-topico').data('autor')
                    if(valor_titulo == undefined){
                        valor_titulo = ''
                    }
                    if(valor_conteudo == undefined){
                        valor_conteudo = ''
                    }
                    if(valor_autor == undefined){
                        valor_autor = ''
                    }
                    //console.log(valor_titulo)
                    editarConteudo(valor_titulo, valor_conteudo, valor_autor)
                }else if($(e.target).data('tipo') == 'voltar'){
                    //console.log('voltar')
                    carregarPagina()
                }else if($(e.target).data('tipo') == 'salvar'){
                    //console.log('salvar')
                    novo_titulo = $('#titulo-novo').val()
                    novo_conteudo = $('#conteudo-novo').val()
                    novo_autor = $('#autor-novo').val()
                    //console.log(novo_titulo)
                    //console.log(novo_conteudo)
                    //console.log(novo_autor)
                    if(novo_titulo == undefined || novo_conteudo == undefined || novo_autor == undefined){
                        alert("Algum dos campos está vázio, preencha para poder prosseguir")
                    }else if(novo_titulo == '' || novo_conteudo == '' || novo_autor == ''){
                        alert("Algum dos campos está vázio, preencha para poder prosseguir")
                    }else{
                        salvarConteudo(novo_titulo, novo_conteudo, novo_autor)
                    }
                }
            })

            $('#botao-adicionar').on('click', e => {
                //console.log($(e.target).data('tipo'))

                let adicao_conteudo = '<button class="btn btn-dark m-2" data-tipo="voltar"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/></svg> Voltar</button><div class="container py-5"><div data-id="" data-titulo="titulo"  id="titulo-topico" class="border-bottom border-2 border-dark d-flex justify-content-between px-2 py-1"><h1 class="h1 mr-auto">titulo</h1><button class="btn btn-md btn-primary" data-tipo="editar">Editar</button></div><div id="conteudo-topico" data-conteudo="conteudo" class="border-bottom border-2 border-dark p-3"><p>conteudo</p></div><div id="autor-topico" data-autor="autor" class="p-3"><p>Autor(es):autor</p></div></div>'
                            
                $('main').html(adicao_conteudo)

                editarConteudo('titulo', 'conteudo', '')
            })

            $(window).resize((e) => {
                if($(e.target).innerWidth() < 570){
                    $('#botao-adicionar').html('+')
                }else{
                    $('#botao-adicionar').html('Adicionar tópico')
                }
            })

            function tratarParagrafo(){
                var maxCaracteres = 500;

                $('.topico > p').each(function(){
                    var paragrafo = $(this);
                    if (paragrafo.text().length > maxCaracteres) {
                        var textoLimitado = paragrafo.text().substring(0, maxCaracteres) + '...';
                        paragrafo.text(textoLimitado);
                        }
                    }
                )
            }

            carregarPagina()


        })
    </script>
</head>
<body class="bg-secondary">
    <header>
        <nav class="navbar bg-dark">
            <div class="container-fluid">

              <!-- Logo do site -->  
              <a href="#" class="navbar-brand text-light">
                <span>
                    <img src="https://www.vectorlogo.zone/logos/jquery/jquery-icon.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    <span class="text-danger">Query</span>Wiki
                </span>
              </a>

              <button id="botao-adicionar" class="btn btn-primary" title="Adicionar tópico" data-tipo="adicionar">Adicionar tópico</button>

              <!-- Barra de pesquisa -->
              <form id="barra-pesquisa" class="d-flex" role="search">
                <input name="titulo" class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                          </svg>
                    </span>
                </button>
              </form>
            </div>
          </nav>
    </header>

    <main>
        <div id="conteudos" class="container py-5">
            <!-- Modelo padrão do bloco de conteúdo 
            <div class="row border border-4 border-white rounded m-3">
                <div class="col-12 bg-primary p-3">
                    <h2>Título</h2>
                    <p>Descrição: Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quaerat recusandae minima officiis pariatur maxime accusamus aut deserunt nam minus, consequuntur dolore odit ipsa cumque nobis nisi sed quas blanditiis repellendus.</p>
                    <button>Acessar</button>
                </div>
            </div>
            -->
        </div>
    </main>

    <footer>

    </footer>

    <script>

    </script>
</body>
</html>