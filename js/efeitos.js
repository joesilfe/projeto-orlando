//estrutura básica é chamado de prólogo
//$(documento).ready(function(){escreva aqui o código}) : Significa quando a página carregar, execute o 'código' que será executado.
$(document).ready(function () {

    //Esta função no jquery é chamada quando vocÊ passa o mouse em cima do elemento, neste caso é o logo do orlando City.
    $("#logotipo").on("mouseover", function () {

        //Aplicando estilização de css com Jquery.
        /*$("#banner h1").css({
            "color":"red",
            "font-size":"12em", 
            "transition":"2s"
        });*/

        //Aplicando classe no elemento h1.
        $("#banner h1").addClass("efeito");

    }).on("mouseout", function () {

        //Removendo classe no elemento h1.
        //Obs.: Esta classe deve estar dentro do arquivo css estilizada, para quando o jquery aplicar o navegador ja reconher e estilizar o elemento.
        $("#banner h1").removeClass("efeito");

    });

    //Estilizando o campo de busca.
    //A propriedade Focus é ativada quando o usuário clicar no campo de busca.
    $("#input-search").on("focus", function () {

        $("li.search").addClass("ativo");

        // A propriedade 'blur' é ativada quando o usuário clicar fora do campo de busca.
    }).on("blur", function () {

        $("li.search").removeClass("ativo");

    });

    //Configurando o Carrousel OWL
    $(".thumbnails").owlCarousel({
        loop: true,
        autoplayTimeout: 2800,
        autoplayHoverPause: true,
        margin: 10,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    //Configurando carrousel para avançar e retroceder
    var owl = $(".owl-carousel").owlCarousel();

    $('#btn-news-prev').on("click", function () {
        owl.trigger('prev.owl.carousel');
    });

    $('#btn-news-next').on("click", function () {
        // owl.trigger('next.owl.carousel', [velocidade em que o carrousel é deslizado, quanto maior, mais lento.]);
        owl.trigger('next.owl.carousel', [300]);
    });

    //Configurando botão do footer para subir ao topo quando for clicado
    $("#page-up").on("click", function (event) {

        $("html").animate({
            scrollTop: 0
        }, 1000); /*tempo que a animação deve durar*/

        //o evento abaixo cancela o targetBlank transformando tudo em padrão
        event.preventDefault();

    });

    //configurando menu do mobile para abrir e fechar
    $("#btn-bars").on("click", function(){
    	//toggleClass : O toggleClass significa 'retire esta classe', se ela estiver retire, se não estiver coloque.
    	$("header").toggleClass("show-menu");
    });

    $(".btn-close, #menu-mobile-mask").on("click", function(){
    	//toggleClass : O toggleClass significa 'retire ou coloque esta classe'. Se ela estiver, retire. Se não estiver, coloque.
    	$("header").toggleClass("show-menu");
    });

    //Configurando o botão pesquisar
    $("#btn-search").on("click", function(){
    	$("header").toggleClass("open-search");
    	$("#input-search-mobile").focus();

    });




});