<?php include_once("header.php"); ?>

	<link rel="stylesheet" href="lib/plyr/dist/plyr.css">
	
		<section>
			<div id="call-to-action">
				<div class="container">
					
					<div class="row text-center">
						<h2>Vídeos</h2>
						<hr>
					</div>	

					<div class="row">
						
						<!-- <video src="mp4/highlights.mp4" controls poster="img/highlights.jpg"></video> -->

						<!-- Plyr.io -->
						<!-- <video src="mp4/highlights.mp4" id="player" controls data-plyr-config='{ "title": "This is an example video", "volume": 1, "debug": true }'></video> -->
						<video src="mp4/highlights.mp4" id="player" controls>
							<!-- Você pode escolher a legenda por track ou js -->
							<track kind="captions" label="Português (Brasil)" srclang="pt-br" src="vtt/legendas-highlights.vtt" default>
						</video>

						<input type="range" id="volume" name="" min="0" max="1" step="0.01" value="0.5">

						<button type="button" id="btn-play-pause" class="btn btn-success">Play</button>

						<!--<audio src="escreva aqui o caminho" controls></audio>-->

					</div>
				</div>
			</div>


			<div id="news" class="container" style="top:0;">

				<button type="button" id="btn-news-prev"><i class="fas fa-angle-left"></i></button>
				<button type="button" id="btn-news-next"><i class="fas fa-angle-right"></i></button>

				<div class="row text-center">
					<h2>Latest News</h2>
					<hr>
				</div>
				
				<div class="row thumbnails owl-carousel owl-carousel-theme">
					<div class="item" data-video="highlights">
						<div class="item-inner">
							<img src="img/highlights.jpg" alt="Noticia">
							<h3>highlights</h3>
						</div>
					</div>
					<div class="item" data-video="Orlando_City_Foundation_2015">
						<div class="item-inner">
							<img src="img/Orlando_City_Foundation_2015.jpg" alt="Noticia">
							<h3>Orlando City Foundation 2015</h3>
						</div>
					</div>					

				</div>

			</div>


		</section>

		<script type="text/javascript" src="lib/plyr/dist/plyr.js"></script>

		<?php include_once("footer.php"); ?>

		<script type="text/javascript">
			$(function(){

				$(".thumbnails .item").on("click", function(){

					// console.log($(this).data('video'));

					// Para mudar um atributo, selecione tag 'video' neste caso, e use a declaração do Jquery abaixo.
					$("video").attr({						
						// "atributo":"nome e caminho do arquivo"
						"src":"mp4/" + $(this).data('video') + ".mp4",
						"poster":"img/" + $(this).data('video') + ".jpg"

					});

					$("track").attr({"src":"vtt/legendas-" + $(this).data('video') + ".vtt"});
				
				});

				//change : significa alterar. $("#volume").on("change", function(){});
				//mousemove : significa, quando clicar e estiver movendo o mouse, faça algo. $("#volume").on("mousemove", function(){});
				$("#volume").on("mousemove", function(){
					$("video")[0].volume = $(this).val();
				});

				$("#btn-play-pause").on('click', function(){

					// toggleClass : Verifica qual das classes está no elemento e troca. Se estiver 'btn-success' ele troca para 'btn-danger', e o contrario também.
					$(this).toggleClass("btn-success btn-danger");

					var video = $("video")[0];

					// hasClass : verifica qual classe está no elemento, no caso pedi para ele procurar 'btn-danger'
					if($(this).hasClass("btn-danger")){

						$(this).text("Stop");
						video.play();

					}else{

						$(this).text("Play");
						video.pause();

					}
				});

			});

			// A declaração abaixo mostra no console quais os atributos o javascript pode acessar e manipular.
			// console.dir($("video")[0]);
		</script>

		<script type="text/javascript">
			//Configurando o Plyr
			const player = new Plyr('#player', {
				debug : false,
				title : "Video bom!",
				keyboard : {focused: true, global: true },
				tooltips : {controls: true, seek: true},
				volume : 0.5,				
			});

			//O código abaixo é para adicionar legenda via JS
				// player.source = {
				//     type: 'video',
				//     title: 'Video bom!',
				//     sources: [
				//         {
				//             src: 'mp4/highlights.mp4',
				//             type: 'video/mp4',
				//             size: 720,
				//         },
				//         // {
				//         //     src: '/path/to/movie.webm',
				//         //     type: 'video/webm',
				//         //     size: 1080,
				//         // },
				//     ],
				//     poster: 'img/highlights.jpg',
				//     tracks: [
				//         {
				//             kind: 'captions',
				//             label: 'Português (Brasil)',
				//             srclang: 'pt-br',
				//             src: 'vtt/legendas.vtt',
				//             default: true,
				//         },
				//         {
				//             kind: 'captions',
				//             label: 'French',
				//             srclang: 'fr',
				//             src: '/path/to/captions.fr.vtt',
				//         },
				//     ],
				// };
		</script>					