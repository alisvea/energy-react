var priceSliderWidth = 100,
    consumptionSliderWidth = 100;

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
    if (document.getElementById("00N4H00000E2sbz").value === "1") {
        clickSendQuote();
    }

    // Enables the 2nd toggle if the main toggle is toggled on.
    if (document.getElementById("showMeHowMuchInput").value === "1") {
        if (document.getElementById("00N4H00000E2sbz").value === "0") {
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
    if (x > 5001 && x < 7000) {
        return 4000;
    } else if (x > 7001 && x < 11000) {
        return 6000;
    } else if (x > 11000) {
        return 8000;
    } else if (x < 5001) {
        if (document.getElementById("showSaleInput").value === "show") {
            alert("Det är osäkert om du har plats för solceller. Men prata gärna med en av våra solcellskonsulter");
        }
        return 3000;
    }
}

function showSale() {
    if (document.getElementById("showSaleInput").value === "show") {
        document.getElementById("showSaleInput").value = "hide";
        document.getElementById("showExcessProductionContainer").style.display = "none"
        document.getElementById("toggleSendQuoteContainer").style.display = "none";
        document.getElementById("secondPie").style.display = "none";
        document.getElementById("firstPie").style.display = "block";
    } else {
        document.getElementById("showSaleInput").value = "show";
        document.getElementById("showExcessProductionContainer").style.display = "block"
        document.getElementById("toggleSendQuoteContainer").style.display = "block";
        document.getElementById("secondPie").style.display = "block";
        document.getElementById("firstPie").style.display = "none";
        document.getElementById("estBill").scrollIntoView({behavior: "smooth"});
        var element = document.getElementById("priceBillPopup");
        element.classList.add("mystyle");
    }
}

function checkIfFilledNoNumbers(element) {
    element.value = element.value.replace(/[0-9]/g, '');
    checkIfFilled()
}

function checkIfFilled() {
    let inputs = document.querySelectorAll(".inputFormInfo");
    let button = document.getElementById("submitInfo");
    let status = false;

    for (let i = 0; i < inputs.length; ++i) {
        if (inputs[i].type === "checkbox") {
            // status = !inputs[i].checked;
            if (!inputs[i].checked) {
                status = true;
            }
        } else {
            const value = inputs[i].value.trim();
            console.log(value);
            if (!value) {
                status = true;
            }
        }
    }

    button.disabled = status;
}

function updateSSI(x) {
    document.getElementById("showMeHowMuchInput").value = (x.checked) ? "1" : "0";
    /* 		document.getElementById("00N4H00000E7WDl").value	= (x.checked) ? "Rörligt - Bundet (3 år)" : "Rörligt - Obundet";
            document.getElementById("00N4H00000E7WDq").value	= (x.checked) ? "Rörligt - Bundet (3 år)" : "Rörligt - Obundet"; */

    extendPage();
    showSale();
}

function togglePopup(x, y, m, z) {
    let p = document.getElementById(x);
    p.style.display = (p.style.display == "none" || p.style.display == "") ? y : "none";
    document.getElementById(m).style.display = (p.style.display == "none" || p.style.display == "") ? "none" : "block";

    if (z && p.style.display == "none") {
        document.getElementById("content").style.opacity = 1;
    }
    if (x == "formPopup" && p.style.display == "none") {
        document.getElementById("content").style.marginBottom = "0";
    }

    document.getElementById(x).scrollIntoView({behavior: "smooth"});

    if (document.getElementById("showSaleInput").value === "show" && x === "formPopup") {
        clickSSI();
    }
}

function updateCheckbox(x) {
    x.value = (x.value == "0") ? "1" : "0";
}

function extendPage() {
    let cntBR = document.getElementById("content").getBoundingClientRect();
    let frmBR = document.getElementById("formPopup").getBoundingClientRect();

    if (frmBR.bottom > cntBR.bottom) {
        document.getElementById("content").style.marginBottom = (frmBR.bottom - cntBR.bottom) * 1.2 + "px";
    }
}

function updatePrice(x) {
    let pBar = document.getElementById("priceTrack");

    let pMax = 4000, pMin = 0;
    // Yearly consumption
    let consumption = document.getElementById("consumptionKWHInput").value;

    // Yearly production
    let yearlyProduction = document.getElementById("productionKWHInput").value;

    if (document.getElementById("stepInput").value === "excessProduction") {
        yearlyProduction = roundProduction(consumption);
    }

    // Yearly consumption
    let monthlyConsumption = consumption / 12;

    // Monthly production
    let monthlyProduction = yearlyProduction / 12;

    // Price per hour for production
    let pricePerProdHour = (34.987635416667 / 100) + 0.9;

    if (document.getElementById("stepInput").value === "productionHigh") {
        pricePerProdHour = (34.987635416667 / 100) + 0.65;
    } else if (document.getElementById("stepInput").value === "productionLow") {
        pricePerProdHour = (34.987635416667 / 100) + 0.63;
    }

    // Consumption price per kWh
    let pricePerKwh = 53.609544270834;

    // Consumption price
    let conPrice = Math.round((monthlyConsumption * pricePerKwh) / 100 + 39);

    // Total price reduced by production
    let prodPrice = Math.round(monthlyProduction * pricePerProdHour);

    if (document.getElementById("stepInput").value === "productionLow" || document.getElementById("stepInput").value === "productionHigh") {
        conPrice = Math.round(x);
    }


    if (conPrice <= 0) {
        if (document.getElementById("stepInput").value === "productionLow") {
            document.getElementById("prodErrorLow").innerHTML = "Hoppsan! Här verkar er solproduktion ej matcha er förbrukning. Antingen har ni för låg förbrukning för denna kalkylatorn eller så har ni ej angett er totalförbrukning innan ni skaffade solceller i början. Vänligen gå tillbaka och fyll i er förbrukning eller tryck nästa för att se vår prissättning.";
        } else if (document.getElementById("stepInput").value === "productionHigh") {
            document.getElementById("prodErrorHigh").innerHTML = "Hoppsan! Här verkar er solproduktion ej matcha er förbrukning. Antingen har ni för låg förbrukning för denna kalkylatorn eller så har ni ej angett er totalförbrukning innan ni skaffade solceller i början. Vänligen gå tillbaka och fyll i er förbrukning eller tryck nästa för att se vår prissättning.";
        }
    } else {
        if (document.getElementById("stepInput").value === "productionLow") {
            document.getElementById("prodErrorLow").innerHTML = "";
        } else if (document.getElementById("stepInput").value === "productionHigh") {
            document.getElementById("prodErrorHigh").innerHTML = "";
        }
    }

    let adjustedPrice = Math.round(conPrice - (((monthlyProduction * pricePerKwh / 100) * 0.65)) - (monthlyProduction * 0.35 * pricePerProdHour));
    document.getElementById("priceFill").style.width = conPrice / pMax * 100 + "%";
    document.getElementById("priceText").innerHTML = conPrice + " KR PER MÅNAD";
    document.getElementById("ppKwhFPProd").innerHTML = Math.round(pricePerProdHour * 100) + " öre";
    document.getElementById("estMonCProdFP").innerHTML = Math.round(monthlyProduction * 0.35) + " kWh";
    document.getElementById("consumptionKWhextra").innerHTML = Math.round((monthlyConsumption) - 0.65 * (yearlyProduction / 12)) + " KWh";
    document.getElementById("productionKWHtest").innerHTML = Math.round((yearlyProduction / 12) * 0.35) + " KWh";

    if (document.getElementById("stepInput").value === "excessProduction") {
        document.getElementById("monProdFP").innerHTML = Math.round(monthlyProduction * 0.35 * pricePerProdHour) + " kr / månad"
    }

    if (document.getElementById("showSaleInput").value == 'show') {
        document.getElementById("formPrice").innerHTML = "<div><h1 style='padding:28px'><div class='price-sale-outer'><p>" + conPrice + " kr</p></div>" + Math.round(((monthlyConsumption - (monthlyProduction * 0.65)) * pricePerKwh) / 100 + 39) + " kr</h1><span>PER MÅNAD</span></div>";
        document.getElementById("estMonConFP").innerHTML = Math.round(monthlyConsumption - (monthlyProduction * 0.65)) + " kWh";
        document.getElementById("monBillFP").innerHTML = Math.round(((monthlyConsumption - (monthlyProduction * 0.65)) * pricePerKwh) / 100 + 39) + " kr / månad";
    } else if (document.getElementById("stepInput").value === "productionHigh" || document.getElementById("stepInput").value === "productionLow") {
        document.getElementById("formPrice").innerHTML = "<h1><span>Din kostnad</span>" + x + " kr <span>PER MÅNAD</span></h1>";
        document.getElementById("estMonConFP").innerHTML = Math.round(monthlyConsumption - (monthlyProduction * 0.65)) + " kWh";
        document.getElementById("monBillFP").innerHTML = Math.round((monthlyConsumption * pricePerKwh) / 100 + 39) + " kr / månad";
    } else {
        document.getElementById("formPrice").innerHTML = "<h1><span>Din kostnad</span>" + x + " kr <span>PER MÅNAD</span></h1>";
        document.getElementById("estMonConFP").innerHTML = Math.round(monthlyConsumption) + " kWh";
        document.getElementById("monBillFP").innerHTML = Math.round((monthlyConsumption * pricePerKwh) / 100 + 39) + " kr / månad";
    }

    if (document.getElementById("stepInput").value === "productionHigh" || document.getElementById("stepInput").value === "productionLow") {
        let omProdChoose = document.getElementById("productionKWHInput").value;
        document.getElementById("monProdChoose").innerHTML = Math.round(omProdChoose * pricePerProdHour / 12 * 0.35) + " kr / månad";
        document.getElementById("monProdVal").innerHTML = "DIN VINST: <strong>" + Math.round(omProdChoose * pricePerProdHour / 12 * 0.35) + "</strong> kr / månad";
        document.getElementById("estMonCProdFP").innerHTML = Math.round(omProdChoose / 12 * 0.35) + " kWh";
        document.getElementById("monBillFP").innerHTML = Math.round(((monthlyConsumption - (monthlyProduction * 0.65)) * (pricePerKwh / 100)) + 39) + " kr / månad";
    }

}

// Updates the consumption slider
function updateConsumption(x) {
    let cSlider = document.getElementById("consumptionSlider");
    document.getElementById("consumptionKWh").innerHTML = x + " kWh / år";
    document.getElementById("consumptionKWHInput").value = x;
    document.getElementById("consumptionKWh").style.left = (x - cSlider.min) / (cSlider.max - cSlider.min) * (cSlider.offsetWidth - consumptionSliderWidth) + "px";
    calculatePrice();
}

// Updates the production slider
function updateProductionHigh(x) {
    let cSlider = document.getElementById("productionSliderHigh");
    document.getElementById("productionKWH").innerHTML = x + " kWh / år";
    document.getElementById("productionKWHInput").value = x;
    document.getElementById("productionKWH").style.left = (x - cSlider.min) / (cSlider.max - cSlider.min) * (cSlider.offsetWidth - consumptionSliderWidth) + "px";
    calculatePrice();

    if (x == roundProduction(document.getElementById("consumptionKWHInput").value)) {
        document.getElementById("productionHighButton").style.backgroundColor = "rgb(115, 164, 33)"
    } else {
        document.getElementById("productionHighButton").style.backgroundColor = "#fff"
    }
}

// Updates the production slider
function updateProductionLow(x) {
    let cSlider = document.getElementById("productionSliderLow");
    document.getElementById("productionKWH").innerHTML = x + " kWh / år";
    document.getElementById("productionKWHInput").value = x;
    document.getElementById("productionKWH").style.left = (x - cSlider.min) / (cSlider.max - cSlider.min) * (cSlider.offsetWidth - consumptionSliderWidth) + "px";
    calculatePrice();

    if (x == roundProduction(document.getElementById("consumptionKWHInput").value)) {
        document.getElementById("productionLowButton").style.backgroundColor = "rgb(115, 164, 33)"
    } else {
        document.getElementById("productionLowButton").style.backgroundColor = "#fff"
    }
}

function poaDisagree() {
    document.getElementById("poa").style.display = "none";
    document.getElementById("formLayout").style.display = "table";
    document.getElementById("formHeader").style.display = "block";
}

function setProductionSlider(type) {
    let defProduction = roundProduction(document.getElementById("consumptionKWHInput").value);

    if (defProduction <= 3000) {
        defProduction = 3000;
    }

    if (type === "productionHigh") {
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

function formatSSN(x) {
    if (event.keyCode == 9) { // Tab
        return
    } else if ((event.keyCode < 48 && event.keyCode != 8) || event.keyCode > 57) {
        event.preventDefault();
    } else if (x.value.length == 6 && event.keyCode != 8) {
        x.value += "-";
    }
}


function mts() {
    document.getElementById("00N4H00000E7Wbs").value = document.getElementById("consumptionKWHInput").value;
    document.getElementById("pwpWrapper1").style.display = "block";
    if (document.getElementById("stepInput").value === "productionHigh") {
        document.getElementById("productionTypeReturnInput").value = "high";
        document.getElementById("00N4H00000E7Wkp").value = "1";
        document.getElementById("00N4H00000E7WKN").value = "1";
        document.getElementById("00N4H00000E7WDq").value = "Rörligt - Obundet(SVEAProd)";
    } else if (document.getElementById("stepInput").value === "productionLow") {
        document.getElementById("productionTypeReturnInput").value = "low";
        document.getElementById("00N4H00000E7Wkp").value = "0";
        document.getElementById("00N4H00000E7WKN").value = "1";
        document.getElementById("00N4H00000E7WDq").value = "Rörligt - Obundet (Prod)";
    }
    ;document.getElementById("content").style.opacity = "0.4";
    document.getElementById("formPopup").style.display = (window.innerWidth > window.innerHeight) ? "flex" : "block";
    document.getElementById("maskFormPopup").style.display = "block";
    extendPage();
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth"
    });
}

var spPrice = 34.987635416667;

function calculatePrice() {
    let spotPrice = 34.987635416667;
    let pricePerKwh = 53.609544270834;
    let vatJS = 10.721908854167;
    let kwhConsumption = document.getElementById("consumptionKWHInput").value;
    let monthlyConsumption = document.getElementById("consumptionKWHInput").value / 12;
    let kwhProduction = document.getElementById("productionKWHInput").value || 1;
    let monthlyProduction = document.getElementById("productionKWHInput").value / 12 || 1;
    let price = Math.round((monthlyConsumption * pricePerKwh) / 100 + 39);
    document.getElementById("ppKwhFP").innerHTML = Math.round(pricePerKwh * 100) / 100 + " öre";
    document.getElementById("vatFP").innerHTML = Math.round(vatJS * 100) / 100 + " öre";
    document.getElementById("monFeeFP").innerHTML = 39 + " kr";
    price = Math.round(price - (monthlyProduction * (0.65 * (34.987635416667 + 5.95 + 6.75) / 100 + (0.35 * (34.987635416667 + 5 + 60) / 100))));
    updatePrice(price);
}

function submitHT(x) {
    document.getElementById("houseTypeInput").value = x;
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
    if (step == "productionHigh") {
        document.getElementById("productionTypeReturnInput").value = "high";
    } else if (step == "productionLow") {
        document.getElementById("productionTypeReturnInput").value = "low";
    } else {
        document.getElementById("productionTypeReturnInput").value = "";
    }

    document.getElementById("stepInput").value = step;
    document.getElementById("form").submit();
}

function goBack(step) {
    if (document.getElementById("stepInput").value === "productionHigh" || document.getElementById("stepInput").value === "productionLow" || document.getElementById("stepInput").value === "excessProduction") {
        document.getElementById("productionTypeReturnInput").value = "";
        document.getElementById("productionKWHInput").value = "";
        document.getElementById("00N4H00000E7Wkp").value = "0";
        document.getElementById("00N4H00000E7WKN").value = "0";
        document.getElementById("00N4H00000E7WDq").value = "Rörligt - Obundet"
    }

    document.getElementById("stepInput").value = step;
    document.getElementById("form").submit();
};

function nextStep(step) {
    document.getElementById("stepInput").value = step;
    document.getElementById("form").submit();
}

calculatePrice();