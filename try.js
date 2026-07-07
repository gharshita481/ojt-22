document.getElementById('reviewForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const review = document.getElementById('review').value;

    fetch('submit_review.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name, review })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadReviews();
            document.getElementById('reviewForm').reset();
        } else {
            alert('Error submitting review');
        }
    });
});

function loadReviews() {
    fetch('get_reviews.php')
        .then(response => response.json())
        .then(data => {
            const reviewsDiv = document.getElementById('reviews');
            reviewsDiv.innerHTML = '';
            data.forEach(review => {
                const reviewDiv = document.createElement('div');
                reviewDiv.classList.add('review');
                reviewDiv.innerHTML = `<strong>${review.name}</strong><p>${review.review}</p><small>${review.created_at}</small>`;
                reviewsDiv.appendChild(reviewDiv);
            });
        });
}

// Load reviews on page load
window.onload = loadReviews;