<?php

// =============================================================================
// TEMPLATE NAME: Energyhome - No Container | No Header, Footer
// -----------------------------------------------------------------------------
// =============================================================================

?>

<?php
		get_header();

?>

<?php
	$markup		= 5.95;
	$elcert		= 4.80;
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

<div class="banner-energy">
	<h1>DITT GRÖNA ELAVTAL</h1></div>

	<div class="energy-section2 x-container max width termsandconditions">
		<div class="left">
			<h3>SVEA ENERGY</h3>
<p>SVEA Energy gör det enkelt att byta till ett grönt elavtal. Grön el är både ett lönsamt alternativ samtidigt som du ger tillbaka till miljön. Genom ett byte till SVEA Energy kan du få en bättre kontroll över din elkonsumtion och dina elpriser.

SVEA Energy och SVEA solceller är helt oberoende av varandra, vilket innebär att du kan ha SVEA Energy utan solceller eller vice versa.</p>
	</div>
		<div class="right">
			<ul>
				<li>Spara dina pengar</li>
<li>100% förnybar el</li>
<li>Kontroll över din elförbrukning</li>
			</ul>
			<a class="btn" href="https://sveasolar.se/energytest/" data-options="thumbnail: ''">BYT ELAVTAL</a>
		</div>

	</div>

<div class="energy-section3">
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
					<h1 id="stge">SWITCH TO GREEN ELECTRICITY</h1>
				</div>

				<div>
					<h2 id="snes">SVEA is now an energy supplier. 100% clean and affordable. See the cost:</h2>
				</div>
			</div>
		</p>

		<div id="priceWrapper">
			<div id="priceTrack">
				<div id="priceFill">
					<div id="priceTextWrapper">
						<div id="priceText">0 KR PER MONTH</div>
					</div>
				</div>
			</div>
		</div>

		<?php
			if(!isset($_POST['step']) || $_POST['step'] == 'householdType'):?>
			<div id="householdTypeSection">

				<div>
					<h2 class="h2-bold text-dark-grey">Where do you live?</h2>
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

						<span id="apartmentTooltip">Apartment</span>
					</div>

					<div
						id		= "houseDiv"
						class	= "householdTypeButton"
					>
						<div
							class	= "circle house iconImage"
							onclick	= "submitHT('house')"
						></div>

						<span id="houseTooltip">House</span>
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
									<h2 id="roomText">How many rooms do you have?</h2>
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

									<span id="roomsText">ROOMS</span>
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
									<h2>How many occupants do you have?</h2>
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
									<span id="occText">OCCUPANTS</span>
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
							NEXT
						</div>
					</div>
				</div>

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "goBack('householdType')"
					>
						<h3>&#8592; Return to previous step</h3>
					</div>
				</div>

				<?php elseif($_POST['step'] == 'consumption'): ?>

				<div id="consumptionSection">
					<div class="section-title">Your estimated consumption?</div>
					<div id="consumptionDiv">
						<div id="consumptionWrapper">
							<div id="consumptionKWh">1000 KWh / year</div>

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
							NEXT
						</div>
					</div>
				</div>

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "goBack('householdType')"
					>
						<h3>&#8592; Return to previous step</h3>
					</div>
				</div>

				<?php elseif($_POST['step'] == 'excessProduction'): ?>
				<div id="excessProductionSection">
					<div id="excessProductionDiv">
						<div id="excessProductionWrapper">
							<div class="section-title">Own a solar system and want us to buy your excess production?</div>
						</div>
					</div>
				</div>

				<div id="confirmButtonWrapper">
					<div>
						<div
							class	= "yes-or-now-button"
							onclick	= "nextStep('excessSveaSolarProduction')"
						>
							YES
						</div>

						<div
							class	= "yes-or-now-button"
							onclick	= "mts()"
						>
							NO
						</div>
					</div>
				</div>

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "goBack('consumption')"
					>
						<h3>&#8592; Return to previous step</h3>
					</div>
				</div>

				<?php elseif($_POST['step'] == 'excessSveaSolarProduction'): ?>
				<div id="excessProductionSection">
					<div id="excessProductionDiv">
						<div id="excessProductionWrapper">
							<div class="section-title">Was your solar system installed by SVEA Solar?</div>
						</div>
					</div>
				</div>

				<div id="confirmButtonWrapper">
					<div>
						<div
							class	= "yes-or-now-button"
							onclick	= "goToReturnProd('productionHigh')"
						>
							YES
						</div>

						<div
							class	= "yes-or-now-button"
							onclick	= "goToReturnProd('productionLow')"
						>
							NO
						</div>
					</div>
				</div>

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "nextStep('excessProduction')"
					>
						<h3>&#8592; Return to previous step</h3>
					</div>
				</div>

				<?php elseif($_POST['step'] == 'productionLow'): ?>

				<div id="consumptionSection">
					<p id="prodErrorLow"></p>
					<div class="section-title">How much of your consumption comes from your solar system?</div>
					<div id="consumptionDiv">
						<div id="consumptionWrapper">
							<div id="productionKWH">3000 KWh / year</div>

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
									oninput	= "updateProductionLow(this.value)">
							</div>
						</div>
					</div>
				</div>

				<div id="confirmButtonWrapper">
					<div>
						<button
							id		= "disableButtonOnFail1"
							class	= "confirmButton"
							onclick	= "mts()"
							disabled= "false"
						>
							NEXT
						</button>
					</div>
				</div>

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "goBack('excessSveaSolarProduction')"
					>
						<h3>&#8592; Return to previous step</h3>
					</div>
				</div>

				<?php elseif($_POST['step'] == 'productionHigh'): ?>

				<div id="consumptionSection">
					<p id="prodErrorHigh"></p>
					<div class="section-title">How much of your consumption comes from your solar system?</div>
					<div id="consumptionDiv">
						<div id="consumptionWrapper">
							<div id="productionKWH">3000 KWh / year</div>

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
									oninput	= "updateProductionHigh(this.value)">
							</div>
						</div>
					</div>
				</div>

				<div id="confirmButtonWrapper">
					<div>
						<button
							id		= "disableButtonOnFail2"
							class	= "confirmButton"
							onclick	= "mts()"
							disabled= "false"
						>
							NEXT
						</button>
                        <a href="#">eh</a>
					</div>
				</div>

				<div id="prevButtonWrapper">
					<div
						id		= "prevButton"
						onclick	= "goBack('excessSveaSolarProduction')"
					>
						<h3>&#8592; Return to previous step</h3>
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
				<h2>MAKE THE SWITCH TO GREEN ELECTRICITY</h2>
			</div>

			<form
				action	= "https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8"
				method	= "POST"
			>
				<input
					type	= "hidden"
					name	= "oid"
					value	= "00D58000000IHRE"
				/>
				<input
					type	= "hidden"
					name	= "retURL"
					value	= "http://sveasolar.se"
				/>
				<input
					type		= "hidden"
					name		= "company"
					id			= "company"
					maxlength	= "40"
					size		= "20"
					value		= "x"
				/>
				<input
					type	= "hidden"
					name	= "00N4H00000E7WlE"
					id		= "00N4H00000E7WlE"
					value	= "
						<?php
							if(isset($_POST['step'])){
								if($_POST['step'] == 'householdInfo') {
									echo 'Apartment';
								} else if ($_POST['step'] == 'consumption') {
									echo 'Villa';
								}
							}
						?>"
				/>
				<input
					type	= "hidden"
					name	= "00N4H00000E7Wbi"
					id		= "00N4H00000E7Wbi"
					size	= "20"
					value	= ""
				/>
				<input
					type	= "hidden"
					name	= "00N4H00000E7Wrv"
					id		= "00N4H00000E7Wrv"
					size	= "20"
					value	= "<?php echo $spotPrice ?>"
				/>
				<input
					type	= "hidden"
					name	= "00N4H00000E7Ws0"
					id		= "00N4H00000E7Ws0"
					size	= "20"
					value	= "<?php echo $markup ?>"
				/>
				<input
					type	= "hidden"
					name	= "00N4H00000E7Ws5"
					id		= "00N4H00000E7Ws5"
					size	= "20"
					value	= "<?php echo $elcert ?>"
				/>
				<input
					type	= "hidden"
					name	= "00N4H00000E7Wbn"
					id		= "00N4H00000E7Wbn"
					size	= "20"
					value	= ""
				/>
				<input
					type	= "hidden"
					name	= "00N4H00000E7Wbs"
					id		= "00N4H00000E7Wbs"
					size	= "20"
					value	= ""
				/>
				<input
					type		= "hidden"
					name		= "00N4H00000E7WKD"
					id			= "00N4H00000E7WKD"
					maxlength	= "150"
					size		= "20"
					value		= "<?php if(isset($_SERVER['REMOTE_ADDR'])){echo $_SERVER['REMOTE_ADDR'];}?>"
				/>
				<input
					type	= "hidden"
					name	= "00N4H00000E7WDl"
					id		= "00N4H00000E7WDl"
					title	= "Price Group (Consumption)" value="Rörligt - Obundet"
				/>
				<input
					type	= "hidden"
					name	= "lead_source"
					id		= "lead_source"
					value	= "SVEA Energy"
				/>

				<input
					type	= "hidden"
					name	= "00N4H00000E7WDq"
					id		= "00N4H00000E7WDq"
					value	= "Rörligt - Obundet"
				/>

				<div id="formLayout">
					<table id="formInputs">
						<tr>
							<td>
								<input
									id			= "first_name"
									maxlength	= "40"
									name		= "first_name"
									size		= "20"
									type		= "text"
									class		= "inputFormInfo"
									placeholder	= "First name"
									onchange	= "checkIfFilled()"
									required
								/>
							</td>

							<td>
								<input
									id			= "last_name"
									maxlength	= "80"
									name		= "last_name"
									size		= "20"
									type		= "text"
									class		= "inputFormInfo"
									onchange	= "checkIfFilled()"
									placeholder	= "Last name"
									required
								/>
							</td>
						</tr>

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
									placeholder	= "Phone"
									required
								/>
							</td>

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

						<tr>
							<td>
								<input
									id			= "00N4H00000E7WkL"
									maxlength	= "13"
									name		= "00N4H00000E7WkL"
									size		= "20"
									type		= "text"
									class		= "inputFormInfo"
									placeholder	= "Social Security No"
									onchange	= "checkIfFilled()"
									required
								/>
							</td>

							<td>
								<input
									name		= "street"
									placeholder	= "Street"
									class		= "inputFormInfo"
									onchange	= "checkIfFilled()"
									type		= "text"
									required
								>
							</td>
						</tr>

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
									placeholder	= "Zip"
									required
								/>
							</td>

							<td>
								<input
									id			= "city"
									maxlength	= "40"
									name		= "city"
									size		= "20"
									type		= "text"
									placeholder	= "City"
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
										value	= "SUBMIT"
										disabled= "true"
									>
								</td>
						</tr>
					</table>
					<div id="acceptRow">
						<input
							type	= "checkbox"
							id		= "acceptButton"
							class	= "inputFormInfo"
							onchange= "checkIfFilled()"
							required
						/>

						<label for="acceptButton">I accept SVEA Energy's contract terms and consent to the processing of my
							personal data that SVEA Energy can get my plant data from the network company</label>
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

								<span id="SSI">SHOW ME HOW MUCH I COULD EARN IF I GOT A SVEA SOLAR SYSTEM</span>

								<input
									class	= "invisible"
									type	= "hidden"
									name	= "00N4H00000E7WKN"
									id		= "00N4H00000E7WKN"
									value	= "0"
								/>

								<input
									class	= "invisible"
									type	= "hidden"
									name	= "00N4H00000E7Wkp"
									id		= "00N4H00000E7Wkp"
									value	= "0"
								/>

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
							<h3>&#8592; Return to previous step</h3>
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
					<div class="seePricingDetails" onclick="togglePopup('priceBillPopup', 'block', 'maskBillPopup')"><h3>See pricing details</h3></div>
				</div>

				<div class="form-right-divider">
					<div id="estBill">
						<h2>BINDNINGSTID</h2>
					</div>

					<div>
						<h1 id="formPriceUnboundFix" style="text-align: center">Unbound</h1>
					</div>
				</div>

				<div id="ges">
					<h2>ENERGY SOURCE</h2>
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
								src		= "/wp-content/uploads/2019/03/circlegraph1.png"
							/>
						</div>
						<div 
							id		= "secondPie"
							style	= "display: none"
						>
							<img
								style	= "display: block"
								id		= "piegraph"
								src		= "/wp-content/uploads/2019/03/circlegraph2.png"
							/>
						</div>
					<?php elseif($_POST['step'] == 'productionHigh' || $_POST['step'] == 'productionLow'): ?>
						<img
							id	= "piegraph"
							src	= "/wp-content/uploads/2019/03/circlegraph2.png"
						/>
					<?php endif; ?>

				</div>

				<div 
					id		= "pwpWrapper1"
					style	= "display: none"
				>
					<div id="pwp">
						<h2>PRICE WE PAY YOU FOR EXCESS SOLAR</h2>
					</div>

					<div id="pwpPriceWrapper">
						<h1 id="pwpPrice"><?php echo "Spot price + " . ($_POST['step'] == 'productionHigh' ? 5 : 3)?> </h1>

						<h1 id="pwpPriceText">öre</h1>
					</div>

					<div
						class	= "seePricingDetails"
						onclick	= "togglePopup('priceSolarPopup', 'block', 'maskpriceSolarPopup')"
					>
						<h3>See details</h3>
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

							<span id="SSI">SEND ME A QUOTE FOR A SVEA SOLAR SYSTEM.</span>
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
			<table>
				<tr>
					<td>
						<h2 class="pbpThick">ESTIMATED MONTHLY CONSUMPTION:</h2>
					</td>

					<td>
						<h2 id="estMonConFP">N/A KWh</h2>
					</td>
				</tr>

				<tr>
					<td>
						<h2 class="pbpThick">PRICE PER KILOWATT HOUR:</h2>
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
						<h2>VARIABLE ELECTRICITY COST:</h2>
					</td>

					<td>
						<h2>
							<?php echo round($spotPrice + $markup + $elcert, 2);?> öre</h2>
					</td>
				</tr>
				</tr>

				<tr>
					<td>
						<h2>VAT:</h2>
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
						<h2 class="pbpThick">MONTHLY FEE:</h2>
					</td>

					<td>
						<h2 id="monFeeFP">N/A kr</h2>
					</td>
				</tr>

				<tr>
					<td colspan=2>
						<h2 id="monBillFP" class="pbpThick">N/A kr / month</h2>
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
					<table>
						<tr>
							<td>
								<h2 class="pbpThick">ESTIMATED MONTHLY PRODUCTION:</h2>
							</td>

							<td>
								<h2 id="estMonCProdFP">N/A KWh</h2>
							</td>
						</tr>

						<tr>
							<td>
								<h2 class="pbpThick">PRICE PER KILOWATT HOUR:</h2>
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
								<h2>Spot price:</h2>
							</td>

							<td>
								<h2>
									<?php echo round($spotPrice);?> öre</h2>
							</td>
						</tr>
						<tr>
							<td>
								<h2>Svea Energy Price:</h2>
							</td>

							<td>
								<h2>30 öre</h2>
							</td>
						</tr>
						</tr>

						<tr>
							<td>
								<h2>Tax Reduction:</h2>
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
								<h2 id="monProdFP" class="pbpThick">N/A kr / month</h2>
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
			<h2>PRICE WE PAY FOR YOUR EXCESS SOLAR PRODUCTION</h2>
			<div>
				<table>
					<tr>
						<td>
							<h2 class="pbpThick">ESTIMATED MONTHLY PRODUCTION:</h2>
						</td>

						<td>
							<h2 id="estMonCProdFP">N/A KWh</h2>
						</td>
					</tr>

					<tr>
						<td>
							<h2 class="pbpThick">PRICE PER KILOWATT HOUR:</h2>
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
							<h2>Spot price:</h2>
						</td>

						<td>
							<h2>
								<?php echo round($spotPrice);?> öre</h2>
						</td>
					</tr>
					<tr>
						<td>
							<h2>Svea Energy Price:</h2>
						</td>

						<td>
							<h2>30 öre</h2>
						</td>
					</tr>
					</tr>

					<tr>
						<td>
							<h2>Tax Reduction:</h2>
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
							<h2 id="monProdChoose" class="pbpThick">N/A kr / month</h2>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div id="pspTerms">
			<h3>This price is for the first year, the price for year 2 and 3 is 0.05 kr per kWh. This contract will only start
				once you have your SVEA Solar system installed.</h3>
		</div>

		<div
			class	= "closeBtn dont-close-on-mobile"
			onclick	= "togglePopup('priceSolarPopup', 'block', 'maskpriceSolarPopup')"
		>X</div>
	</div>
</div>
</div>

<div class="varfor x-container max width termsandconditions">
	<div class="left">Varför SVEA Energy?
SVEA Energy hjälper dig optimera din elförbrukning. Med smartare lösningar, grön el och full kontroll kan du som kund få en billigare elfaktura.

Samla alla fakturor och hela din elförbrukning på ett och samma ställe. Med SVEA Energy som din leverantör får du en helhetslösning som inte finns någonstans på marknaden.

Detta får du med SVEA Energy:

Smarta molntjänster
SVEA Energy appen för maximal transparens
Ett prisvärt och grönt elavtal
Möjlighet att påverka din konsumtion
Ett enkelt elavtal</div>
	<div class="right">
		<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/320209973?title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
	</div>
</div>


<script type="text/javascript">
	var priceSliderWidth 		= 100,
		consumptionSliderWidth 	= 100;

	function updateRooms(x) {
		document.getElementById("noRooms").innerHTML = x;
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
		if(document.getElementById("00N4H00000E7Wkp").value === "1") {
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

	function setProductionIntervall(x) {
		document.getElementById("productionKWHInput").value = roundProduction(x);
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
			console.log("endstatus: " + status)
		}

		button.disabled = status;
	}

	function updateSSI(x) {
		document.getElementById("00N4H00000E7WKN").value	= (x.checked) ? "1" : "0";
		document.getElementById("00N4H00000E7Wkp").value	= (x.checked) ? "1" : "0";
		document.getElementById("00N4H00000E7WDl").value	= (x.checked) ? "Rörligt - Bundet (3 år)" : "Rörligt - Obundet";
		document.getElementById("00N4H00000E7WDq").value	= (x.checked) ? "Rörligt - Bundet (3 år)" : "Rörligt - Obundet";

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

		// 
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
				let monthlyProduction = Math.round((yearlyProduction / 12 * 0.35));

				// Price per hour for production 
				let pricePerProdHour = ('. $spotPrice . ' / 100) + 0.9;

				// Total price reduced by production
				let prodPrice = Math.round(monthlyProduction * pricePerProdHour);

				// Sets price to x
				let conPrice = Math.round(x);

				if(document.getElementById("showSaleInput").value == "show") {
					conPrice = Math.round(consumption / 12 - yearlyProduction / 12 * 0.65)
				}

				if(conPrice <= 0) {
					if(document.getElementById("stepInput").value === "productionLow") {
						document.getElementById("disableButtonOnFail1").disabled= true;
						document.getElementById("prodErrorLow").innerHTML 		= "Hoppsan! Här verkar er solproduktion ej matcha er förbrukning. Antingen har ni för låg förbrukning för denna kalkylatorn eller så har ni ej angett er totalförbrukning innan ni skaffade solceller i. Början. Vänligen gå tillbaka två steg och ange er totalförbrukning. Klicka \"Tillbaka till föregående steg\"";
					} else if(document.getElementById("stepInput").value === "productionHigh"){
						document.getElementById("disableButtonOnFail2").disabled= true;
						document.getElementById("prodErrorHigh").innerHTML		= "Hoppsan! Här verkar er solproduktion ej matcha er förbrukning. Antingen har ni för låg förbrukning för denna kalkylatorn eller så har ni ej angett er totalförbrukning innan ni skaffade solceller i. Början. Vänligen gå tillbaka två steg och ange er totalförbrukning. Klicka \"Tillbaka till föregående steg\"";
					}
				} else {
					if(document.getElementById("stepInput").value === "productionLow") {
						document.getElementById("disableButtonOnFail1").disabled= false;
						document.getElementById("prodErrorLow").innerHTML 		= "";
					} else if(document.getElementById("stepInput").value === "productionHigh"){
						document.getElementById("disableButtonOnFail2").disabled= false;
						document.getElementById("prodErrorHigh").innerHTML		= "";
					}
				}

				let adjustedPrice = Math.round(conPrice - (monthlyProduction * pricePerProdHour))';
				
		?>

		document.getElementById("monBillFP").innerHTML		= conPrice + " kr / month";
		document.getElementById("priceFill").style.width	= conPrice / pMax * 100 + "%";
		document.getElementById("priceText").innerHTML		= conPrice + " KR PER MONTH";
		document.getElementById("ppKwhFPProd").innerHTML	= pricePerProdHour  * 100 + " öre";
		document.getElementById("estMonCProdFP").innerHTML	= Math.round(monthlyProduction) + " KWh";

		if(document.getElementById("stepInput").value === "excessProduction") {
			document.getElementById("monProdFP").innerHTML		= Math.round(monthlyProduction * pricePerProdHour) + " kr / month"
		}

		if (document.getElementById("showSaleInput").value == 'show') {
			document.getElementById("formPrice").innerHTML		= "<div><h1><div class='price-sale-outer'><p>" + conPrice + " kr</p></div></h1><h1>" + adjustedPrice + " kr</h1><span>PER MONTH</span></div>";
		} else {
			document.getElementById("formPrice").innerHTML		= "<h1>" + x + " kr <span>PER MONTH</span></h1>";
		}

		if(document.getElementById("stepInput").value === "productionHigh" || document.getElementById("stepInput").value === "productionLow") {
			let omProdChoose 									= document.getElementById("productionKWHInput").value;
			document.getElementById("monProdChoose").innerHTML 	= Math.round(omProdChoose * pricePerProdHour / 12) + " kr / month";
			document.getElementById("estMonCProdFP").innerHTML	= Math.round(omProdChoose / 12) + " KWh";
		}
	
	}

	// Updates the consumption slider
	function updateConsumption(x) {
		let cSlider											= document.getElementById("consumptionSlider");
		document.getElementById("consumptionKWh").innerHTML	= x + " KWh / year";
		document.getElementById("consumptionKWHInput").value= x;
		document.getElementById("consumptionKWh").style.left= (x - cSlider.min) / (cSlider.max - cSlider.min) * (cSlider.offsetWidth - consumptionSliderWidth) + "px";
		calculatePrice();
	}

	// Updates the production slider
	function updateProductionHigh(x) {
		let cSlider											= document.getElementById("productionSliderHigh");
		document.getElementById("productionKWH").innerHTML	= x + " KWh / year";
		document.getElementById("productionKWHInput").value	= x;
		document.getElementById("productionKWH").style.left	= (x - cSlider.min) / (cSlider.max - cSlider.min) * (cSlider.offsetWidth - consumptionSliderWidth) + "px";
		calculatePrice();
	}

	// Updates the production slider
	function updateProductionLow(x) {
		let cSlider											= document.getElementById("productionSliderLow");
		document.getElementById("productionKWH").innerHTML	= x + " KWh / year";
		document.getElementById("productionKWHInput").value	= x;
		document.getElementById("productionKWH").style.left	= (x - cSlider.min) / (cSlider.max - cSlider.min) * (cSlider.offsetWidth - consumptionSliderWidth) + "px";
		calculatePrice();
	}

	function poaDisagree() {
		document.getElementById("poa").style.display		= "none";
		document.getElementById("formLayout").style.display	= "table";
		document.getElementById("formHeader").style.display	= "block";
	}

	function toggleTr(x, y, z) {
		if (z) {
			document.getElementById(z).value = (x.checked) ? 1 : 0;
		}

		document.getElementById(y).style.display = (x.checked) ? "table-row" : "none";
	}

	<?php
		if (isset($usingDefault)){
			if ($usingDefault == true){
				echo 'alert("Notice!\n\nWe were unable to fetch the current spot price and calculations will therefore be made using a default value.");';
			}
		}

		if(isset($_POST['step'])){
			echo '
			function mts(){';
				if ($_POST['step'] == 'householdInfo'){
					echo 'document.getElementById("00N4H00000E7Wbi").value = document.getElementById("roomSlider").value;';
					echo 'document.getElementById("00N4H00000E7Wbn").value = document.getElementById("occSlider").value;';
					echo 'document.getElementById("00N4H00000E7Wbs").value = ';
					echo 'document.getElementById("roomSlider").value * ' . $roomKwhScl . ' + document.getElementById("occSlider").value * ' . $occKwhScl . ' + ' . $fixedKwh . ';';
				}
				else if ($_POST['step'] == 'consumption'){
					echo 'document.getElementById("00N4H00000E7Wbs").value = ';
					echo 'document.getElementById("consumptionSlider").value;';
				} else if($_POST['step'] == 'productionHigh' || $_POST['step'] == 'productionLow') {
					echo 'document.getElementById("pwpWrapper1").style.display = "block";';
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
		echo 'document.getElementById("vatFP").innerHTML		= Math.round(vatJS, 0) + " öre";';
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
			if(document.getElementById("stepInput").value === "productionHigh" || document.getElementById("stepInput").value === "productionLow" || document.getElementById("stepInput").value === "excessProduction") {
				document.getElementById("productionTypeReturnInput").value	= "";
				document.getElementById("productionKWHInput").value			= "";
			}

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