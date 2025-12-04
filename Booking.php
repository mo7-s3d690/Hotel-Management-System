<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MN'S Hotel</title>
    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    <video autoplay muted loop playsinline id="bg-video">
    <source src="hotelv2.mp4" type="video/mp4">
</video>
<header class = "lux-header">
    <div class = "left-section">
    <img src="Legends3.png" class="logo"> 
    <div class="v-line"></div>   
    <h1>WE ARE THE BEST</h1>
    </div>
    <nav class="nav-links">
        <a href ="#accommodations">ACCOMMODATIONS</a>
        <a href ="#dining">PHOTOS</a>
        <a href ="#">ABOUT US</a>
    </nav>
</header>
<div class="hotel-box">
  <h1>Book your stay</h1>
    <div class = "CC">
    <h2>Check In — Check Out</h2>
    <input type="text" id="dateRange" placeholder="Select check-in & check-out" readonly>
    </div>
    <div class="field-group">
        <h2>Room type</h2>
      <select name="Room type" required>
        <option value="" disabled >Type of room</option>
        <option value="Single" >Single</option>
        <option value="Double" >Double</option>
        <option value="Suite" >Suite</option>
      </select>

    </div>
    
<button class="open-btn">Book</button>
</div>
<section id="accommodations" class="section1">
    <video autoplay muted loop playsinline id="bg-video2">
    <source src="room.mp4" type="video/mp4">
</video>
    <h2>ACCOMMODATIONS</h2>
<div class="gallery">
    <div class="card">
        <img src="rooms.jpg">
        <p class="desc">Single room</p>
    </div>

    <div class="card">
        <img src="roomd.jpg">
        <p class="desc">Double room</p>
    </div>

    <div class="card">
        <img src="suite.jpg" >
        <p class="desc">Suite</p>
    </div>
</div>
</section>
<section id="dining" class="section1">
    <video autoplay muted loop playsinline id="bg-video3">
    <source src="exp.mp4" type="video/mp4">
    </video>
<div class="slider-section">
    <h2 class="section-title">PHOTOS</h2>

    <div class="slider-container">
        <img id="p1" src="din.jpg">
        <img id="p2"  src="din2.jpg">
        <img id="p3" src="din3.jpg">
        <img id="p4" src="ball1.jpg">
        <img id="p5" src="ball2.jpg">
        <img id="p6" src="ball3.jpg">
    </div>
        <div class = "slider-nav">
        <span data-slide="p1"></span>
        <span data-slide="p2"></span>
        <span data-slide="p3"></span>
        <span data-slide="p4"></span>
        <span data-slide="p5"></span>
        <span data-slide="p6"></span>
    </div>

</div>
    
</section>

<section id="about" class ="section1">
    <div class ="aboutus">
        <img src="Legends3.png" class="logo1"> 
        <h1>WE ARE THE BEST</h1>

        <h3>MAHMOUD HOSNY</h3>
        <h3>MOHAMED ALLAM (ZOQLOT)</h3>
        <h3>MOHAMED SA3D</h3>
        <h3>MAHMOUD ABDELRAHMAN</h3>
        <h3>MOHAMED TALAAT</h3>
        <h3>NOUR "ELDEEN" ALI</h3>
    </div>
</section>        
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
flatpickr("#dateRange", {
    mode: "range",            // enable range selection
    minDate: "today",         // cannot select past dates
    dateFormat: "Y-m-d",      // format the selected date
    onClose: function(selectedDates, dateStr, instance) {
        if (selectedDates.length === 2) {
            let checkIn = selectedDates[0].toISOString().slice(0, 10);
            let checkOut = selectedDates[1].toISOString().slice(0, 10);
            console.log("Check-in:", checkIn, "Check-out:", checkOut);
        }
    }
});
</script>
<script>
const sliderContainer = document.querySelector('.slider-container');
document.querySelectorAll('.slider-nav span').forEach((dot, index) => {
    dot.addEventListener('click', () => {
        sliderContainer.scrollTo({
            left: sliderContainer.clientWidth * index,
            behavior: 'smooth'
        });
    });
});
</script>
<script>
document.querySelector(".open-btn").onclick = function () {
    document.getElementById("paymentPopup").style.display = "flex";
};

document.querySelector(".close-btn").onclick = function () {
    document.getElementById("paymentPopup").style.display = "none";
};
</script>



</body>    