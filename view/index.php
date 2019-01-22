<!-- <?php 
	//require_once : o código abaixo pega todo conteúdo do arquivo 'configuration' e trás para meu documento atual.
	// require_once("inc/configuration.php");

	// $sql = new Sql();

	// $result = $sql->query("SELECT * FROM tb_produtos");

	// //mysqli_fetch_array($var); : Como todo select retorna várias linhas, o código 'mysqli_fetch_array($var)' armazena em um array.
	// while($row = mysqli_fetch_array($result)){
	// 	//var_dump() : Este método informa as informações e o tipo de dado (String, int, float)
	// 	var_dump($row);
	
	// }
	// exit

?> -->
<?php include_once("header.php"); ?>
		<section>

			<div id="banner">
				<h1>Orlando City <small>Orlando City Soccer Club</small></h1>
			</div>

			<div id="news" class="container">

				<div class="row text-center">
					<h2>Latest News</h2>
					<hr>
				</div>
				
				<button type="button" id="btn-news-prev"><i class="fas fa-angle-left"></i></button>
				<button type="button" id="btn-news-next"><i class="fas fa-angle-right"></i></button>

				<div class="row thumbnails owl-carousel owl-carousel-theme">
					<div class="item">
						<div class="item-inner">
							<img src="img/noticia-thumb.jpg" alt="Noticia">
							<h3>Orlando City Acquires Goalkeeper Joe Bendik from Toronto FC</h3>
							<time>December 21, 2015</time>
						</div>
					</div>
					<div class="item">
						<div class="item-inner">
							<img src="img/noticia-thumb.jpg" alt="Noticia">
							<h3>Orlando City Acquires Goalkeeper Joe Bendik from Toronto FC</h3>
							<time>December 21, 2015</time>
						</div>
					</div>
					<div class="item">
						<div class="item-inner">
							<img src="img/noticia-thumb.jpg" alt="Noticia">
							<h3>Orlando City Acquires Goalkeeper Joe Bendik from Toronto FC</h3>
							<time>December 21, 2015</time>
						</div>
					</div>
					<div class="item">
						<div class="item-inner">
							<img src="img/noticia-thumb.jpg" alt="Noticia">
							<h3>Orlando City Acquires Goalkeeper Joe Bendik from Toronto FC</h3>
							<time>December 21, 2015</time>
						</div>
					</div>
					<div class="item">
						<div class="item-inner">
							<img src="img/noticia-thumb.jpg" alt="Noticia">
							<h3>Orlando City Acquires Goalkeeper Joe Bendik from Toronto FC</h3>
							<time>December 21, 2015</time>
						</div>
					</div>
					<div class="item">
						<div class="item-inner">
							<img src="img/noticia-thumb.jpg" alt="Noticia">
							<h3>Orlando City Acquires Goalkeeper Joe Bendik from Toronto FC</h3>
							<time>December 21, 2015</time>
						</div>
					</div>
					<div class="item">
						<div class="item-inner">
							<img src="img/noticia-thumb.jpg" alt="Noticia">
							<h3>Orlando City Acquires Goalkeeper Joe Bendik from Toronto FC</h3>
							<time>December 21, 2015</time>
						</div>
					</div>
					<div class="item">
						<div class="item-inner">
							<img src="img/noticia-thumb.jpg" alt="Noticia">
							<h3>Orlando City Acquires Goalkeeper Joe Bendik from Toronto FC</h3>
							<time>December 21, 2015</time>
						</div>
					</div>
					<div class="item">
						<div class="item-inner">
							<img src="img/noticia-thumb.jpg" alt="Noticia">
							<h3>Orlando City Acquires Goalkeeper Joe Bendik from Toronto FC</h3>
							<time>December 21, 2015</time>
						</div>
					</div>

				</div>

			</div>

			<div id="estatisticas">
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<p>61348<small>Stadium Capacity</small></p>
						</div>
						<div class="col-md-4">
							<p>2010<small>Founded</small></p>
						</div>
						<div class="col-md-4">
							<p>7th<small>Eastern Conference</small></p>
						</div>
					</div>
				</div>			

			</div>

			<div id="call-to-action">

				<div class="container text-center">
					<div class="row ">
						<h2>American club number one in Brazil</h2>
						<hr>
					</div>

					<div class="row">
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.
						</p>
					</div>

					<div class="text-center">
						<div class="row row-max-400">
							<div class="col-xs-6">
								<a href="shop" class="btn btn-roxo">Shop</a>
							</div>
							<div class="col-xs-6">
								<a href="#" class="btn btn-amarelo">Register</a>
							</div>
						</div>
					</div>

				</div>
			</div>

		</section>
<?php include_once("footer.php") ?>
		

