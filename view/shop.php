<?php include_once("header.php") ?>
<link rel="stylesheet" tyle="text/css" href="lib/OwlCarousel/dist/assets/owl.carousel.min.css">
<link rel="stylesheet" tyle="text/css" href="lib/OwlCarousel/dist/assets/owl.theme.default.min.css">


	<section ng-controller="destaque-controller">
	
		<div class="container" id="destaque-produtos-container">

			<div id="destaque-produtos" class="owl-carousel2 owl-theme2">
					
				<div class="item" ng-repeat="produto in produtos">

					<div class="col-sm-6 col-imagem" >
						<a href="produto-{{produto.id_prod}}">
							<img src="img/produtos/{{produto.foto_principal}}" alt="{{produto.nome_prod_longo}}">
						</a>
					</div>
					<div class="col-sm-6 col-descricao">
						<h2>{{produto.nome_prod_longo}}</h2>
						<div class="box-valor">
							<div class="text-noboleto text-arial-cinza">no boleto</div>
							<div class="text-por text-arial-cinza">por</div>
							<div class="text-reais text-roxo">R$</div>
							<div class="text-valor text-roxo">{{produto.preco}}</div>
							<div class="text-valor-centavos text-roxo">,{{produto.centavos}}</div>
							<div class="text-parcelas text-arial-cinza">ou em até {{produto.parcelas}}x de R$ {{produto.parcela}}</div>
							<div class="text-total text-arial-cinza">total a prazo R$ {{produto.total}}</div>							
						</div>

						<a href="#" class="btn btn-comprar text-roxo"><i class="fas fa-shopping-cart"></i> compre agora</a>
					</div>		

				</div>
			
			</div>

			<button type="button" id="btn-destaque-prev"><i class="fas fa-angle-left"></i></button>
			<button type="button" id="btn-destaque-next"><i class="fas fa-angle-right"></i></button>
		
		</div>

		<div id="promocoes" class="container">
			<div class="row">
				<div class="col-md-2">
					
					<div class="box-promocao box-1">
						<p>Escolha por desconto</p>
					</div>


				</div>
				<div class="col-md-10">
						
						<div class="row-fluid">
							<div class="col-md-3">
								<div class="box-promocao">
									<div class="text-ate">até</div>
									<div class="text-numero">40</div>
									<div class="text-porcento">%</div>
									<div class="text-off">off</div>
								</div>								
							</div>
							<div class="col-md-3">
								<div class="box-promocao">
									<div class="text-ate">até</div>
									<div class="text-numero">60</div>
									<div class="text-porcento">%</div>
									<div class="text-off">off</div>
								</div>								
							</div>
							<div class="col-md-3">
								<div class="box-promocao">
									<div class="text-ate">até</div>
									<div class="text-numero">80</div>
									<div class="text-porcento">%</div>
									<div class="text-off">off</div>
								</div>								
							</div>
							<div class="col-md-3">
								<div class="box-promocao">
									<div class="text-ate">até</div>
									<div class="text-numero">85</div>
									<div class="text-porcento">%</div>
									<div class="text-off">off</div>
								</div>								
							</div>
						</div>

				</div>
			</div>
		</div>

		<div id="mais-buscados" class="container">
			
			<div class="row text-center title-default-roxo">
				<h2>Mais buscados</h2>
				<hr>
			</div>

			<div class="row">
				
				<div class="col-md-3" ng-repeat="produto in buscados">					
					<div class="box-produto-info" >
						<a href="produto-{{produto.id_prod}}">
							<img src="img/produtos/{{produto.foto_principal}}" alt="{{produto.nome_prod_longo}}" class="produto-img">
							<h3>{{produto.nome_prod_longo}}</h3>
							<div class="estrelas" data-score="{{produto.media}}"></div>
							<div class="text-qtd-reviews text-arial-cinza">({{produto.total_reviews}})</div>
							<div class="text-valor text-roxo">R$ {{produto.total}}</div>
							<div class="text-parcelado text-arial-cinza">{{produto.parcelas}}x de R$ {{produto.parcela}} sem juros</div>
						</a>
					</div>

				</div>

			</div>

		</div>
	
	</section>

<?php include_once("footer.php") ?>
<script type="text/javascript" src="lib/OwlCarousel/dist/owl.carousel.min.js"></script>
<script>

	angular.module("shop", []).controller("destaque-controller", function($scope, $http){
		
		$scope.produtos = [];
		$scope.buscados = [];

		var initCarousel = function(){
			//Configurando o Carrousel OWL 1.3
			    $("#destaque-produtos").owlCarousel({
			        items: 1,
			        autoPlay: 5000,        
			        singleItem: true			        
			    });

			    //Configurando carrousel para avançar e retroceder
			    var owlDestaque = $(".owl-carousel").data('owlCarousel');

			    $('#btn-destaque-prev').on("click", function () {
			        owlDestaque.prev();
			    });

			    $('#btn-destaque-next').on("click", function () {
			        // owl.trigger('next.owl.carousel', [velocidade em que o carrousel é deslizado, quanto maior, mais lento.]);
			        owlDestaque.next();
			    });
			};

		$http({
			method: 'GET',
			url: 'produtos',
		}).then(function successCallback(response){

			$scope.produtos = response.data;

			//função que para o java script para continuar executando
			setTimeout(initCarousel, 1);

		}, function errorCallback(response){

		});

		var initEstrelas = function(){
			//raty
		    $(".estrelas").each(function(){
		    	$(this).raty({
			    	starHalf:    'lib/raty/lib/images/star-half.png',
					starOff :    'lib/raty/lib/images/star-off.png',
					starOn  :    'lib/raty/lib/images/star-on.png',
					score 	: 	 parseFloat($(this).data("score")),
			    });
		    });
		};

		$http({
			method: 'GET',
			url: 'produtos-mais-buscados',
		}).then(function successCallback(response){

			$scope.buscados = response.data;

			//função que para o java script para continuar executando
			setTimeout(initEstrelas, 1);

		}, function errorCallback(response){

		});

		//valores fixos
		// $scope.produtos.push({
		// 	nome_prod_longo:"Smartphone Motorola Moto X Play Dual Chip Desbloqueado Andoid 5.1",
		// 	foto_principal:"moto-x.png",
		// 	preco:"1.259",
		// 	centavos:"10",
		// 	parcelas:8,
		// 	parcela:"174,88",
		// 	total:"1.399,00"
		// });		

		// $scope.produtos.push({
		// 	nome_prod_longo:"motox",
		// 	foto_principal:"moto-x.png",
		// 	preco:"1.259",
		// 	centavos:"10",
		// 	parcelas:8,
		// 	parcela:"174,88",
		// 	total:"1.399,00"
		// });	
	

	});	
</script>
