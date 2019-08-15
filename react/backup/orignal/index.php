<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>



<style>
	* {
		box-sizing: border-box;
	}

	.container {
		position: relative;
		text-align: left;
		color: Black;
		overflow: hidden;
	}

	.top-right {
		position: absolute;
		top: 16px;
		right: 16px;
		width: 90px;
	}

	.image1 {
		position: relative;
		top: 0;
		left: 0;
	}

	.centered {
		position: absolute;
		top: 42%;
		font-family: Open Sans;
		font-size: 170%;
		left: 77%;
		transform: translate(-50%, -50%);
		width: 44%;
		text-align: left;
	}

	h1.simple {
		font-family: 'Open sans';
		letter-spacing: 1.6px;
		font-size: 36px;
		line-height: normal;
		font-weight: 300;
		text-transform: uppercase;
	}

	.centered p {
		font-size: 18px;
		line-height: 20px;
		font-weight: 100;
		margin-top: -20px;
	}

	.transition {
		background-color: #ffffff;
		color: Black;
		cursor: pointer;
		padding: 16px 12px;
		width: 100%;
		border: 1px Solid #000;
		text-align: left;
		outline: none;
		font-size: 14px;
		transition: 0.4s;
		border-radius: 0;
		font-family: 'Open sans';
		letter-spacing: 1px;
		font-weight: 400;
	}
	
	.img-phone-calc {
		width: 47%;
		margin: 0 !important;
		display: inline-block !important;
	}

	.transition:before {
		content: '\002B';
		color: Black;
		font-weight: bold;
		padding-right: 8px;
		display: inline-block;
		vertical-align: -3px;
		font-size: 24px;
	}

	.transition.arrow:before {
		content: '\2212';
		color: Black;
		font-weight: bold;
		padding-right: 8px;
		display: inline-block;
		vertical-align: -3px;
		font-size: 24px;
	}

	.collapse {
		padding: 0 18px;
		background-color: 'white';
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.2s ease-out;
		font-weight: 300;
	}

	.collapse p {
		padding: 18px;
		margin: 0;
		line-height: normal;
		font-size: 14px
	}

	.accordion {
		background-color: white;
		color: #444;
		cursor: pointer;
		padding: 18px;
		width: 100%;
		border: none;
		text-align: left;
		font-weight: 600;
		font-size: 18px;
		outline: none;
		position: relative;
	}
	
	.accordion:active,
	.accordion:focus,
	.transition:active,
	.transition:focus {
		outline: none;
	}
	
	.svg-triangle {
		position: absolute;
		left: -20px;
		top: 0;
		bottom: 0;
		margin: auto;
		color: transparent;
		stroke: #73AD21;
	}
	
	.accordion.active .svg-triangle{
		transform: rotate(90deg);
	}

	.row:after {
		content: "";
		display: table;
		clear: both;
	}


	.column {
		display: table-cell;
		width: 50%;
		padding: 10px;
		vertical-align: top;
		margin-bottom: -25px;
	}

	.panel {
		padding: 0 38px 0 10px;
		background-color: white;
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.2s ease-out;
		font-size: 14px;
	}

	button.transition.arrow {
		border-bottom: 0
	}

	.collapse {
		border: 1px solid #000;
		border-top: 0;
		margin-bottom: -25px;
	}

	.container-content {
		max-width: 1170px;
		margin: 0 auto;
		 display: -webkit-box;
		display: -moz-box;
		display: box;

		-webkit-box-orient: vertical;
		-moz-box-orient: vertical;
		box-orient: vertical;
		width: 85%;
	}

	.container-content button.accordion {
		background: transparent;
		border: none;
		font-size: 24px;
	}

	.container-content button.transition {
		background: transparent;
		border-bottom: 0
	}

	.container-content .box {
		padding-top: 30px;
	}

	.container-content h2 {
		font-size: 24px;
		text-transform: uppercase;
		font-weight: 400
	}

	.img-energy {
		max-height: 430px;
		object-fit: unset;
		background: top center;
	}
	
	a.button {
		background-color: #73A421;
		border: none;
		color: #fff;
		padding: 18px 40px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 30px;
		margin: 4px 2px;
		cursor: pointer;
		font-family: 'Open sans';
		font-size: 24px;
		letter-spacing: 4px;
		border-radius: 0;
		font-weight: 600;
		transition: 0.3s linear all;
		max-width: 100%;
	}

	a.button:hover {
		background: #EDAD3C;
	}

	a.button.hollow {
		background-color: transparent;
		color: #000;
		border: 2px solid #73A421;
	}

	a.button.hollow:hover {
		border: 2px solid #EDAD3C;
	}

	.centered a.button.hollow {
		margin: 4px 0 !important;
	}
	
	.companies-sec-title {
		color: #808080;
    	font-size: 20px;
		margin-bottom: -10px;
		text-align: left;
	}
	
	.video-container {
		text-align: left;
	}
	
	.companies-box {
		width: 100%;
		height: auto;
		display: inline-block;
		text-align: justify;
		position: relative;
		padding-top: 20px;
	}
	
	.companies-box-border {
		width: 100%;
		height: 1px;
		margin: 10px 0;
		margin-top: 0;
		background-color: #AFABAB;
		display: inline-block;
	}
	
	.companies-box-item {
		position: relative;
		display: inline-block;
		width: calc(32.0% - 10px);
		margin 5px;
		height: 100px;
		background-position: center;
		background-repeat: no-repeat;
		background-size: contain;
		vertical-align: top;
	}
	
	.signup-box {
		width: 80%;
		margin: 60px 10% 90px;
		display: block;
		text-align: center;
	}
	
	.signup-box > p{
		font-size: 14px;
		color: #808080;
	}
	
	.video-item {
		width: 90%;
		display: inline-block;
	}

	.banner-img {
		background: url('https://energy.sveasolar.se/wp-content/uploads/2019/03/Picture1.png') top center no-repeat;
		object-fit: cover;
		padding: 300px 0;
		width: 100%;
		background-size: cover;

	}
	
	.app-icons { width: 100%; margin: 30px auto;}
	.app-icons a {display: inline-block; margin-right: 4px; vertical-align: middle; max-width: 150px; }

	@media (max-width: 768px) {
		.centered {
			font-size: 100%;
			line-height: normal;
		}
		
		.companies-sec-title {
			text-align: center;
			font-size: 25px;
		}
		
		.panel li {
			text-align: left;
		}

		.column {
			width: 100%;
			margin: 20px 0;
			display: block;
		}
		
		h1.simple {
			font-size: 32px;
		}
		
		.column.first {
			margin-top: 0 !important;
		}
		
		.container-content {
			margin-top: 0 !important;
		}

		.container-content .box {
			padding-top: 5px;
			text-align: left;
		}
		
		.img-phone-calc {
			width: 92% !important;
		}

		.column.left {
			width: 100%;
		}

		.panel {
			padding: 0 18px;
		}
		
		.column.second {
			-webkit-box-ordinal-group: 2;
			-moz-box-ordinal-group: 2;
			box-ordinal-group: 2;
		}
		
		.accordion {
			display: inline-block;
			width: auto;
		}
		
		a.button {
			padding: 18px 15px;
			font-size: 16px
		}
		
		.video-item {
			width: 100%;
		}
		
		.fix-box {
			margin-left: 26%;
		}
		
		.centered p {
			margin-bottom: 2px;
		}
		
		/* .companies-box-item {
			max-width: 70%;
		} */
	}

	@media (max-width: 500px) {
		.centered {
			font-size: initial;
			left: 70%;
			width: 50%;
		}
		
		.fix-box {
			margin-left: 22%;
		}

		.banner-img {
			padding: 200px 0;
		}

		.top-right {
			max-width: 39px;
		}
		
		a.button {
			padding: 18px 10px;
			font-size: 14px;
			width: 100%;
		}

		.site-footer {
			text-align: center;
		}
		
		.container-content button.accordion {
			padding: 20px 0;
			font-size: 16px !important;
		}
		
		.svg-triangle {
			left: -30px;
		}
		
		.box.video-container {
			text-align: center;
		}
		.app-icons a {text-align: center}
	}
	
</style>


<div class="container">
	<div class="banner-img">
		<div class="top-right">
			<img
				class="image1"
				src="https://energy.sveasolar.se/wp-content/uploads/2019/03/SVEA_Solar_Sol_ICO_2x.png"
			/>
		</div>
		<div class="centered">
			<h1 class="simple">Enkelt & Grönt </h1>
			<p>Ett energibolag som kommer finnas generationer framöver</p>
			<a href="https://energy.sveasolar.se/byt-elavtal/" class="button hollow" title="BYT ELAVTAL"> BYT ELAVTAL
			</a>
		</div>
	</div>
</div>

<div class="row container-content">
	<div class="column second">
		<div class="box fix-box">
			<button class="accordion">
				<svg 
					 xmlns	= "http://www.w3.org/2000/svg" 
					 version= "1.1" 
					 class	= "svg-triangle" 
					 width	= '35' 
					 height	= '35'
				>
  					<polygon points="20,18.5 0,35 0,0"/>
				</svg>
				Ja, vi säljer nu energi
			</button>
			<div class="panel">
				<p>SVEA Energy gör det enkelt att byta till ett
					grönt elavtal. Grön elektricitet är ett
					ekonomiskt hållbart alternativ där man även ger
					tillbaka till miljön. Genom att välja SVEA Energy
					får du bättre kontroll över din elkonsumtion
					och dina elpriser. SVEA Energy och SVEA Solar
					är helt oberoende av varandra, vilket innebär att
					man kan ha elavtal hos oss utan solceller eller
					vice versa.</p>
			</div>

			<button class="accordion">
				<svg 
					 xmlns	= "http://www.w3.org/2000/svg" 
					 version= "1.1" 
					 class	= "svg-triangle" 
					 width	= '35' 
					 height	= '35'
				>
  					<polygon points="20,18.5 0,35 0,0"/>
				</svg>
				Varför välja SVEA Energy
			</button>
			<div class="panel">
				<p>SVEA Energy hjälper dig optimera din
					energikonsumtion. Samla fakturor samt all
					förbrukningsdata på ett ställe. Med smarta lösningar, grön
					elektricitet och full översikt kan du som kund alltså få en
					billigare elräkning. Med SVEA Energy som
					din leverantör får du en komplett lösning som inte
					finns någon annanstans på marknaden.

					Med SVEA Energy får du:</p>
				<ul>
					<li>Smarta molntjänster</li>
					<li>SVEA Energy app</li>
					<li>Prisvärt och grönt elavtal</li>
					<li>Möjligheten att påverka din konsumtion</li>
					<li>Ett enkelt elavtal</li>
				</ul>

			</div>

			<button class="accordion">
				<svg 
					 xmlns	= "http://www.w3.org/2000/svg" 
					 version= "1.1" 
					 class	= "svg-triangle" 
					 width	= '35' 
					 height	= '35'
				>
					<polygon points="20,18.5 0,35 0,0"/>
				</svg>
				Inga skelett i garderoben
			</button>
			<div class="panel">
				<p>Ett energibolag utan skelett i garderoben. Vi startade
					grönt. SVEA Energy föddes ur SVEA Solar som
					började installera solceller 2014 och är nu
					marknadsledande i Sverige. Vi startade SVEA Energy
					av den enkla anledningen att man skall kunna samla
					all energi man behöver, på ett och samma ställe.</p>
			</div>
		</div>
	</div>
	<div class="column first">
		<div class="companies-box">
			<p class="companies-sec-title">Vilka pratar om oss: </p>
			<span class="companies-box-border"></span>
			
			<span 
				 class="companies-box-item" 
				 style="background-image:url('https://energy.sveasolar.se/wp-content/uploads/2019/03/forbes-logo-black-transparent.png');">
			</span>
			<span 
				 class="companies-box-item" 
				 style="background-image:url('https://energy.sveasolar.se/wp-content/uploads/2019/03/logo-nyteknik.jpg');">
			</span>
			<span 
				 class="companies-box-item" 
				 style="background-image:url('https://www.svtstatic.se/resources/svtservice-n-render/svt-nyheter-logo_3.svg');">
			</span>
			<span 
				 class="companies-box-item" 
				 style="background-image:url('https://energy.sveasolar.se/wp-content/uploads/2019/03/logo.jpg');">
				</span>
			<span 
				 class="companies-box-item" 
				 style="background-image:url('https://energy.sveasolar.se/wp-content/uploads/2019/03/photo_2019-03-19-09.30.49.jpeg');"></span>
			<span 
				 class="companies-box-item" 
				 style="background-image:url('https://energy.sveasolar.se/wp-content/uploads/2019/03/5989805d91230.jpg');">
			</span>
		</div>
	</div>
</div>
<div class="row container-content">
	<div class="column left">
		<div class="box video-container">
			<video  
				class		= "img-phone-calc" 
				autoplay
				loop
				muted
				playsinline="true"
                x-webkit-airplay="deny"
                preload="auto"
			>
				<source
					src = "https://energy.sveasolar.se/wp-content/uploads/2019/03/mobilevideo.mp4"
					type= "video/mp4"
				>
			</video>
		</div>
		<div class="app-icons">
			<a  href="https://itunes.apple.com/us/app/svea-energy/id1451701501?ls=1&amp;mt=8" target="_blank" data-options="thumbnail: 'https://sveasolar.se/wp-content/uploads/Download_on_the_App_Store_Badge_SE_RGB_blk_100317.svg'"><img src="https://sveasolar.se/wp-content/uploads/Download_on_the_App_Store_Badge_SE_RGB_blk_100317.svg"></a>
			<a href="https://play.google.com/store/apps/details?id=io.gonative.android.opqelj" target="_blank" data-options="thumbnail: 'https://sveasolar.se/wp-content/uploads/google-play-badgeBW.png'"><img src="https://sveasolar.se/wp-content/uploads/google-play-badgeBW.png"></a>
		</div>
	</div>
	<div class="column">
		<p class="companies-sec-title">Vanliga frågor: </p>
		<span class="companies-box-border"></span>
		<button class="transition">Behöver jag ha solceller för att bli kund hos er?</button>
		<div class="collapse">
			<p>Nej, det behöver du inte.</p>
		</div>
		<br>
		<button class="transition">Vad är källan till er energi?</button>
		<div class="collapse">
			<p>Allt kommer från Sol, Vind och Vatten.</p>
		</div>
		<br>

		<button class="transition">Hur länge binder jag upp mig?</button>
		<div class="collapse">
			<p>Det gör du inte.<br />
				Vi är övertygade att du blir nöjd och
				vill stanna kvar hos oss. Därför har vi
				ingen bindningstid.</p>
		</div>
		<div class="signup-box">
			<a href="/byt-elavtal/" class="button" title="BYT ELAVTAL"> BYT ELAVTAL </a>
			<p>
				2 minuter att registrera sig.<br/>
				Inga konstigheter, bara ren energi.
			</p>
		</div>
	</div>
</div>
<div style="clear: both"></div>

<script>
	var acc = document.getElementsByClassName("transition");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function () {
			this.classList.toggle("arrow");
			var collapse = this.nextElementSibling;
			if (collapse.style.maxHeight) {
				collapse.style.maxHeight = null;
			} else {
				collapse.style.maxHeight = collapse.scrollHeight + "px";
			}
		});
	}
</script>

<script>
	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function () {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.maxHeight) {
				panel.style.maxHeight = null;
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
			}
		});
	}
</script>


<?php
get_footer();