<?php include_once("header.php") ?>

<section ng-controller="cart-controller">
	
	<div class="container">

		<div class="row text-center title-default-roxo" style="margin:40px auto;">
			<h2>CARRINHO DE COMPRAS</h2>
			<hr>
		</div>
		
		<table id="cart-products" class="table table-bordered">
			<thead>
				<tr>
					<th colspan="2">Produto(s)</th>
					<th class="text-center">Quantidade</th>
					<th class="text-center">Entrega</th>
					<th class="text-center">Valor Unitário</th>
					<th class="text-center">Valor Total</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="produto in produtos">
					<td class="text-center"><img src="img/produtos/{{produto.foto_principal}}" alt="{{produto.foto_principal}"></td>
					<td>{{produto.nome_prod_longo}}</td>
					<td class="col-xs-2">
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn text-roxo" ng-click="removeQtd(produto)" type="button"><i class="fas fa-chevron-down"></i></button>
							</span>
							<input type="text" class="form-control" ng-model="produto.qtd_car">
							<span class="input-group-btn">
								<button class="btn text-roxo" type="button" ng-click="addQtd(produto)"><i class="fas fa-chevron-up"></i></button>
							</span>
						</div>
					</td>
					<td class="text-center col-xs-2">
						<p>Entrega para o <br> CEP: {{carrinho.cep}}</p>
						<strong class="text-roxo">{{carrinho.prazo}} dias úteis</strong>
					</td>
					<td class="text-center">R$ {{produto.preco}}</td>
					<td class="text-center">R$ {{produto.total}}</td>
					<td class="text-center">
						<button type="button" ng-click="removeAll(produto)" class="btn text-roxo"><i class="fas fa-times"></i></button>
					</td>
				</tr>
			</tbody>
		</table>

		<div id="calculo-de-frete" class="row">

			<div class="col-sm-8">
				<div class="box-outline-gray">
					<p style="margin:28px auto;">Simule o prazo de entrega e o frete para seu CEP abaixo:</p>
					<div class="input-group col-xs-4">
						<input type="text" class="form-control" ng-model="cep">
						<span class="input-group-btn">
					    	<button class="btn btn-default" ng-click="calcularFrete(cep)" type="button">Calcular Frete</button>
					    </span>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="box-cart-totais">
					<table class="table">
						<tr>
							<td>Subtotal ({{produtos.length}} item):</td>
							<td class="text-right">R$ {{carrinho.subtotal}}</td>
						</tr>
						<tr>
							<td>Frete:</td>
							<td class="text-right">R$ {{carrinho.frete}}</td>
						</tr>
						<tr style="border-top: 1px solid #999">
							<td class="text-roxo text-bold"></td>
							<td class="text-roxo text-bold text-right">R$ {{carrinho.total}}</td>
						</tr>
					</table>
				</div>
			</div>
			
		</div>
		
		<button class="btn btn-roxo pull-right" style="margin-top: 10px;">comprar</button>

	</div>

</section>

<?php include_once("footer.php") ?>

<script>
	angular.module("shop", []).controller("cart-controller", function($scope, $http){
		 
		var carregarCarrinho = function(){
			$http({
				method:'GET',
				url:'carrinho-dados'
			}).then(function(response){

				$scope.carrinho = {
					cep:response.data.cep_car,
					subtotal:response.data.subtotal_car,
					frete:response.data.frete_car,
					total:response.data.total_car,
					prazo:response.data.prazo_car
				};

				$scope.produtos = response.data.produtos;

				// console.log(response.data.produtos);

			}, function(response){

				console.error(response);

			});
		};

		$scope.addQtd = function(_produto){

			$http({
				method:'POST',
				url:'carrinho-produto',
				data:JSON.stringify({
					id_prod:_produto.id_prod
				})
			}).then(function(response){

				carregarCarrinho();
			
			}, function(){


			});

		};

		$scope.removeQtd = function(_produto){
			$http({
				method:'DELETE',
				url:'carrinho-produto',
				data:JSON.stringify({
					id_prod:_produto.id_prod
				})
			}).then(function(response){

				carregarCarrinho();
			
			}, function(){


			});
		};

		$scope.removeAll = function(_produto){

			$http({
				method:'DELETE',
				url:'carrinhoRemoveAll-'+_produto.id_prod
			}).then(function(response){
				
				carregarCarrinho();
			
			}, function(){


			});

		};


		$scope.calcularFrete = function(_cep){
			$http({
				method:'GET',
				url:'calculo-frete-'+_cep
			}).then(function(response){

				console.log(response.data);
				carregarCarrinho();
			
			}, function(){

			});
		};

		carregarCarrinho();

	});


</script>