// Simple banner carousel functionality
document.addEventListener('DOMContentLoaded', function() {
    // Auto-slide functionality for promo carousel
    const carousel = document.getElementById('promoCarousel');
    if (carousel) {
        const carouselInstance = new bootstrap.Carousel(carousel, {
            interval: 3000, // 3 seconds
            ride: 'carousel'
        });
    }
});
