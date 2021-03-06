<?php

// =============================================================================
// TEMPLATE NAME: specialCalc20 - No Container | No Header, Footer
// -----------------------------------------------------------------------------
// =============================================================================

?>

<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
get_header();

?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
<style type="text/css">
	
	html, body{
		font-family: 'Open-sans', sans-serif !important;
	}
	
	#content{
		margin: 120px auto 20px;
    	max-width: 1170px;
	}

	#estBill, #pwp, .priceBillPopup2{
		border: 1px solid rgba(0,0,0,0);
	}

	#formRightContent #estBill h2, #formRightContent #pwp h2{
		border: 2px solid rgba(0,0,0,1); 
		width: calc(100% - 22px); 
		margin: 0 auto
	}
	
	#priceSolarPopup h1, #priceBillPopup h1 {border: 2px solid rgba(0,0,0,1);margin: 0 auto; padding: 10px}
	.seePricingDetails { display: block; margin: 0 auto; max-width: 170px}
	#formRightContent div.seePricingDetails h3 { text-align: center; line-height: 30px; font-size: 14px; text-transform: initial; opacity: 0.7}

	 #formRightContent #estBill h2, #formRightContent #pwp h2, #priceBillPopup h1, #priceSolarPopup h1  {
		font-size: 14px;
		color: #000;
		font-weight: bold;
		text-transform:uppercase;
	}
	#piegraph {
		display: block;
		margin-left: auto;
		margin-right: auto;
		padding-left: 0;
		padding-right: 0; 
		margin-bottom: 0px;
		width: 100%;
	}
	.priceBillPopup2 {min-height: 524px}
	#formRightContent #estBill p, #formRightContent #pwp p
	{
		padding: 10px 0 0;
		margin: 0;
		font-size: 16px;
		color: #000;
	}
	#formRightContent #estBill .kostar p, #formRightContent #pwp .kostar p {
		font-size: 20px;
		color: #000;
		font-weight: bold;
	}
	.price-table td {
		width: 50%;
		vertical-align: top;
		text-align: center;
	}
	.price-table td #formPrice, .price-table td #formPriceUnboundFix {margin-bottom: 0; }
	.price-table td #formPrice span, .price-table td #formPriceUnboundFix span {display: block; }
	.price-table td #formPrice h1, .price-table td h1#formPriceUnboundFix  {padding: 20px; font-size: 22px;line-height: 28px;}
	.price-table td #formPrice h1 {padding: 33px 30px;}
	#formPrice h1, .formprice-color h1, #pwpPriceWrapper h1, #submitInfo {
		background: rgb(115, 164, 33);
		color: #ffffff;
		font-size: 22px;
		display: block; border-radius: 8px;
		font-family: 'Open sans';
		cursor:pointer;
		transition: all .15s linear;
		-webkit-transition: all .15s linear;
	}
	#formPrice h1:hover, .formprice-color h1:hover, #pwpPriceWrapper h1:hover, #submitInfo:hover {
		background: rgb(90, 127, 26); 
		transition: all .15s linear; 
		-webkit-transition: all .15s linear;
	}

	#pwpPriceWrapper h1 {max-width: 50%; margin: 20px auto; font-family: 'Open sans';font-size: 22px; padding: 10px; font-weight: 600; min-height: 118px;
    line-height: 114px; text-transform: uppercase;}
	#formPrice span, #formPriceUnboundFix span  {
		font-size: 14px
	}
	#formPrice span:first-child {
		content: '';
		font-size: 20px;
		font-weight: bold;
		text-transform: none;
		text-transform: uppercase;
	}
	.price-table td #formPrice h1:nth-child(2) {display: inline; content: '';}
	.price-table td h1#formPriceUnboundFix {margin: 0; font-size: 22px; word-break: break-word; padding: 46px 30px;}
	.priceBillPopup2 table {margin-bottom: 0 }
	#ppkParts {border: none}
	#priceBillPopup .priceBillPopup2 h2, #priceSolarPopup .priceBillPopup2 h2, #priceBillPopup h2, #priceSolarPopup h2 {font-size: 0.8rem;}
	.priceBillPopuptable {display: flex; width: 100%}
	.priceBillPopup2 {display: inline-block;
		width: 45%;
		margin: 10px;
		padding: 10px; vertical-align: top}
	.priceBillPopuptable.test .priceBillPopup2 {display: inline-block;
		width: 100%;
	}
	.priceBillPopuptable.test.mystyle .priceBillPopup2 {display: inline-block;
		width: 45%; float: left;
	}
	.priceBillPopup2 #monBillFP, .priceBillPopup2 #monProdChoose, .priceBillPopup2 #monProdFP {font-size: 1.2rem !important;}

	.priceBillPopup2 #ppkParts td:first-child {padding-left: 0;}
	p.extra-value #productionKWHtest, p.extra-value #consumptionKWhextra {position: inherit; top: 0;     font-size: 18px;font-weight: 600;}
	span#pwpPriceText {font-size: inherit; font-weight: 600; margin:0px;}
	h2#monBillFP, h2#monProdChoose {
    font-size: 1.2rem !important;
}
	@media screen and (max-width: 1222px) {
		.priceBillPopup2 { width: 100%; margin-top: 30px;}
		.price-table td {width: 100%;display: block;}
		.priceBillPopuptable.test.mystyle .priceBillPopup2 {display: inline-block; width: 100%; float: none;}
		#pwpPriceWrapper h1 {
			max-width: 100%;
			margin-left: 10px;
			margin-right: 10px;
		}
		#estBill, #pwp {padding: 20px;}
	}
	
	@media screen and (max-width: 383px) {
		.price-table td h1#formPriceUnboundFix{
			font-size:15px;
		}
		.price-table td #formPrice span{
			font-size: 16px;
		}
	}
	
	#ges h2 {
		margin:0px;
		padding:11px;
	}
	
	#formHeader{
		padding:0px;
	}
	
	.slimText{
		font-weight:400;
	}

</style>
<?php // End of the loop.

			$markup		= 4.45;
	$elcert		= 3.45;
	$monthlyFee	= 39;
	$vat		= 0.25;

	$roomKwhScl	= 575;
	$occKwhScl	= 300;
	$fixedKwh	= 1025;
			
			if ( post_password_required() ) {
 
  /* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop.
 
} else {
?>

<div
	class	= "x-main full"
	role	= "main"
>
	<div id="content">
		<form
			method	= "POST"
			id		= "form"
			action	= "<?php echo $_SERVER['REQUEST_URI']?>"
		>

		<!-- Type of house. -->
			<input
				type	= "hidden"
				name	= "householdType"
				id		= "houseTypeInput"
				value	=	"house"
			/>

		<!-- Step counter. -->
			<input
				type= "hidden"
				name= "step"
				id	= "stepInput"
				<?php echo 'value="' . ($_POST['step'] === null ? "excessProduction" : $_POST['step']) . '"'; ?>
			/>

		<!-- Electricity consumed by customer. -->
			<input
				type= "hidden"
				name= "consumptionKWH"
				id	= "consumptionKWHInput"
				<?php echo 'value="' . ($_POST['consumptionKWH'] === null ? 1000 : $_POST['consumptionKWH']) . '"'; ?>
			/>
			
		<!-- Amount of electricity produced by customer. -->
			<input
				type= "hidden"
				name= "productionKWH"
				id	= "productionKWHInput"
				<?php echo 'value="' . ($_POST['productionKWH']  === null ? 3000 : $_POST['productionKWH']) . '"' ; ?>
			/>

		<!-- Money saved/returned on excess electricity production. -->
			<input
				type= "hidden"
				name= "productionTypeReturn"
				id	= "productionTypeReturnInput"
				<?php if(isset($_POST['productionTypeReturn'])){echo 'value="' . $_POST['productionTypeReturn'] . '"' ;} ?>
			/>

		<!-- Money saved/returned on excess electricity production. -->
		<input
			type= "hidden"
			name= "showSale"
			id	= "showSaleInput"
			<?php if(isset($_POST['showSale'])){echo 'value="' . $_POST['showSale'] . '"' ;} ?>
		/>

		<!-- Show me how much I could earn? -->
		<input 
			type="hidden"
			name="showMeHowMuch"
			id	="showMeHowMuchInput"
		/>

		<!-- Electricity cost multiplier. -->
		<input 
			type	= "hidden" 
			name	= "spotPrice" 
			id		= "spotPriceInput" 
			value	=
			<?php 
				if(!isset($_POST['spotPrice'])){
					$defaultSpotPrice		= 52;
					$dSpotPriceLowerBound	= 30;
					$dSpotPriceUpperBound	= 80;
				

					$datetime = new DateTime('tomorrow');
					$url	= 'https://gasell1.zavann.se/rest/v2/hourlyspotprice?from_date=' . date("Y-m-d") . '&to_date=' . $datetime->format('Y-m-d');
					$curl	= curl_init();
					
					curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
					curl_setopt($curl, CURLOPT_USERPWD, "svea_solar:shae2Che");
				
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				
					$result = curl_exec($curl);
				
					if (!curl_errno($curl)) {
						$areas		= json_decode($result, true);
						$priceSum	= 0;
	
						foreach($areas as $area) {
							$day = $area[date("Y-m-d")];
							foreach($day as $hour) {
								$priceSum += $hour['price'];
							}
						}

						$spotPrice = $priceSum / 96;
						
						if($spotPrice < $dSpotPriceLowerBound || $spotPrice > $dSpotPriceUpperBound) {
							$spotPrice		= $defaultSpotPrice;
							$usingDefault	= true;
						}
					}
					else {
						$spotPrice = $defaultSpotPrice;
						$usingDefault = true;
					}

					curl_close($curl);
				}

				else {
					$spotPrice = $_POST['spotPrice'];
				}

				echo $spotPrice; 
        	?>
		/>

			<input type="hidden" name="submitBtn" />
		</form>

		<p id="headerTextP">
			<div class="centerText">
				<div>
					<h1 id="stge">BYT TILL ETT HELT GRÖNT ELAVTAL</h1>
				</div>

				<div>
					<h2 id="snes">SVEA har blivit elhandlare. 100% ren och kostnadseffektiv Energi. Se din kostnad:</h2>
				</div>
			</div>
		</p>

		<div id="priceWrapper">
			<div id="priceTrack">
				<div id="priceFill">
					<div id="priceTextWrapper">
						<div id="priceText">0 KR PER MÅNAD</div>
					</div>
				</div>
			</div>
		</div>

		<div id="consumptionSection">
			<div class="section-title">Din uppskattade årliga förbrukning</div>
			<div id="consumptionDiv">
				<div id="consumptionWrapper">
					<div id="consumptionKWh">1000 kWh / år</div>

					<div class="edgeSliderWrapper">
						<div class="edgeSliderTrack estSmall"></div>

						<input
							type	= "range"
							min		= 100
							max		= 50000
							step	= 100
							value	= 1000
							class	= "narrowSlider consumption"
							id		= "consumptionSlider"
							oninput	= "updateConsumption(this.value)"
						/>
					</div>
				</div>
			</div>
		</div>

		<div id="confirmButtonWrapper">
			<div>
				<div
					id		= "confirmButton"
					onclick	= "mts()"
				>
					Nästa
				</div>
			</div>
		</div>

		<div id="prevButtonWrapper"></div>
	</div>
</div>

<div
	id		= "maskFormPopup"
	class	= "pageMask speciallies"
>
</div>

<div id="formPopup">
	<div
		class	= "closeBtn"
		onclick	= "togglePopup('formPopup', 'flex', 'maskFormPopup', true)"
	>X</div>
	<div id="formPopupContainer">
		<div id="formLeft">
			<div id="triangleDownContainer">
				<div id="triangleDownLeft"></div>
				<div id="triangleDownRight"></div>
			</div>

			<div id="formHeader">
				<h2>BYT TILL ETT HELT GRÖNT ELAVTAL</h2>
			</div>

			<form
				action	= "https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8"
				method	= "POST"
			>

				<!-- oid -->
				<input
					type	= "hidden"
					name	= "oid"
					value	= "00D58000000IHRE"
				/>

				<!-- retURL -->
				<input
					type	= "hidden"
					name	= "retURL"
					value	= "https://energy.sveasolar.se/tack/"
				/>

				<!-- Company -->
				<input
					type		= "hidden"
					name		= "company"
					id			= "company"
					maxlength	= "40"
					size		= "20"
					value		= "x"
				/>
				<!-- Energy Property Type -->
				<input
					type	= "hidden"
					name	= "00N4H00000E7WlE"
					id		= "00N4H00000E7WlE"
					value	= "Villa"
				/>

				<!-- Rooms -->
				<input
					type	= "hidden"
					name	= "00N4H00000E7Wbi"
					id		= "00N4H00000E7Wbi"
					size	= "20"
					value	= ""
				/>

				<!-- Spot Price For Calc -->
				<input
					type	= "hidden"
					name	= "00N4H00000E7Wrv"
					id		= "00N4H00000E7Wrv"
					size	= "20"
					value	= "<?php echo $spotPrice ?>"
				/>

				<!-- Markup For Calc -->
				<input
					type	= "hidden"
					name	= "00N4H00000E7Ws0"
					id		= "00N4H00000E7Ws0"
					size	= "20"
					value	= "<?php echo $markup ?>"
				/>

				<!-- Elcert for Calc -->
				<input
					type	= "hidden"
					name	= "00N4H00000E7Ws5"
					id		= "00N4H00000E7Ws5"
					size	= "20"
					value	= "<?php echo $elcert ?>"
				/>

				<!-- # of Inhabitants -->
				<input
					type	= "hidden"
					name	= "00N4H00000E7Wbn"
					id		= "00N4H00000E7Wbn"
					size	= "20"
					value	= ""
				/>

				<!-- # of kWh (form) -->
				<input
					type	= "hidden"
					name	= "00N4H00000E7Wbs"
					id		= "00N4H00000E7Wbs"
					size	= "20"
					value	= ""
				/>

				<!-- IP Address -->
				<input
					type		= "hidden"
					name		= "00N4H00000E7WKD"
					id			= "00N4H00000E7WKD"
					style		= "display: none"
					maxlength	= "150"
					size		= "20"
					value		= "<?php if(isset($_SERVER['REMOTE_ADDR'])){echo $_SERVER['REMOTE_ADDR'];}?>"
				/>

				<!-- Price Group (Consumption) -->
				<input
					type	= "hidden"
					name	= "00N4H00000E7WDl"
					id		= "00N4H00000E7WDl"
					value	= "Rörligt - Bundet (3 år)"
				/>

				<!-- Lead Soruce -->
				<input
					type	= "hidden"
					name	= "lead_source"
					id		= "lead_source"
					value	= "SVEA Energy"
					style	= "display: none"
				/>

				<!-- Price Group (Production) -->
				<input
					type	= "hidden"
					name	= "00N4H00000E7WDq"
					id		= "00N4H00000E7WDq"
					value	= "Rörligt - Bundet(20)"
					style	= "display: none"
				/>

				<div id="formLayout">
					<table id="formInputs">
						<tr>
							<td>
							<!-- First Name -->
								<input
									id			= "first_name"
									maxlength	= "40"
									name		= "first_name"
									size		= "20"
									type		= "text"
									class		= "inputFormInfo"
									placeholder	= "Förnamn"
									onchange	= "checkIfFilled()"
									required
								/>
							</td>
							
							<!-- Last Name -->
							<td>
								<input
									id			= "last_name"
									maxlength	= "80"
									name		= "last_name"
									size		= "20"
									type		= "text"
									class		= "inputFormInfo"
									onchange	= "checkIfFilled()"
									placeholder	= "Efternamn"
									required
								/>
							</td>
						</tr>
							
						<!-- Phone -->
						<tr>
							<td>
								<input
									id			= "phone"
									maxlength	= "40"
									name		= "phone"
									size		= "20"
									type		= "text"
									class		= "inputFormInfo"
									onchange	= "checkIfFilled()"
									placeholder	= "Telefon"
									required
								/>
							</td>
							
							<!-- Email -->
							<td>
								<input
									id			= "email"
									maxlength	= "80"
									name		= "email"
									size		= "20"
									type		= "text"
									class		= "inputFormInfo"
									onchange	= "checkIfFilled()"
									placeholder	= "Email"
									required
								/>
							</td>
						</tr>
						
						<!-- SSN -->
						<tr>
							<td>
								<input
									id			= "00N4H00000E7WkL"
									maxlength	= "13"
									name		= "00N4H00000E7WkL"
									size		= "20"
									type		= "text"
									class		= "inputFormInfo"
									placeholder	= "Personnummer"
									onchange	= "checkIfFilled()"
									required
								/>
							</td>
							
							<!-- Street -->
							<td>
								<input
									name		= "street"
									placeholder	= "Gata"
									class		= "inputFormInfo"
									onchange	= "checkIfFilled()"
									type		= "text"
									required
								>
							</td>
						</tr>

						<!-- Zip -->
						<tr>
							<td>
								<input
									id			= "zip"
									maxlength	= "20"
									name		= "zip"
									size		= "20"
									type		= "text"
									class		= "inputFormInfo"
									onchange	= "checkIfFilled()"
									placeholder	= "POSTNUMMER"
									required
								/>
							</td>

							<!-- City -->
							<td>
								<input
									id			= "city"
									maxlength	= "40"
									name		= "city"
									size		= "20"
									type		= "text"
									placeholder	= "Ort"
									class		= "inputFormInfo"
									onchange	= "checkIfFilled()"
									required
								/>
							</td>
						</tr>
					</table>
					<table id="formCheckboxes" >
						<tr id="submitRow">
								<td>
									<input
										type	= "submit"
										id		= "submitInfo"
										onchange= "checkIfFilled()"
										value	= "Skicka"
										disabled= "true"
									>
								</td>
						</tr>
					</table>
					<div id="acceptRow">
						<!-- Accept Terms -->
						<input
							type	= "checkbox"
							id		= "acceptButton"
							class	= "inputFormInfo"
							onchange= "checkIfFilled()"
							required
						/>

						<label for="acceptButton">Jag accepterar SVEA Energys <a href="https://energy.sveasolar.se/privacy-policy/" target="_blank">allmänna villkor</a> samt ger tillstånd att behandla min 
						personliga information enligt de lagar som råder. SVEA Energy har även tillstånd att hämta min förbrukningsdata från min nätägare.</label>
					</div>
					<div id="ges">
					<h2 style="font-size: 14px">Energikälla</h2>
				</div>

				<div>
					<div id= "secondPie">
						<img
							style	= "display: block"
							id		= "piegraph"
							src		= "https://energy.sveasolar.se/wp-content/uploads//2019/03/circlegraph2.png"
						/>
					</div>
				</div>
					<table 
						id="formCheckboxes"
						class="form-checkboxes-margin-fix"
					>
						<tr>

								<!-- Is Production Site -->
								<input
									class	= "invisible"
									type	= "hidden"
									name	= "00N4H00000E7WKN"
									id		= "00N4H00000E7WKN"
									value	= "1"
								/>

								<!-- SVEA Solar customer? -->
								<input
									class	= "invisible"
									type	= "hidden"
									name	= "00N4H00000E7Wkp"
									id		= "00N4H00000E7Wkp"
									value	= "1"
								/>

								<!-- Solar Quote Requested -->
								<input
									class	= "invisible"
									type	= "hidden"
									name	= "00N4H00000E2sbz"
									id		= "00N4H00000E2sbz"
									value	= "0"
								/>
							</td>
						</tr>
					</table>
					<div id="prevButtonWrapper" class="previous-step-mobile">
						<div
							id		= "prevButton"
							onclick	= "togglePopup('formPopup', 'flex', 'maskFormPopup', true)"
						>
							<h3>&#8592; Tillbaka till föregående steg</h3>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div id="formRight">
			<div id="formRightContent">
				<div>

					<div id="estBill">
						<h2>Förbrukningsavtal - rörligt</h2>
						<p>Din uppskattade månadsförbrukning: <span id="consumptionKWhextra">3245</span></p>
					

					<table class="price-table">
						<tr>
							<td><div id="formPrice" onclick="togglePopup('priceBillPopup', 'block', 'maskBillPopup')">
						<h1>900 kr</h1>	
						</div>
					</td>
					<td><div class="formprice-color" onclick="togglePopup('priceBillPopup', 'block', 'maskBillPopup')">
						<h1 id="formPriceUnboundFix" style="text-align: center" >BINDNINGSTID <span id="formPriceUnboundFix" style="text-align: center; font-size: 22px">3 år</span>
						</h1>
					</div></td>
						</tr>
					</table>
					<!--<div class="kostar">
						 <p>Det kostar dig: 2237 kr / månad</p> 
					</div>-->
					<div class="seePricingDetails" onclick="togglePopup('priceBillPopup', 'block', 'maskBillPopup')"><h3>Se prisdetaljer</h3></div>
					</div>

				

				<div>
					<div id="pwp">
						<h2>PRODUKTIONSAVTAL - RÖRLIGT, år 1</h2>
						<p>DIN UPPSKATTADE månadsproduktion: <span id="consumptionWrapper">
						<span id="productionKWHtest">9000 kWh / år</span></span></p>
					

					<div id="pwpPriceWrapper" onclick = "togglePopup('priceSolarPopup', 'block', 'maskpriceSolarPopup')">
						<h1 id="pwpPrice">Spotpris + 20 <span id="pwpPriceText">öre</span></h1>
					</div>
					
					<div
						class	= "seePricingDetails"
						onclick	= "togglePopup('priceSolarPopup', 'block', 'maskpriceSolarPopup')"
					>
						<h3>Se detaljer</h3>
					</div>
				</div>
				</div>
			</div>
		</div>

	</div>

	<div
		id		= "maskBillPopup"
		class	= "pageMask"
	></div>

	<div
		id		= "maskpriceSolarPopup"
		class	= "pageMask"
	></div>

	<div id="priceBillPopup" class="priceBillPopuptable test">
		<div class="priceBillPopup2">
		<div>
			<h1>Förbrukningsavtal - rörligt</h1>
			<table>
				<tr>
					<td>
						<h2 class="slimText">UPPSKATTAD MÅNADSFÖRBRUKNING :</h2>
					</td>

					<td>
						<h2 id="estMonConFP" class="slimText">N/A kWh</h2>
					</td>
				</tr>

				<tr>
					<td>
						<h2 class="pbpThick">PRIS PER KILOWATTIMME:</h2>
					</td>

					<td>
						<h2 id="ppKwhFP">N/A öre</h2>
					</td>
				</tr>
			</table>
		</div>
		<div id="ppkParts">
			<table>
				<tr>
					<td>
						<h2>Spotpris:</h2>
					</td>

					<td>
						<h2 class="slimText">
							<?php echo round($spotPrice, 2);?> öre</h2>
					</td>
				</tr>
					<tr>
					<td>
						<h2>Spotpåslag:</h2>
					</td>

					<td>
						<h2 class="slimText">
							<?php echo round($markup, 2);?> öre</h2>
					</td>
				</tr>
				<tr>
					<td>
						<h2>Elcertifikat:</h2>
					</td>

					<td>
						<h2 class="slimText">
							<?php echo round($elcert, 2);?> öre</h2>
					</td>
				</tr>

				<tr>
					<td>
						<h2>MOMS:</h2>
					</td>

					<td>
						<h2 id="vatFP" class="slimText">N/A öre</h2>
					</td>
				</tr>
			</table>
		</div>
		<div>
			<table>
				<tr>
					<td>
						<h2 class="pbpThick">MÅNADSAVGIFT:</h2>
					</td>

					<td>
						<h2 id="monFeeFP">N/A kr</h2>
					</td>
				</tr>

				<tr>
					<td colspan=2>
						<h2 id="monBillFP" class="pbpThick">N/A kr / månad</h2>
					</td>
				</tr>
				<tr>
					<td colspan=2><p style="font-size: 11px; text-align: center;color: rgb(115, 164, 33);"><sup>*</sup>Det rörliga elpriset/spotpriset ändras hela tiden och följer nordiska elbörsen (nordpool). Elcertifikatskostnaden varierar månadsvis.</p></td>
				</tr>
			</table>
		</div>
		<div
			class	= "closeBtn dont-close-on-mobile"
			onclick	= "togglePopup('priceBillPopup', 'block', 'maskBillPopup')"
		>X</div>
	</div>
</div>
	<div id="priceSolarPopup" class="priceBillPopuptable test">
		<div class="priceBillPopup2">
			<h1>Produktionsavtal - rörligt</h1>
			<div>
				<table>
					<tr>
						<td>
							<h2 class="slimText">UPPSKATTAD MÅNADSPRODUKTION :</h2>
						</td>

						<td>
							<h2 id="estMonCProdFP" class="slimText">N/A kWh</h2>
						</td>
					</tr>

					<tr>
						<td>
							<h2 class="pbpThick">PRIS PER KILOWATTIMME:</h2>
						</td>

						<td>
							<h2 id="ppKwhFPProd">N/A öre</h2>
						</td>
					</tr>
				</table>
			</div>
			<div id="ppkParts">
				<table>
					<tr>
						<td>
							<h2>Spotpris:</h2>
						</td>

						<td>
							<h2 class="slimText"><?php echo round($spotPrice, 2);?> öre</h2>
						</td>
					</tr>
					<tr>
						<td>
							<h2>Svea Energi Pris:</h2>
						</td>

						<td>
							<h2 class="slimText">
								20 öre <span style="color: rgb(0,0,0);">*</span>
							</h2>
						</td>
					</tr>
					</tr>

					<tr>
						<td>
							<h2>Skattereduktion:</h2>
						</td>

						<td>
							<h2 class="slimText">60 öre <span style="color: rgb(0,0,0);">**</span></h2>
						</td>
					</tr>
				</table>
			</div>
			<div>
				<table>
					<tr>
						<td colspan=2>
							<h2 id="monProdChoose" class="pbpThick">N/A kr / månad</h2>
							<p style="font-size: 12px; text-align: center;color: rgb(115, 164, 33); margin-bottom:0px;">*SVEA Energy pris, år 2-3: 5 öre</p>
							<p style="font-size: 12px; text-align: center;color: rgb(115, 164, 33); margin:0px;"><sup>*</sup> Skattereduktion betalas ut från skatteverket årsvis, för den el ni matar ut på nätet.</p>
						</td>
					</tr>

				</table>
			</div>
		</div>

		<div
			class	= "closeBtn dont-close-on-mobile"
			onclick	= "togglePopup('priceSolarPopup', 'block', 'maskpriceSolarPopup')"
		>X</div>
	</div>
</div>
<?php } ?>



<script type="text/javascript">
	var priceSliderWidth 		= 100,
		consumptionSliderWidth 	= 100;

	function updateRooms(x) {
		document.getElementById("noRooms").innerHTML	= x;

		calculatePrice();
	}

	function updateOccs(x) {
		document.getElementById("noOccs").innerHTML = x;
		calculatePrice();
	}

	function updateField(x, y) {
		document.getElementById(x).value = (y.checked) ? 1 : 0;
	}

	function clickSSI() {
		document.getElementById("showSaleSwitch").click();
		calculatePrice();

		// Disables the 2nd toggle if the main toggle is toggled off.
		if(document.getElementById("00N4H00000E2sbz").value === "1") {
			clickSendQuote();
		}

		// Enables the 2nd toggle if the main toggle is toggled on.
		if(document.getElementById("showMeHowMuchInput").value === "1") {
			if(document.getElementById("00N4H00000E2sbz").value === "0") {
				clickSendQuote();
			}
		}
	}

	function updateSendQuote(x) {
		document.getElementById("00N4H00000E2sbz").value = (x.checked) ? "1" : "0";
	}

	function clickSendQuote() {
		document.getElementById("toggleSendQuoteInput").click();
	}

	function roundProduction(x) {
		if(x > 5001 && x < 7000) {
			return 4000;
		} else if(x > 7001 && x < 11000) {
			return 6000;
		} else if(x > 11000) {
			return 8000;
		} else if(x < 5001) {
			if(document.getElementById("showSaleInput").value === "show") {
				alert("Det är osäkert om du har plats för solceller. Men prata gärna med en av våra solcellskonsulter");
			}
			return 0;
		}
	}

	function showSale() {
		if(document.getElementById("showSaleInput").value === "show") {
			document.getElementById("showSaleInput").value							= "hide";
			document.getElementById("showExcessProductionContainer").style.display	= "none"
			document.getElementById("toggleSendQuoteContainer").style.display		= "none";
			document.getElementById("secondPie").style.display						= "none";
			document.getElementById("firstPie").style.display						= "block";
		} else {
			document.getElementById("showSaleInput").value							= "show";
			document.getElementById("showExcessProductionContainer").style.display	= "block"
			document.getElementById("toggleSendQuoteContainer").style.display		= "block";
			document.getElementById("secondPie").style.display						= "block";
			document.getElementById("firstPie").style.display						= "none";
			document.getElementById("estBill").scrollIntoView({behavior: "smooth"});
			var element = document.getElementById("priceBillPopup");
  			element.classList.add("mystyle");
		}
	}

	function checkIfFilled() {
		let inputs	= document.querySelectorAll(".inputFormInfo");
		let button	= document.getElementById("submitInfo");
		let status	= false;

		for(let i = 0; i < inputs.length; ++i) {
			if(inputs[i].type === "checkbox") {
				status = !inputs[i].checked;
			} else {
				if(!inputs[i].value) {
					status = true;
				}
			}
		}

		button.disabled = status;
	}

	function updateSSI(x) {
		document.getElementById("showMeHowMuchInput").value	= (x.checked) ? "1" : "0";
/* 		document.getElementById("00N4H00000E7WDl").value	= (x.checked) ? "Rörligt - Bundet (3 år)" : "Rörligt - Obundet";
		document.getElementById("00N4H00000E7WDq").value	= (x.checked) ? "Rörligt - Bundet (3 år)" : "Rörligt - Obundet"; */

		extendPage();
		showSale();
	}

	function togglePopup(x, y, m, z) {
		let p									= document.getElementById(x);
		p.style.display							= (p.style.display == "none" || p.style.display == "") ? y : "none";
		document.getElementById(m).style.display= (p.style.display == "none" || p.style.display == "") ? "none" : "block";

		if (z && p.style.display == "none") {
			document.getElementById("content").style.opacity = 1;
		}
		if (x == "formPopup" && p.style.display == "none") {
			document.getElementById("content").style.marginBottom = "0";
		}

		if(document.getElementById("showSaleInput").value === "show" && x === "formPopup") {
			clickSSI();
		}
	}

	function updateCheckbox(x) {
		x.value = (x.value == "0") ? "1" : "0";
	}

	function extendPage() {
		let cntBR	= document.getElementById("content").getBoundingClientRect();
		let frmBR	= document.getElementById("formPopup").getBoundingClientRect();

		if (frmBR.bottom > cntBR.bottom) {
			document.getElementById("content").style.marginBottom = (frmBR.bottom - cntBR.bottom) * 1.2 + "px";
		}
	}

	function updatePrice(x) {
		let pBar = document.getElementById("priceTrack");
		<?php
			echo 'let pMax = 4000, pMin = 0;';

			echo '
				// Yearly consumption
				let consumption	= document.getElementById("consumptionKWHInput").value;

				// Yearly consumption
				let monthlyConsumption	= consumption / 12;

				// Yearly production
				let yearlyProduction = roundProduction(consumption);

				// Monthly production
				let monthlyProduction = Math.round((yearlyProduction / 12));

				// Price per hour for production 
				let pricePerProdHour = ('. $spotPrice . ' / 100) + 0.9;

				// Consumption price per kWh
				let pricePerKwh	= ' . ($spotPrice + $markup + $elcert) * (1 + $vat) . ';

				// Consumption price
				let conPrice = Math.round((monthlyConsumption * pricePerKwh) / 100 + ' . $monthlyFee . ');

				// Total price reduced by production
				let prodPrice = Math.round(monthlyProduction * pricePerProdHour);

				let adjustedPrice = Math.round(conPrice - (((monthlyProduction * pricePerKwh / 100) * 0.65)) - (monthlyProduction * 0.35 * pricePerProdHour));';			
				
		?>

		document.getElementById("monBillFP").innerHTML		= Math.round(((monthlyConsumption - (monthlyProduction * 0.65)) * (pricePerKwh / 100)) + 39) + " kr / månad";
		document.getElementById("priceFill").style.width	= conPrice / pMax * 100 + "%";
		document.getElementById("priceText").innerHTML		= conPrice + " KR PER MÅNAD";
		document.getElementById("ppKwhFPProd").innerHTML	= Math.round(pricePerProdHour * 100) + " öre";
		document.getElementById("estMonCProdFP").innerHTML	= Math.round(yearlyProduction / 12 * 0.35) + " kWh";
		document.getElementById("monProdChoose").innerHTML 	= Math.round(yearlyProduction * pricePerProdHour / 12 * 0.35) + " kr / månad";
		document.getElementById("estMonConFP").innerHTML	= Math.round(monthlyConsumption - (monthlyProduction * 0.65)) + " kWh";
		document.getElementById("formPrice").innerHTML		= "<h1><span>Din kostnad</span>" + adjustedPrice + " kr <span>PER MÅNAD</span></h1>";	
		document.getElementById("consumptionKWhextra").innerHTML = Math.round((monthlyConsumption) - 0.65 *  (yearlyProduction / 12))+ " KWh";
		document.getElementById("productionKWHtest").innerHTML	= Math.round((yearlyProduction / 12) * 0.35) + " KWh";
	
	}

	// Updates the consumption slider
	function updateConsumption(x) {
		let cSlider											= document.getElementById("consumptionSlider");
		document.getElementById("consumptionKWh").innerHTML	= x + " kWh / år";
		document.getElementById("consumptionKWHInput").value= x;
		document.getElementById("consumptionKWh").style.left= (x - cSlider.min) / (cSlider.max - cSlider.min) * (cSlider.offsetWidth - consumptionSliderWidth) + "px";
		calculatePrice();
	}

	// Updates the production slider
	function updateProductionHigh(x) {
		let cSlider											= document.getElementById("productionSliderHigh");
		document.getElementById("productionKWH").innerHTML	= x + " kWh / år";
		document.getElementById("productionKWHInput").value	= x;
		document.getElementById("productionKWH").style.left	= (x - cSlider.min) / (cSlider.max - cSlider.min) * (cSlider.offsetWidth - consumptionSliderWidth) + "px";
		calculatePrice();
	}

	// Updates the production slider
	function updateProductionLow(x) {
		let cSlider											= document.getElementById("productionSliderLow");
		document.getElementById("productionKWH").innerHTML	= x + " kWh / år";
		document.getElementById("productionKWHInput").value	= x;
		document.getElementById("productionKWH").style.left	= (x - cSlider.min) / (cSlider.max - cSlider.min) * (cSlider.offsetWidth - consumptionSliderWidth) + "px";
		calculatePrice();
	}

	function poaDisagree() {
		document.getElementById("poa").style.display		= "none";
		document.getElementById("formLayout").style.display	= "table";
		document.getElementById("formHeader").style.display	= "block";
	}

	function setProductionSlider(type) {
		let defProduction = roundProduction(document.getElementById("consumptionKWHInput").value);
		
		if(defProduction <= 3000) {
			defProduction = 3000;
		}

		if(type === "productionHigh") {
			updateProductionHigh(defProduction);
			document.getElementById("productionSliderHigh").value = defProduction;
		} else {
			updateProductionLow(defProduction);
			document.getElementById("productionSliderLow").value = defProduction;
		}
	}

	function toggleTr(x, y, z) {
		if (z) {
			document.getElementById(z).value = (x.checked) ? 1 : 0;
		}

		document.getElementById(y).style.display = (x.checked) ? "table-row" : "none";
	}

	<?php
		echo '
		function mts(){';

			echo 'document.getElementById("00N4H00000E7Wbs").value = document.getElementById("consumptionKWHInput").value;';
			echo 'document.getElementById("content").style.opacity	= "0.4";
			document.getElementById("formPopup").style.display		= (window.innerWidth > window.innerHeight) ? "flex" : "block";
			document.getElementById("maskFormPopup").style.display	= "block";
			extendPage();
			window.scrollTo({
				top: 0,
				left: 0,
				behavior: "smooth"
			});
		}';

	?>

	<?php
		echo 'var spPrice = ' . $spotPrice . ';';
		echo 'function calculatePrice() {';
		echo 'let spotPrice		= ' . $spotPrice . ';';
		echo 'let pricePerKwh	= ' . ($spotPrice + $markup + $elcert) * (1 + $vat) . ';';
		echo 'let vatJS			= ' . ($spotPrice + $markup + $elcert) * $vat . ';';
		echo 'let kwhConsumption		= document.getElementById("consumptionSlider").value;';
		echo 'let monthlyConsumption	= document.getElementById("consumptionSlider").value / 12;';
		echo 'let kwhProduction			= document.getElementById("productionKWHInput").value || 1;';
		echo 'let monthlyProduction		= document.getElementById("productionKWHInput").value / 12 || 1;';

		echo 'let price = Math.round((monthlyConsumption * pricePerKwh) / 100 + ' . $monthlyFee . ');';

		echo 'document.getElementById("ppKwhFP").innerHTML		= Math.round(pricePerKwh * 100) / 100 + " öre";';
		echo 'document.getElementById("vatFP").innerHTML		= Math.round(vatJS * 100) / 100 + " öre";';
		echo 'document.getElementById("monFeeFP").innerHTML		= ' . $monthlyFee . ' + " kr";';

		echo 'updatePrice(price);}';

	?>

	<?php
		echo 'function submitHT(x){
			document.getElementById("houseTypeInput").value	= x;
			document.getElementById("spotPriceInput").value = spPrice;

			if (x == "apartment") {
				document.getElementById("stepInput").value = "householdInfo";
			} else if (x == "house") {
				document.getElementById("stepInput").value = "consumption";
			} else {
				document.getElementById("stepInput").value = "householdType";
			}

			document.getElementById("form").submit();
		}

		function goToReturnProd(step) {
			if(step == "productionHigh") {
				document.getElementById("productionTypeReturnInput").value	= "high";
			} else if(step == "productionLow") {
				document.getElementById("productionTypeReturnInput").value	= "low";
			} else {
				document.getElementById("productionTypeReturnInput").value	= "";
			}
			
			document.getElementById("stepInput").value	= step;
			document.getElementById("form").submit();
		}

		function goBack(step) {
			if(document.getElementById("stepInput").value === "productionHigh" || document.getElementById("stepInput").value === "productionLow" || document.getElementById("stepInput").value === "excessProduction") {
				document.getElementById("productionTypeReturnInput").value	= "";
				document.getElementById("productionKWHInput").value			= "";
				document.getElementById("00N4H00000E7Wkp").value			= "0";
				document.getElementById("00N4H00000E7WKN").value			= "0";
				document.getElementById("00N4H00000E7WDq").value			= "Rörligt - Obundet"
			}

			document.getElementById("stepInput").value	= step;
			document.getElementById("form").submit();
		};

		function nextStep(step) {
			document.getElementById("stepInput").value	= step;
			document.getElementById("form").submit();
		}';
	?>


	calculatePrice();
</script>
		</main><!-- #main -->
	</section><!-- #primary -->



<?php get_footer('cal');