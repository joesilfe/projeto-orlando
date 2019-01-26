<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'inc/Slim-2.x/Slim/Slim.php';
require_once 'inc/configuration.php';
require_once("inc/php-calcular-frete-correios/frete.php");

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// GET route
$app->get(
    '/home',
    function () {
        //require_once : redirecione para "view/index.php"
        require_once("view/index.php");
    }
);

$app->get(
    '/videos',
    function () {
        require_once("view/videos.php");
    }
);

$app->get(
    '/shop',
    function () {
        require_once("view/shop.php");
    }
);

$app->get('/produtos', function(){

    //Instanciando a classe SQL
    $sql = new Sql();
    
    //Listando produtos no carrousel em ordem de preço
    $data = $sql->select("SELECT * FROM tb_produtos WHERE preco_promorcional > 0 order by preco_promorcional desc limit 3;");

    // &$produto : se tornou uma variavel com referência devido '&' acompannhar

    foreach ($data as &$produto) {
        $preco = $produto['preco'];
        $centavos = explode(".", $preco);
        $produto['preco'] = number_format($preco, 0, ",", "."); 
        $produto['centavos'] = end($centavos);
        $produto['parcelas'] = 10;
        $produto['parcela'] = number_format($preco/$produto['parcelas'], 2, ",", ".");
        $produto['total'] = number_format($preco, 2, ",", ".");

    }

    //codificano em JSON
    echo json_encode($data);

});

$app->get('/produtos-mais-buscados', function(){

    //Instanciando a classe SQL
    $sql = new Sql();

    $data = $sql->select("
    SELECT 
        tb_produtos.id_prod,
        tb_produtos.nome_prod_curto,
        tb_produtos.nome_prod_longo,
        tb_produtos.codigo_interno,
        tb_produtos.id_cat,
        tb_produtos.preco,
        tb_produtos.peso,
        tb_produtos.largura_centimetro,
        tb_produtos.altura_centimetro,
        tb_produtos.quantidade_estoque,
        tb_produtos.preco_promorcional,
        tb_produtos.foto_principal,
        tb_produtos.visivel,
    cast(avg(review) as dec(10,2)) as media, 
    count(id_prod) as total_reviews
    FROM tb_produtos 
    INNER JOIN tb_reviews USING(id_prod) 
    GROUP BY 
        tb_produtos.id_prod,
        tb_produtos.nome_prod_curto,
        tb_produtos.nome_prod_longo,
        tb_produtos.codigo_interno,
        tb_produtos.id_cat,
        tb_produtos.preco,
        tb_produtos.peso,
        tb_produtos.largura_centimetro,
        tb_produtos.altura_centimetro,
        tb_produtos.quantidade_estoque,
        tb_produtos.preco_promorcional,
        tb_produtos.foto_principal,
        tb_produtos.visivel
    LIMIT 4;
    ");

    // &$produto : se tornou uma variavel com referência devido '&' acompannhar

    foreach ($data as &$produto) {
        $preco = $produto['preco'];
        $centavos = explode(".", $preco);
        $produto['preco'] = number_format($preco, 0, ",", "."); 
        $produto['centavos'] = end($centavos);
        $produto['parcelas'] = 10;
        $produto['parcela'] = number_format($preco/$produto['parcelas'], 2, ",", ".");
        $produto['total'] = number_format($preco, 2, ",", ".");

    }

    //codificano em JSON
    echo json_encode($data);

});

$app->get("/produto-:id_prod", function($id_prod){

    //Instanciando a classe SQL
    $sql = new Sql();

    //capturando id_prod pela url e passando no select
    $produtos = $sql->select("SELECT * FROM tb_produtos WHERE id_prod = $id_prod");

    $produto = $produtos[0];

    $preco = $produto['preco'];
    $centavos = explode(".", $preco);
    $produto['preco'] = number_format($preco, 0, ",", "."); 
    $produto['centavos'] = end($centavos);
    $produto['parcelas'] = 10;
    $produto['parcela'] = number_format($preco/$produto['parcelas'], 2, ",", ".");
    $produto['total'] = number_format($preco, 2, ",", ".");

    //use o var_damp para debugar.
    //var_dump(adicone a variável aqui);

    require_once("view/shop-produto.php"); 
});


$app->get('/cart', function(){
    //redirecionando para cart.php ao escrever cart
    require_once("view/cart.php");
});

$app->get('/carrinho-dados', function(){    

    //Instanciando a classe SQL
    $sql = new Sql();

    //Verifica se a sessão já foi criada, caso não existir, é criado uma sessão
    $result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

    $carrinho = $result[0];

    //Instanciando a classe SQL
    $sql = new Sql();

    //formatando valores para o carrinho
    $carrinho['produtos'] = $sql->select("CALL sp_carrinhosprodutos_list(".$carrinho['id_car'].")");
    
    $carrinho['total_car'] = number_format((float)$carrinho['total_car'], 2, ",", ".");
    $carrinho['subtotal_car'] = number_format((float)$carrinho['subtotal_car'], 2, ",", ".");
    $carrinho['frete_car'] = number_format((float)$carrinho['frete_car'], 2, ",", ".");    
    
    //codificano em JSON
    echo json_encode($carrinho);

});

$app->get('/carrinhoAdd-:id_prod', function($id_prod){

    //Instanciando a classe SQL
    $sql = new Sql();

    //procura a sessão, caso não existir cria a sessão
    $result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

    //Acessa o 'id_car' o id do produto no carrinho na tabela do produto
    $carrinho = $result[0];

    //Instanciando a classe SQL
    $sql = new Sql();

    //Adiciona o produto ao carrinho, se tem 1, passa a ter 2
    $sql->query("CALL sp_carrinhosprodutos_add(".$carrinho['id_car'].", ".$id_prod.")");

    //Após adicionar o produto, o usuário é direcionado para a págian cart
    header("Location: cart");
    exit;
   
});

$app->delete("/carrinhoRemoveAll-:id_prod", function($id_prod){

    //Instanciando a classe SQL
    $sql = new Sql();

    //procura a sessão do carrinho
    $result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

    //Acessa o 'id_car' o id do produto no carrinho na tabela do produto
    $carrinho = $result[0];
    
    //Instanciando a classe SQL
    $sql = new Sql();

    //Removendo todo produto do carrinho e sua quantidade, se tem 2, passa a ter 0, o produto sai do carrinho
    $sql->query("CALL sp_carrinhosprodutostodos_rem(".$carrinho['id_car'].", ".$id_prod.")");

    //codificano em JSON e adicionando em array
    echo json_encode(array(
        "success"=>true
    ));
});

$app->post('/carrinho-produto', function(){
    //captura o id do produto que o angular envia por json e transforma em array quando utiliza a palavra chave 'true'.
    $data = json_decode(file_get_contents("php://input"), true);

    //Instanciando a classe SQL
    $sql = new Sql();

    //procura a sessão, caso não existir cria a sessão
    $result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

    //Acessa o 'id_car' o id do produto no carrinho na tabela do produto
    $carrinho = $result[0];
    
    //Instanciando a classe SQL
    //Instanciando a classe SQL
    $sql = new Sql();

    //Adicionando o produto ao carrinho
    $sql->query("CALL sp_carrinhosprodutos_add(".$carrinho['id_car'].", ".$data['id_prod'].")");

    //codificano em JSON e adicionando em array
    echo json_encode(array(
        "success"=>true
    ));

});

$app->delete('/carrinho-produto', function(){
    //captura o id do produto que o angular envia por json e transforma em array quando utiliza a palavra chave 'true'.
    $data = json_decode(file_get_contents("php://input"), true);

    //Instanciando a classe SQL
    $sql = new Sql();

    //cria uma sessão
    $result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

    //Acessa o 'id_car' o id do carrinho na tabela do produto
    $carrinho = $result[0];
    
    //Instanciando a classe SQL
    $sql = new Sql();

    //Removendo o produto mesmo do carrinho por quantidade, se tem 2, passa a ter 1 
    $sql->query("CALL sp_carrinhosprodutos_rem(".$carrinho['id_car'].", ".$data['id_prod'].")");

    //codificano em JSON e adicionando em array
    echo json_encode(array(
        "success"=>true
    ));

});

$app->get("/calculo-frete-:cep", function($cep){    

    //Instanciando a classe SQL
    $sql = new Sql();

    //procura a sessão, caso não existir cria a sessão
    $result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

    //Acessa o 'id_car' o id do carrinho na tabela do produto
    $carrinho = $result[0];
    
    //Instanciando a classe SQL
    $sql = new Sql();

    //Procura no carrinho os dados do produto para calcular frete
    $produtos = $sql->select("CALL sp_carrinhosprodutosfrete_list(".$carrinho['id_car'].")");

    //adicionando valores em variáveis
    $peso = 0; 
    $comprimento = 0; 
    $altura = 0; 
    $largura = 0; 
    $valor = 0;
    
    //Verificando todos os produtos do carrinho para calculo do frete
    foreach ($produtos as $produto) {
        $peso =+ $produto['peso'];
        $comprimento =+ $produto['comprimento'];
        $altura =+ $produto['altura'];
        $largura =+ $produto['largura'];
        $valor =+ $produto['preco'];
    }

    //removendo traços e espaço do número cep
    $cep = trim(str_replace('-', '', $cep));

    //Calculando Frete
    $frete = new Frete(
        $cepDeOrigem = '01418100', 
        $cepDeDestino = $cep, 
        $peso, 
        $comprimento, 
        $altura, 
        $largura, 
        $valor
    );

    //Instanciando a classe SQL
    $sql = new Sql();

    //Atualiza no banco os dados de frete no banco do carrinho
    $sql->query("
        UPDATE tb_carrinhos 
        SET 
            cep_car = '".$cep."', 
            frete_car = ".$frete->getValor().",
            prazo_car = ".$frete->getPrazoEntrega()."
        WHERE 
            id_car = ".$carrinho['id_car']
        );

    //codificano em JSON e adicionando em array
    //echo json_encode(array(
    //     'valor_frete'=>$frete->getValor(),
    //     'erro'=>$frete->getMsgErro(),
    //     'prazo'=>$frete->getPrazoEntrega()  
    // ));


    //codificano em JSON e adicionando em array
    echo json_encode(array(
        'success'=>true
    ));

});

// PUT route
// $app->put(
//     '/put',
//     function () {
//         echo 'This is a PUT route';
//     }
// );

// PATCH route
// $app->patch('/patch', function () {
//     echo 'This is a PATCH route';
// });

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */

$app->run();