const quotes = [
    "The best stay is where you feel at home.",
    "Every stay is a new journey waiting to begin.",
    "Travel doesn’t end when you arrive, it begins when you relax.",
    "This is where memories are made.",
    "Happiness is found in a place that makes your heart race."
];

let index = 0;

function changeQuote() {
    const quoteElement = document.getElementById("quote");
    quoteElement.style.opacity = 0; // Fade out

    setTimeout(() => {
        quoteElement.textContent = quotes[index];
        quoteElement.style.opacity = 1; // Fade in
    }, 500); // Duration of the fade out

    index = (index + 1) % quotes.length; // Loop through quotes
}

// Initialize first quote
changeQuote();
setInterval(changeQuote, 4000);