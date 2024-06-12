document.addEventListener('DOMContentLoaded', function() {
   const profile = document.querySelector('.header .flex .profile');
   const navbar = document.querySelector('.header .flex .navbar');
   const userBtn = document.getElementById('user-btn');
   const menuBtn = document.getElementById('menu-btn');
   const subImages = document.querySelectorAll('.update-product .image-container .sub-images img');
   const mainImage = document.querySelector('.update-product .image-container .main-image img');

   // Toggle profile active class on user button click
   userBtn.addEventListener('click', function() {
       profile.classList.toggle('active');
       navbar.classList.remove('active');
   });

   // Toggle navbar active class on menu button click
   menuBtn.addEventListener('click', function() {
       navbar.classList.toggle('active');
       profile.classList.remove('active');
   });

   // Remove active classes from profile and navbar on window scroll
   window.addEventListener('scroll', function() {
       profile.classList.remove('active');
       navbar.classList.remove('active');
   });

   // Switch main image on sub image click
   subImages.forEach(image => {
       image.addEventListener('click', function() {
           const src = image.getAttribute('src');
           mainImage.src = src;
       });
   });
});
