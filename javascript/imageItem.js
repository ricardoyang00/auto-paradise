document.addEventListener('DOMContentLoaded', function() {
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    const images = document.querySelectorAll('.carousel-image');
    let currentIndex = 0;

    function showImage(index) {
        images.forEach((image, idx) => {
            if (idx === index) {
                image.style.display = 'block';
            } else {
                image.style.display = 'none';
            }
        });
    }

    prevBtn.addEventListener('click', function() {
        currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
        showImage(currentIndex);
    });

    nextBtn.addEventListener('click', function() {
        currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
        showImage(currentIndex);
    });

    showImage(currentIndex);
});

