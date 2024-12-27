<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .stars span {
  font-size: 2rem;
  cursor: pointer;
  color: gray; /* Default color for unlit stars */
  transition: color 0.3s;
}

.stars span.highlighted {
  color: gold; /* Color for lit stars */
}

    </style>
</head>
<body>
<div class="stars" id="star-rating">
  <span data-value="1">&#9733;</span>
  <span data-value="2">&#9733;</span>
  <span data-value="3">&#9733;</span>
  <span data-value="4">&#9733;</span>
  <span data-value="5">&#9733;</span>
</div>
<p id="rating-value">Rating: 0</p>

<script>
    const stars = document.querySelectorAll("#star-rating span");
const ratingValue = document.getElementById("rating-value");

stars.forEach((star, index) => {
  star.addEventListener("click", () => {
    // Remove the "highlighted" class from all stars
    stars.forEach(s => s.classList.remove("highlighted"));
    
    // Add the "highlighted" class to all stars up to the clicked one
    for (let i = 0; i <= index; i++) {
      stars[i].classList.add("highlighted");
    }

    // Update the rating value
    ratingValue.textContent = `Rating: ${index + 1}`;
  });
});

</script>

</body>
</html>