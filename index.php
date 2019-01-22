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

    $sql = new Sql();

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

    echo json_encode($data);

});

$app->get('/produtos-mais-buscados', function(){

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

    echo json_encode($data);

});

// POST route
$app->post(
    '/post',
    function () {
        echo 'This is a POST route';
    }
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
