// Sample MSP Rates
const mspRates = {
  Paddy: { Common: 2183, "Grade A": 2203 },
  Jowar: { Hybrid: 3180, Maldandi: 3225 },
  Bajra: { "": 2500 },
  Maize: { "": 2090 },
  Ragi: { "": 3846 },
  "Arhar (Tur)": { "": 7000 },
  Moong: { "": 8558 },
  Urad: { "": 6950 },
  Cotton: { "Medium Staple": 6620, "Long Staple": 7020 },
  "Groundnut in shell": { "": 6377 },
  "Sunflower seed": { "": 6760 },
  Soyabeen: { Yellow: 4600 },
  Sesamum: { "": 8635 },
  Nigerseed: { "": 7734 },
  Wheat: { "": 2275 },
  Barley: { "": 1850 },
  Gram: { "": 5440 },
  "Masur (Lentil)": { "": 6425 },
  "Rapeseed & Mustard": { "": 5650 },
  Safflower: { "": 5800 },
  Toria: { "": 5450 },
  Copra: { Milling: 10860, Ball: 11750 },
  "De-husked coconut": { "": 2930 },
  "Raw Jute": { "": 5050 },
  Sugarcane: { "": 340 },
};

// Sample yield data (quintals per acre)
const yieldData = {
  Paddy: 25,
  Jowar: 15,
  Bajra: 12,
  Maize: 30,
  Ragi: 15,
  "Arhar (Tur)": 10,
  Moong: 8,
  Urad: 8,
  Cotton: 8,
  "Groundnut in shell": 15,
  "Sunflower seed": 8,
  Soyabeen: 15,
  Sesamum: 5,
  Nigerseed: 5,
  Wheat: 20,
  Barley: 20,
  Gram: 10,
  "Masur (Lentil)": 10,
  "Rapeseed & Mustard": 10,
  Safflower: 8,
  Toria: 8,
  Copra: 40,
  "De-husked coconut": 50,
  "Raw Jute": 25,
  Sugarcane: 400,
};

document.addEventListener("DOMContentLoaded", () => {
  const cropInput = document.getElementById("crop");
  const dropdown = document.getElementById("dropdown");
  const calculateBtn = document.getElementById("calculate");
  const resultsDiv = document.getElementById("results");
  const mspRatesSection = document.getElementById("msp-rates");
  const mspTableBody = document.getElementById("msp-table-body");
  const getStartedBtn = document.getElementById("get-started");

  // Handle dropdown suggestions
  cropInput.addEventListener("input", function () {
    const value = cropInput.value.toLowerCase();
    dropdown.innerHTML = "";
    const filteredCrops = Object.keys(mspRates).filter((crop) =>
      crop.toLowerCase().includes(value)
    );

    filteredCrops.forEach((crop) => {
      const div = document.createElement("div");
      div.textContent = crop;
      div.addEventListener("click", () => {
        cropInput.value = crop;
        dropdown.innerHTML = "";
        showVarieties(crop);
      });
      dropdown.appendChild(div);
    });

    dropdown.style.display = filteredCrops.length ? "block" : "none";
  });

  function showVarieties(crop) {
    const varieties = mspRates[crop];
    const varietiesList = Object.keys(varieties)
      .map((variety) => `${variety} - Rs ${varieties[variety]}`)
      .join(", ");
    cropInput.setAttribute("data-varieties", varietiesList);
  }

  // Calculate Profit
  calculateBtn.addEventListener("click", () => {
    const crop = cropInput.value;
    const area = parseFloat(document.getElementById("area").value);
    const additionalCosts =
      parseFloat(document.getElementById("additional-costs").value) || 0;

    if (!mspRates[crop]) {
      alert("Please select a valid crop.");
      return;
    }

    const varieties = mspRates[crop];
    const selectedVariety = Object.keys(varieties)[0]; // Get the first available variety
    const msp = varieties[selectedVariety];

    // Calculation
    const expectedYield = yieldData[crop] * area; // Using yield data
    const revenue = expectedYield * msp;
    const productionCost = calculateProductionCost(crop, area);
    const totalExpenses = productionCost + additionalCosts;
    const netProfit = revenue - totalExpenses;

    // Output Results
    resultsDiv.innerHTML = `
            <h2 class="results-heading">Profit Calculation Results</h2>
            <div class="result-item">
                <span><strong>Crop:</strong></span>
                <span class="result-value">${crop}</span>
            </div>
            <div class="result-item">
                <span><strong>Area:</strong></span>
                <span class="result-value">${area} acres</span>
            </div>
            <div class="result-item">
                <span><strong>Expected Yield:</strong></span>
                <span class="result-value">${expectedYield.toFixed(
                  2
                )} quintals</span>
            </div>
            <div class="result-item">
                <span><strong>MSP:</strong></span>
                <span class="result-value">Rs ${msp} per quintal</span>
            </div>
            <div class="result-item">
                <span><strong>Revenue:</strong></span>
                <span class="result-value">Rs ${revenue.toFixed(2)}</span>
            </div>
            <div class="result-item">
                <span><strong>Production Cost:</strong></span>
                <span class="result-value">Rs ${productionCost.toFixed(
                  2
                )}</span>
            </div>
            <div class="result-item">
                <span><strong>Additional Costs:</strong></span>
                <span class="result-value">Rs ${additionalCosts.toFixed(
                  2
                )}</span>
            </div>
            <div class="result-item">
                <span><strong>Total Expenses:</strong></span>
                <span class="result-value">Rs ${totalExpenses.toFixed(2)}</span>
            </div>
            <div class="result-item">
                <span><strong>Net Profit:</strong></span>
                <span class="result-value">Rs ${netProfit.toFixed(2)}</span>
            </div>
        `;

    resultsDiv.classList.remove("hidden");
    mspRatesSection.classList.add("hidden");

    resultsDiv.scrollIntoView({ behavior: "smooth" });
  });

  // Function to calculate production cost (simplified example)
  function calculateProductionCost(crop, area) {
    const baseCostPerAcre = 5000; // Base cost for all crops
    const cropSpecificCost = {
      Paddy: 2000,
      Wheat: 1800,
      Cotton: 3000,
      // Add more crops and their specific costs as needed
    };

    const specificCost = cropSpecificCost[crop] || 0;
    return (baseCostPerAcre + specificCost) * area;
  }

  // Handle MSP Rates click
  document
    .querySelector('a[href="#msp-rates"]')
    .addEventListener("click", (event) => {
      event.preventDefault();
      displayMSPRates();
      mspRatesSection.scrollIntoView({ behavior: "smooth" });
    });

  // Function to display MSP rates in a table
  function displayMSPRates() {
    mspTableBody.innerHTML = "";

    for (const crop in mspRates) {
      const varieties = mspRates[crop];
      for (const variety in varieties) {
        const msp = varieties[variety];
        const row = document.createElement("tr");

        row.innerHTML = `
                    <td>${crop}</td>
                    <td>${variety || "N/A"}</td>
                    <td>${msp}</td>
                `;
        mspTableBody.appendChild(row);
      }
    }

    mspRatesSection.classList.remove("hidden");
    resultsDiv.classList.add("hidden");
  }

  // Get Started button
  getStartedBtn.addEventListener("click", () => {
    document
      .getElementById("profit-calculator")
      .scrollIntoView({ behavior: "smooth" });
  });
});