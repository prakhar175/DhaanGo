const API_KEY = "b47de799390d45aeb412e8f808e939a0";
let apiUrl = `https://newsapi.org/v2/everything?q=Apple&from=2024-10-18&sortBy=popularity&apiKey=${API_KEY}`;

async function fetchNews() {
    try {
        const response = await fetch(apiUrl); // Fetch the data
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json(); // Parse the JSON data
        
        const newsContainer = document.getElementById("main");
        newsContainer.innerHTML = ""; // Clear previous news

        // Create and display the news articles
        data.articles.forEach(article => {
            const articleElement = document.createElement("div");
            articleElement.classList.add("article"); // Optional: add a class for styling
            
            articleElement.innerHTML = `
                <h2>${article.title}</h2>
                <p>${article.description}</p>
                <a href="${article.url}" target="_blank">Read more</a>
            `;
            newsContainer.appendChild(articleElement);
        });
    } catch (error) {
        console.error('Error fetching the news:', error); // Handle errors
    }
}

// Call the function
fetchNews();
