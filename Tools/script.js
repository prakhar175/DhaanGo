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

// Handle dropdown suggestions
const cropInput = document.getElementById("crop");
const dropdown = document.getElementById("dropdown");

// Show dropdown options
cropInput.addEventListener("input", function () {
  const value = cropInput.value.toLowerCase();
  dropdown.innerHTML = ""; // Clear previous suggestions
  const filteredCrops = Object.keys(mspRates).filter((crop) =>
    crop.toLowerCase().includes(value)
  );

  filteredCrops.forEach((crop) => {
    const div = document.createElement("div");
    div.textContent = crop;
    div.addEventListener("click", () => {
      cropInput.value = crop;
      dropdown.innerHTML = ""; // Clear suggestions after selection
      showVarieties(crop); // Show varieties for selected crop
    });
    dropdown.appendChild(div);
  });

  dropdown.style.display = filteredCrops.length ? "block" : "none"; // Show dropdown if there are suggestions
});

// Show varieties for the selected crop
function showVarieties(crop) {
  const varieties = mspRates[crop];
  const varietiesList = Object.keys(varieties)
    .map((variety) => `${variety} - Rs ${varieties[variety]}`)
    .join(", ");
  cropInput.setAttribute("data-varieties", varietiesList); // Store varieties in data attribute
}

// Calculate Profit
document.getElementById("calculate").addEventListener("click", () => {
  const crop = cropInput.value;
  const area = parseFloat(document.getElementById("area").value);
  const additionalCosts = parseFloat(
    document.getElementById("additional-costs").value
  );

  if (!mspRates[crop]) {
    alert("Please select a valid crop.");
    return;
  }

  const varieties = mspRates[crop];
  const selectedVariety = Object.keys(varieties)[0]; // Get the first available variety
  const msp = varieties[selectedVariety];

  // Calculation
  const expectedYield = area * 2; // Assuming an average yield of 2 quintals per acre
  const revenue = expectedYield * msp; // Total revenue
  const totalExpenses = additionalCosts; // Only additional costs for now
  const netProfit = revenue - totalExpenses; // Calculate net profit

  // Output Results
  document.getElementById("results").innerHTML = `
        <h2 class="results-heading">Profit Calculation Results</h2>
        <div class="result-item">
            <span><strong>Expected Yield:</strong></span>
            <span class="result-value">${expectedYield.toFixed(
              2
            )} quintals</span>
        </div>
        <div class="result-item">
            <span><strong>Revenue:</strong></span>
            <span class="result-value">Rs ${revenue.toFixed(2)}</span>
        </div>
        <div class="result-item">
            <span><strong>Expenses:</strong></span>
            <span class="result-value">Rs ${totalExpenses.toFixed(2)}</span>
        </div>
        <div class="result-item">
            <span><strong>Net Profit:</strong></span>
            <span class="result-value">Rs ${netProfit.toFixed(2)}</span>
        </div>
    `;

  document.getElementById("results").classList.remove("hidden");

  // Hide the MSP Rates table
  const mspRatesSection = document.getElementById("msp-rates");
  mspRatesSection.classList.add("hidden");

  // Hide the calculator inputs
  const calculatorSection = document.querySelector(".calculator"); // Assuming the calculator section has a class 'calculator'
  calculatorSection.classList.add("hidden");
});

// Handle MSP Rates click
const mspRatesLink = document.querySelector('a[href="#"]:nth-child(2)'); // Assuming MSP Rates is the second link

mspRatesLink.addEventListener("click", (event) => {
  event.preventDefault(); // Prevent default anchor behavior
  displayMSPRates(); // Call the function to display MSP rates
});

// Function to display MSP rates in a table
function displayMSPRates() {
  const mspTableBody = document.getElementById("msp-table-body");
  mspTableBody.innerHTML = ""; // Clear previous table data

  for (const crop in mspRates) {
    const varieties = mspRates[crop];
    for (const variety in varieties) {
      const msp = varieties[variety];
      const row = document.createElement("tr");

      row.innerHTML = `
                <td class="border border-gray-300 px-4 py-2">${crop}</td>
                <td class="border border-gray-300 px-4 py-2">${
                  variety || "N/A"
                }</td>
                <td class="border border-gray-300 px-4 py-2">${msp}</td>
            `;
      mspTableBody.appendChild(row);
    }
  }

  // Show the MSP rates section
  const mspRatesSection = document.getElementById("msp-rates");
  mspRatesSection.classList.remove("hidden");

  // Hide the calculator results and inputs
  const resultsSection = document.getElementById("results");
  resultsSection.classList.add("hidden");
  const calculatorSection = document.querySelector(".calculator"); // Assuming the calculator section has a class 'calculator'
  calculatorSection.classList.add("hidden");
}
