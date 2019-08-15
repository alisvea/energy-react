<?php

// =============================================================================
// TEMPLATE NAME: Energycalc - No Container | No Header, Footer
// -----------------------------------------------------------------------------
// =============================================================================

?>

<?php

	if ( apply_filters( 'x_legacy_cranium_headers', true ) ) {
		x_get_view( 'global', '_header' );
	} else {
		get_header();
	}

?>

<?php
	$markup		= 5.95;
	$elcert		= 6.75;
	$monthlyFee	= 39;
	$vat		= 0.25;

	$roomKwhScl	= 575;
	$occKwhScl	= 300;
	$fixedKwh	= 1025;
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
				type= "hidden"
				name= "householdType"
				id	= "houseTypeInput"
				<?php
					if (isset($_POST['householdType'])){
						echo 'value="' . $_POST['householdType'] . '"' ;
					}
				?>
			/>

		<!-- Step counter. -->
			<input
				type= "hidden"
				name= "step"
				id	= "stepInput"
				<?php if(isset($_POST['step'])){echo 'value="' . $_POST['step'] . '"' ;} ?>
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
					<h1 id="stge">BYT TILL GRÖN ENERGI</h1>
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

		<?php
			if(!isset($_POST['step']) || $_POST['step'] == 'householdType'):?>
			<div id="householdTypeSection">

				<div>
					<h2 class="h2-bold text-dark-grey">Välj ditt boende</h2>
				</div>

				<div id="householdTypeWrapper">
					<div
						id		= "apartmentDiv"
						class	= "householdTypeButton"
					>
						<div
							class	= "circle apartment iconImage"
							onclick	= "submitHT('apartment')"
						></div>

						<span id="apartmentTooltip">Lägenhet</span>
					</div>

					<div
						id		= "houseDiv"
						class	= "householdTypeButton"
					>
						<div
							class	= "circle house iconImage"
							onclick	= "submitHT('house')"
						></div>

						<span id="houseTooltip">Villa</span>
					</div>
				</div>
			</div>

		<?php elseif($_POST['step'] == 'householdInfo'):?>
			<div id="roomOccSection">
				<div id="flexHorizontal">
					<div class="fhItem">
						<div class="flexVertical">
							<div class="flextext">
								<div class="roomOccQuestion">
									<h2 id="roomText">Hur många rum har ni?</h2>
								</div>
							</div>

							<div class="flexinput">
								<div class="edgeSliderWrapper">
									<div class="edgeSliderTrack estSmall"></div>
									<input
										type	= "range"
										min		= 1
										max		= 15
										value	= 4
										class	= "narrowSlider room"
										id		= "roomSlider"
										oninput	= "updateRooms(this.value)"
										onchange= "updateRooms(this.value)"
									/>
								</div>
							</div>

							<div class="flextext">
								<div class="sliderText">
									<span id="noRooms">4</span>

									<span id="roomsText">Rum</span>
								</div>
							</div>
						</div>
					</div>

					<div class="fhItem">
						<div class="flexVertical">
							<div class="flextext">
								<div
									id		= "occQuestion"
									class	= "roomOccQuestion"
								>
									<h2>Hur många bor i hushållet?</h2>
								</div>
							</div>

							<div class="flexinput">
								<div class="edgeSliderWrapper">
									<div class="edgeSliderTrack estSmall"></div>

									<input
										type	= "range"
										min		= 1
										max		= 15
										value	= 7
										class	= "narrowSlider occupant"
										id		= "occSlider"
										oninput	= "updateOccs(this.value)"
										onchange= "updateOccs(this.value)"
									/>
								</div>
							</div>

							<div class="flextext">
								<div class="sliderText">
									<span id="noOccs">7</span>
									<span id="occText">Personer</span>
								</div>
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

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "goBack('householdType')"
					>
						<h3>&#8592; Tillbaka till föregående steg</h3>
					</div>
				</div>

				<?php elseif($_POST['step'] == 'consumption'): ?>

				<div id="consumptionSection">
					<div class="section-title">Din uppskattade årliga förbrukning</div>
					<div id="consumptionDiv">
						<div id="consumptionWrapper">
							<div id="consumptionKWh">1000 KWh / år</div>

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
							onclick	= "nextStep('excessProduction')"
						>
							Nästa
						</div>
					</div>
				</div>

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "goBack('householdType')"
					>
						<h3>&#8592; Tillbaka till föregående steg</h3>
					</div>
				</div>

				<?php elseif($_POST['step'] == 'excessProduction'): ?>
				<div id="excessProductionSection">
					<div id="excessProductionDiv">
						<div id="excessProductionWrapper">
							<div class="section-title">Äger ni ett solcellssystem och vill därmed ha ett produktionsavtal?</div>
						</div>
					</div>
				</div>

				<div id="confirmButtonWrapper">
					<div>
						<div
							class	= "yes-or-now-button"
							onclick	= "nextStep('excessSveaSolarProduction')"
						>
							JA
						</div>

						<div
							class	= "yes-or-now-button"
							onclick	= "mts()"
						>
							NEJ
						</div>
					</div>
				</div>

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "goBack('consumption')"
					>
						<h3>&#8592; Tillbaka till föregående steg</h3>
					</div>
				</div>

				<?php elseif($_POST['step'] == 'excessSveaSolarProduction'): ?>
				<div id="excessProductionSection">
					<div id="excessProductionDiv">
						<div id="excessProductionWrapper">
							<div class="section-title">Var det SVEA Solar som levererade er solcellsanläggning?</div>
						</div>
					</div>
				</div>

				<div id="confirmButtonWrapper">
					<div>
						<div
							class	= "yes-or-now-button"
							onclick	= "goToReturnProd('productionHigh')"
						>
							JA
						</div>

						<div
							class	= "yes-or-now-button"
							onclick	= "goToReturnProd('productionLow')"
						>
							NEJ
						</div>
					</div>
				</div>

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "nextStep('excessProduction')"
					>
						<h3>&#8592; Tillbaka till föregående steg</h3>
					</div>
				</div>

				<?php elseif($_POST['step'] == 'productionLow'): ?>

				<div id="consumptionSection">
					<p id="prodErrorLow"></p>
					<div class="section-title">Hur mycket producerar er solcellsanläggning totalt per år?</div>
					<div 
						id		= "consumptionDiv"
						class	= "withAutoButton"
					>
						<div id="consumptionWrapper">
							<div id="productionKWH">3000 KWh / år</div>

							<div class="edgeSliderWrapper">
								<div class="edgeSliderTrack estSmall"></div>

								<input
									type	= "range"
									min		= 3000
									max		= 13000
									step	= 100
									value	= 3000
									class	= "narrowSlider consumption"
									id		= "productionSliderLow"
									oninput	= "updateProductionLow(this.value)"
								/>
							</div>
						</div>

						<div
							class="consumptionSectionAutoButton"
						>
							<input
								type	= "button"
								onclick	= "setProductionSlider('productionLow')"
								id		= "productionHighButton"
							/>
							<label for="productionHighButton">Jag vet inte? (Vi använder vår uppskattning)</label>
						</div>
					</div>
				</div>

				<div id="confirmButtonWrapper">
					<div>
						<button
							id		= "disableButtonOnFail1"
							class	= "confirmButton"
							onclick	= "mts()"
						>
							Nästa
						</button>
					</div>
				</div>

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "goBack('excessSveaSolarProduction')"
					>
						<h3>&#8592; Tillbaka till föregående steg</h3>
					</div>
				</div>

				<?php elseif($_POST['step'] == 'productionHigh'): ?>

				<div id="consumptionSection">
					<p id="prodErrorHigh"></p>
					<div class="section-title">Hur mycket producerar er solcellsanläggning totalt per år?</div>
					<div 
						id		= "consumptionDiv"
						class	= "withAutoButton"
					>
						<div id="consumptionWrapper">
							<div id="productionKWH">3000 KWh / år</div>

							<div class="edgeSliderWrapper">
								<div class="edgeSliderTrack estSmall"></div>

								<input
									type	= "range"
									min		= 3000
									max		= 13000
									step	= 100
									value	= 3000
									class	= "narrowSlider consumption"
									id		= "productionSliderHigh"
									oninput	= "updateProductionHigh(this.value)"
								/>
							</div>
						</div>
						<div
							class="consumptionSectionAutoButton"
						>
							<input
								type	= "button"
								onclick	= "setProductionSlider('productionHigh')"
								id		= "productionHighButton"
							/>
							<label for="productionHighButton">Jag vet inte? (Vi använder vår uppskattning)</label>
						</div>
					</div>
				</div>

				<div id="confirmButtonWrapper">
					<div>
						<button
							id		= "disableButtonOnFail2"
							class	= "confirmButton"
							onclick	= "mts()"
						>
							Nästa
						</button>
					</div>
				</div>

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "goBack('excessSveaSolarProduction')"
					>
						<h3>&#8592; Tillbaka till föregående steg</h3>
					</div>
				</div>

			</div>
		</div>
	<?php endif; ?>
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
				<h2>BYT TILL GRÖN ENERGI</h2>
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
					value	= "http://sveasolar.se"
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
					value	= "
						<?php
							if(isset($_POST['householdType'])){
								if($_POST['householdType'] == 'apartment') {
									echo 'Apartment';
								} else if ($_POST['householdType'] == 'house') {
									echo 'Villa';
								}
							}
						?>"
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
					title	= "Rörligt - Bundet (3 år)"
					value	= "Rörligt - Bundet (3 år)"
				/>

				<input
					id		= "00N4H00000E7WKS"
					name	= "00N4H00000E7WKS"
					size	= "12"
					type	= "text"
					style	= "display: none"
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
					value	= "Rörligt - Until Special Offer"
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

						<label for="acceptButton">Jag accepterar SVEA Energys allmänna villkor samt ger tillstånd att behandla min 
						personliga information enligt de lagar som råder. SVEA Energy har även tillstånd att hämta min förbrukningsdata från min nätägare.</label>
					</div>
					<table 
						id="formCheckboxes"
						class="form-checkboxes-margin-fix"
					>
					<!-- Made by Adrian Andersson....... -->
						<tr
							<?php if (($_POST['step'] == 'householdInfo')) {
								echo 'class="very-hidden-object"';
							};?>
							<?php if (($_POST['step'] == 'productionHigh')) {
								echo 'class="very-hidden-object"';
							};?>
							<?php if (($_POST['step'] == 'productionLow')) {
								echo 'class="very-hidden-object"';
							};?>
							onclick	= "clickSSI()"
							id		= "ssiTr">
							<td>
								<label class="switch">
									<input
										type	= "checkbox"
										id		= "showSaleSwitch"
										value	= "0"
										onchange= "updateSSI(this)"
									/>
									<span class="slider round"></span>
								</label>

								<span id="SSI">Visa mig hur mycket jag kan spara på att installera solceller</span>

								<!-- Is Production Site -->
								<input
									class	= "invisible"
									type	= "hidden"
									name	= "00N4H00000E7WKN"
									id		= "00N4H00000E7WKN"
									value	= "0"
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
				<div class="form-right-divider">
					<div id="estBill">
						<h2>DET KOSTAR DIG</h2>
					</div>

					<div id="formPrice">
						<h1>900 kr</h1>
					</div>
					<div class="seePricingDetails" onclick="togglePopup('priceBillPopup', 'block', 'maskBillPopup')"><h3>Se prisdetaljer</h3></div>
				</div>

				<div class="form-right-divider">
					<div id="estBill">
						<h2>BINDNINGSTID</h2>
					</div>

					<div>
						<h1 id="formPriceUnboundFix" style="text-align: center">Ingen</h1>
					</div>
				</div>

				<div id="ges">
					<h2>Energikälla</h2>
				</div>

				<div>
				
					<?php if($_POST['step'] == 'excessProduction' || $_POST['step'] == 'householdInfo'): ?>
						<div 
							id		= "firstPie"
							style	= "display: block"
						>
							<img
								style	= "display: block"
								id		= "piegraph"
								src		= "/wp-content/uploads/circlegraph1.png"
							/>
						</div>
						<div 
							id		= "secondPie"
							style	= "display: none"
						>
							<img
								style	= "display: block"
								id		= "piegraph"
								src		= "/wp-content/uploads/circlegraph2.png"
							/>
						</div>
					<?php elseif($_POST['step'] == 'productionHigh' || $_POST['step'] == 'productionLow'): ?>
						<img
							id	= "piegraph"
							src	= "/wp-content/uploads/circlegraph2.png"
						/>
					<?php endif; ?>

				</div>

				<div 
					id		= "pwpWrapper1"
					style	= "display: none"
				>
					<div id="pwp">
						<h2>PRIS SVEA ENERGY BETALAR FÖR ÖVERSKOTTET</h2>
					</div>

					<div id="pwpPriceWrapper">
						<h1 id="pwpPrice"><?php echo "Spotpris + " . ($_POST['step'] == 'productionHigh' ? 5 : 3)?> </h1>

						<h1 id="pwpPriceText">öre</h1>
					</div>

					<div
						class	= "seePricingDetails"
						onclick	= "togglePopup('priceSolarPopup', 'block', 'maskpriceSolarPopup')"
					>
						<h3>Se detaljer</h3>
					</div>
				</div>

				<table>
					<tr
						onclick	= "clickSendQuote()"
						id		= "toggleSendQuoteContainer"
						style	= "display: none"
					>
						<td>
							<label class="switch">
								<input
									id="toggleSendQuoteInput"
									name="toggleSendQuote"
									type	= "checkbox"
									value	= "0"
									onchange= "updateSendQuote(this)"
								/>
								<span class="slider round"></span>
							</label>

							<span id="SSI">Skicka mig en kostnadsfri offert på solceller</span>
						</td>
					</tr>
				</table>
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

	<div id="priceBillPopup">
		<div>
			<h1>Förbrukningsavtal</h1>
			<table>
				<tr>
					<td>
						<h2 class="pbpThick">UPPSKATTAD MÅNADSFÖRBRUKNING :</h2>
					</td>

					<td>
						<h2 id="estMonConFP">N/A KWh</h2>
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
						<h2>RÖRLIGT ELPRIS:</h2>
					</td>

					<td>
						<h2>
							<?php echo round($spotPrice + $markup + $elcert, 2);?> öre</h2>
					</td>
				</tr>
				</tr>

				<tr>
					<td>
						<h2>MOMS:</h2>
					</td>

					<td>
						<h2 id="vatFP">N/A öre</h2>
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
			</table>
		</div>
		<?php if($_POST['step'] == 'excessProduction'): ?>
			<div 
				id		= "showExcessProductionContainer"
				style	= "display: none"
			>
				<div>
					<h1>Produktionsavtal</h1>
					<table>
						<tr>
							<td>
								<h2 class="pbpThick">UPPSKATTAD MÅNADSPRODUKTION :</h2>
							</td>

							<td>
								<h2 id="estMonCProdFP">N/A KWh</h2>
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
								<h2>
									<?php echo round($spotPrice);?> öre</h2>
							</td>
						</tr>
						<tr>
							<td>
								<h2>Svea Energi Pris:</h2>
							</td>

							<td>
								<h2>30 öre</h2>
							</td>
						</tr>
						</tr>

						<tr>
							<td>
								<h2>Skattereduktion <sup>*</sup>:</h2>
							</td>

							<td>
								<h2>60 öre</h2>
							</td>
						</tr>
					</table>
				</div>
				<div>
					<table>
						<tr>
							<td colspan=2>
								<h2 id="monProdFP" class="pbpThick">N/A kr / månad</h2>
							</td>
						</tr>
					</table>
				</div>
			</div>
		<?php endif; ?>
		<div
			class	= "closeBtn dont-close-on-mobile"
			onclick	= "togglePopup('priceBillPopup', 'block', 'maskBillPopup')"
		>X</div>
	</div>
	<div id="priceSolarPopup">
		<div>
			<h1>Produktionsavtal</h1>
			<div>
				<table>
					<tr>
						<td>
							<h2 class="pbpThick">UPPSKATTAD MÅNADSPRODUKTION :</h2>
						</td>

						<td>
							<h2 id="estMonCProdFP">N/A KWh</h2>
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
							<h2>
								<?php echo round($spotPrice);?> öre</h2>
						</td>
					</tr>
					<tr>
						<td>
							<h2>Svea Energi Pris:</h2>
						</td>

						<td>
							<?php 
								if($_POST['step'] == 'excessProduction'): ?>
									<h2>
										30 öre
									</h2>
								<?php elseif($_POST['step'] == 'productionLow'): ?>
									<h2>
										3 öre
									</h2>
								<?php elseif($_POST['step'] == 'productionHigh'): ?>
									<h2>
										5 öre
									</h2>
							<?php endif; ?>
						</td>
					</tr>
					</tr>

					<tr>
						<td>
							<h2>Skattereduktion <sup>*</sup>:</h2>
						</td>

						<td>
							<h2>60 öre</h2>
						</td>
					</tr>
				</table>
			</div>
			<div>
				<table>
					<tr>
						<td colspan=2>
							<h2 id="monProdChoose" class="pbpThick">N/A kr / månad</h2>
							<p style="font-size: 11px; text-align: center;color: rgb(115, 164, 33);"><sup>*</sup> Skattereduktion betalas ut från skatteverket årsvis, för den el ni matar ut på nätet.</p>
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
			echo 'let pMax = ';

			if(isset($_POST['step'])){
				if($_POST['step'] == "householdInfo"){
					echo '1200, pMin = 0;';
				} else if ($_POST['step'] == 'consumption' || $_POST['step'] == 'excessProduction' || $_POST['step'] == 'productionLow' || $_POST['step'] == 'excessSveaSolarProduction' || $_POST['step'] == 'productionHigh'){
					echo '4000, pMin = 0;';
				} else{
					echo '0, pMin = 0;';
				}
			} else {
				echo '0, pMin = 0;';
			}

			echo '
				// Yearly consumption
				let consumption	= document.getElementById("consumptionKWHInput").value;

				// Yearly production
				let yearlyProduction = roundProduction(consumption);

				// Monthly production
				let monthlyProduction = Math.round((yearlyProduction / 12));

				// Price per hour for production 
				let pricePerProdHour = ('. $spotPrice . ' / 100) + 0.9;

				// Consumption price per kWh
				let pricePerKwh	= ' . ($spotPrice + $markup + $elcert) * (1 + $vat) . ';

				// Consumption price
				let conPrice = Math.round((consumption / 12 * pricePerKwh) / 100 + ' . $monthlyFee . ');

				// Total price reduced by production
				let prodPrice = Math.round(monthlyProduction * pricePerProdHour);

				if (document.getElementById("stepInput").value === "productionLow" || document.getElementById("stepInput").value === "productionHigh") {
					conPrice = Math.round(x);
				}


				if(conPrice <= 0) {
					if(document.getElementById("stepInput").value === "productionLow") {
						document.getElementById("prodErrorLow").innerHTML 		= "Hoppsan! Här verkar er solproduktion ej matcha er förbrukning. Antingen har ni för låg förbrukning för denna kalkylatorn eller så har ni ej angett er totalförbrukning innan ni skaffade solceller i. Början. Vänligen gå tillbaka två steg och ange er totalförbrukning. Klicka \"Tillbaka till föregående steg\"";
					} else if(document.getElementById("stepInput").value === "productionHigh"){
						document.getElementById("prodErrorHigh").innerHTML		= "Hoppsan! Här verkar er solproduktion ej matcha er förbrukning. Antingen har ni för låg förbrukning för denna kalkylatorn eller så har ni ej angett er totalförbrukning innan ni skaffade solceller i. Början. Vänligen gå tillbaka två steg och ange er totalförbrukning. Klicka \"Tillbaka till föregående steg\"";
					}
				} else {
					if(document.getElementById("stepInput").value === "productionLow") {
						document.getElementById("prodErrorLow").innerHTML 		= "";
					} else if(document.getElementById("stepInput").value === "productionHigh"){
						document.getElementById("prodErrorHigh").innerHTML		= "";
					}
				}

				let adjustedPrice = Math.round(conPrice - (((monthlyProduction * pricePerKwh / 100) * 0.65)) - (monthlyProduction * 0.35 * pricePerProdHour));';			
		?>


		document.getElementById("monBillFP").innerHTML		= conPrice + " kr / månad";
		document.getElementById("priceFill").style.width	= conPrice / pMax * 100 + "%";
		document.getElementById("priceText").innerHTML		= conPrice + " KR PER MÅNAD";
		document.getElementById("ppKwhFPProd").innerHTML	= Math.round(pricePerProdHour * 100) + " öre";
		document.getElementById("estMonConFP").innerHTML	= Math.round(monthlyConsumption - (monthlyProduction * 0.65)) + " KWh";

		if(document.getElementById("stepInput").value === "excessProduction") {
			document.getElementById("monProdFP").innerHTML		= conPrice - adjustedPrice + " kr / månad"
		}

		if (document.getElementById("showSaleInput").value == 'show') {
			document.getElementById("formPrice").innerHTML		= "<div><h1><div class='price-sale-outer'><p>" + conPrice + " kr</p></div></h1><h1>" + adjustedPrice + " kr</h1><span>PER MÅNAD</span></div>";
		} else {
			document.getElementById("formPrice").innerHTML		= "<h1>" + x + " kr <span>PER MÅNAD</span></h1>";
		}

		if(document.getElementById("stepInput").value === "productionHigh" || document.getElementById("stepInput").value === "productionLow") {
			let omProdChoose 									= document.getElementById("productionKWHInput").value;
			document.getElementById("monProdChoose").innerHTML 	= Math.round(omProdChoose * pricePerProdHour / 12) + " kr / månad";
			document.getElementById("estMonCProdFP").innerHTML	= Math.round(omProdChoose / 12) + " KWh";
		}
	
	}

	// Updates the consumption slider
	function updateConsumption(x) {
		let cSlider											= document.getElementById("consumptionSlider");
		document.getElementById("consumptionKWh").innerHTML	= x + " KWh / år";
		document.getElementById("consumptionKWHInput").value= x;
		document.getElementById("consumptionKWh").style.left= (x - cSlider.min) / (cSlider.max - cSlider.min) * (cSlider.offsetWidth - consumptionSliderWidth) + "px";
		calculatePrice();
	}

	// Updates the production slider
	function updateProductionHigh(x) {
		let cSlider											= document.getElementById("productionSliderHigh");
		document.getElementById("productionKWH").innerHTML	= x + " KWh / år";
		document.getElementById("productionKWHInput").value	= x;
		document.getElementById("productionKWH").style.left	= (x - cSlider.min) / (cSlider.max - cSlider.min) * (cSlider.offsetWidth - consumptionSliderWidth) + "px";
		calculatePrice();
	}

	// Updates the production slider
	function updateProductionLow(x) {
		let cSlider											= document.getElementById("productionSliderLow");
		document.getElementById("productionKWH").innerHTML	= x + " KWh / år";
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
		if(isset($_POST['step'])){
			echo '
			function mts(){';
				if ($_POST['step'] == 'householdInfo'){
					echo 'document.getElementById("00N4H00000E7Wbi").value = document.getElementById("roomSlider").value;';
					echo 'document.getElementById("00N4H00000E7Wbn").value = document.getElementById("occSlider").value;';
					echo 'document.getElementById("00N4H00000E7Wbs").value = document.getElementById("consumptionKWHInput").value;';
					echo 'document.getElementById("roomSlider").value * ' . $roomKwhScl . ' + document.getElementById("occSlider").value * ' . $occKwhScl . ' + ' . $fixedKwh . ';';
				}
				else if ($_POST['step'] == 'productionHigh' || $_POST['step'] == 'productionLow'){
					echo 'document.getElementById("00N4H00000E7Wbs").value = document.getElementById("consumptionKWHInput").value;';
					echo 'document.getElementById("pwpWrapper1").style.display = "block";';
				} else if ($_POST['step'] == 'excessProduction'){
					echo 'document.getElementById("00N4H00000E7Wbs").value = document.getElementById("consumptionKWHInput").value;';
				}

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
		}
	?>

	<?php
		echo 'var spPrice = ' . $spotPrice . ';';
		echo 'function calculatePrice() {';
		echo 'let spotPrice		= ' . $spotPrice . ';';
		echo 'let pricePerKwh	= ' . ($spotPrice + $markup + $elcert) * (1 + $vat) . ';';
		echo 'let vatJS			= ' . ($spotPrice + $markup + $elcert) * $vat . ';';

		if ($_POST['step'] == 'householdInfo') {
			echo 'let rooms					= document.getElementById("roomSlider").value;';
			echo 'let occupants				= document.getElementById("occSlider").value;';
			echo 'let kwhConsumption		= rooms * ' . $roomKwhScl . ' + occupants * ' . $occKwhScl . ' + ' . $fixedKwh . ';';
			echo 'let monthlyConsumption	= (rooms * ' . $roomKwhScl . ' + occupants * ' . $occKwhScl . ' + ' . $fixedKwh . ') / 12;';
			echo 'document.getElementById("consumptionKWHInput").value = kwhConsumption;';
		} else if ($_POST['step'] == 'consumption') {
			echo 'let kwhConsumption		= document.getElementById("consumptionSlider").value;';
			echo 'let monthlyConsumption	= document.getElementById("consumptionSlider").value / 12;';
		} else if ($_POST['step'] == 'excessProduction' || 'excessSveaSolarProduction') {
			echo 'let kwhConsumption		= document.getElementById("consumptionKWHInput").value;';
			echo 'let monthlyConsumption	= document.getElementById("consumptionKWHInput").value / 12;';
			echo 'let kwhProduction			= document.getElementById("productionKWHInput").value || 1;';
			echo 'let monthlyProduction		= document.getElementById("productionKWHInput").value / 12 || 1;';
		} else if ($_POST['step'] == 'productionHigh' || 'productionLow') {
			echo 'let kwhConsumption		= document.getElementById("consumptionKWHInput").value;';
			echo 'let monthlyConsumption	= document.getElementById("consumptionKWHInput").value / 12;';
			echo 'let kwhProduction			= document.getElementById("productionKWHInput").value || 1;';
			echo 'let monthlyProduction		= document.getElementById("productionKWHInput").value / 12 || 1;';
		}

		echo 'let price = Math.round((monthlyConsumption * pricePerKwh) / 100 + ' . $monthlyFee . ');';

		if ($_POST['showSale'] == 'hide' || $_POST['showSale'] == '') {
			echo 'document.getElementById("estMonConFP").innerHTML	= Math.round(monthlyConsumption) + " KWh";';
		} else if ($_POST['showSale'] == 'show') {
			echo 'document.getElementById("estMonConFP").innerHTML	= Math.round(monthlyConsumption - (monthlyConsumption * 0.65)) + " KWh";';
		}

		echo 'document.getElementById("ppKwhFP").innerHTML		= Math.round(pricePerKwh * 100) / 100 + " öre";';
		echo 'document.getElementById("vatFP").innerHTML		= Math.round(vatJS * 100) / 100 + " öre";';
		echo 'document.getElementById("monFeeFP").innerHTML		= ' . $monthlyFee . ' + " kr";';

		if ($_POST['productionTypeReturn'] == 'high') {
			echo 'price = Math.round(price - (monthlyProduction * (0.65 * (' . $spotPrice . ' + 5.95 + 6.75)/100 + (0.35 * (' . $spotPrice . ' + 5 + 60)/100))));';
		} else if ($_POST['productionTypeReturn'] == 'low') {
			echo 'price = Math.round(price - (monthlyProduction * (0.65 * (' . $spotPrice . ' + 5.95 + 6.75)/100 + (0.35 * (' . $spotPrice . ' + 3 + 60)/100))));';
		}

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
			document.getElementById("stepInput").value	= step;
			document.getElementById("form").submit();
		};

		function nextStep(step) {
			document.getElementById("stepInput").value	= step;
			document.getElementById("form").submit();
		}';
	?>

	<?php
		if(isset($_POST['step'])){
			echo 'calculatePrice();';
		}
	?>
</script>

<?php get_footer(); ?>