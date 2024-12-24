<?php
$items = [
  ["image" => "assets/images/carousel1.png", "title" => "Slide 1"],
  ["image" => "assets/images/carousel2.png", "title" => "Slide 2"],
];
?>

<div class="relative w-full max-w-screen-lg mx-auto mt-4 overflow-hidden rounded-lg">
  <div id="carousel" class="flex transition-transform duration-700 ease-in-out w-full h-64 sm:h-80 lg:h-96">
    <?php foreach ($items as $item): ?>
      <div class="w-full flex-shrink-0 h-full">
        <img src="<?= $item['image'] ?>" alt="<?= $item['title'] ?>" class="w-full h-full object-contain bg-gray-100">
      </div>
    <?php endforeach; ?>
  </div>

  <button id="prevBtn" class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 text-white w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full hover:bg-gray-600 z-10">
    &lt;
  </button>
  <button id="nextBtn" class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-800 text-white w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full hover:bg-gray-600 z-10">
    &gt;
  </button>

  <div id="indicators" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
    <?php foreach ($items as $index => $item): ?>
      <button class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-gray-400" data-index="<?= $index ?>"></button>
    <?php endforeach; ?>
  </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", () => {
    const carousel = document.getElementById("carousel");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const indicators = document.querySelectorAll("#indicators button");
    const slides = document.querySelectorAll("#carousel > div");
    const totalSlides = slides.length;
    let currentIndex = 0;

    function updateCarousel() {
      carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
      indicators.forEach((indicator, index) => {
        indicator.classList.toggle("bg-gray-800", index === currentIndex);
        indicator.classList.toggle("bg-gray-400", index !== currentIndex);
      });
    }

    prevBtn.addEventListener("click", () => {
      currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
      updateCarousel();
    });

    nextBtn.addEventListener("click", () => {
      currentIndex = (currentIndex + 1) % totalSlides;
      updateCarousel();
    });

    indicators.forEach((indicator, index) => {
      indicator.addEventListener("click", () => {
        currentIndex = index;
        updateCarousel();
      });
    });

    updateCarousel();
  });
</script>