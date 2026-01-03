<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About Us | Futuristic Gaming</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Montserrat&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/02e480ab6c.js" crossorigin="anonymous"></script>

<style>
body{
    background: radial-gradient(circle at top, #0f2027, #000);
    color: #fff;
    font-family: 'Montserrat', sans-serif;
}

.about-us{
    padding: 6rem 2rem;
    text-align: center;
}

/* Title */
.about-us h1{
    font-family: 'Orbitron', sans-serif;
    font-size: 3rem;
    text-shadow: 0 0 20px #00f6ff;
    margin-bottom: 4rem;
}

/* Glass Card */
.glass-card{
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 0 30px rgba(0,255,255,.2);
    transition: 0.4s;
}

.glass-card:hover{
    transform: translateY(-10px);
    box-shadow: 0 0 50px rgba(0,255,255,.6);
}

/* Avatar */
.avatar{
    width:150px;
    height:150px;
    border-radius:50%;
    border: 3px solid #00fff0;
    box-shadow: 0 0 25px #00fff0;
    margin-bottom: 1.5rem;
}

/* Name */
.dev-name{
    font-family: 'Orbitron', sans-serif;
    font-size: 1.5rem;
    color:#00fff0;
    text-shadow: 0 0 10px #00fff0;
}

/* Description */
.dev-desc{
    margin-top:1.5rem;
    font-size:1rem;
    color:#dcdcdc;
}

/* About Channel */
.about-channel{
    margin-top:6rem;
}

.about-channel h2{
    font-family: 'Orbitron', sans-serif;
    color:#ff00ff;
    text-shadow: 0 0 15px #ff00ff;
}

.about-channel p{
    max-width:800px;
    margin:auto;
    margin-top:2rem;
}

/* Tech Icons */
.tech-icons{
    margin-top:4rem;
}

.tech-icons i{
    font-size:4rem;
    margin:0 1.5rem;
    transition:0.3s;
}

.tech-icons i:hover{
    transform: scale(1.2) rotate(5deg);
    filter: drop-shadow(0 0 20px currentColor);
}

/* Carousel Control */
.carousel-control-prev-icon,
.carousel-control-next-icon{
    filter: invert(1);
}
</style>
</head>

<body>

<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="../../index.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
        </a>
    </div>
</div>

<div class="about-us container">

<h1>ABOUT THE TEAM</h1>

<div id="teamCarousel" class="carousel slide" data-ride="carousel" data-interval="6000">
<div class="carousel-inner">

<!-- Member 1 -->
<div class="carousel-item active">
<div class="glass-card">
<img src="download (1)-min.jpg" class="avatar">
<h2 class="dev-name">Muhammad Miftakhul Faizin</h2>
<p class="dev-desc">
Frontend & UI Designer. Fokus pada tampilan futuristik, UX modern, dan desain ala gaming PC.
</p>
</div>
</div>

<!-- Member 2 -->
<div class="carousel-item">
<div class="glass-card">
<img src="images/Hell_ound_pic.png" class="avatar">
<h2 class="dev-name">Muhammad Irfan Dzakir</h2>
<p class="dev-desc">
Backend Developer & Logic Builder. Node.js, database, dan sistem modular.
</p>
</div>
</div>

<!-- Member 3 -->
<div class="carousel-item">
<div class="glass-card">
<img src="images/Intersted-coder-profilepic.png" class="avatar">
<h2 class="dev-name">Saif Maajid Mubarak</h2>
<p class="dev-desc">
Fullstack Developer. HTML, CSS, JS, Python, dan pengembangan aplikasi modern.
</p>
</div>
</div>

</div>

<a class="carousel-control-prev" href="#teamCarousel" data-slide="prev">
<span class="carousel-control-prev-icon"></span>
</a>
<a class="carousel-control-next" href="#teamCarousel" data-slide="next">
<span class="carousel-control-next-icon"></span>
</a>

</div>

<!-- ABOUT CHANNEL -->
<div class="about-channel">
<h2>ABOUT THIS PROJECT</h2>
<p>
Project ini dibuat dengan nuansa <b>gaming & PC enthusiast</b>, menggabungkan desain futuristik,
RGB glow, dan teknologi modern untuk memberikan pengalaman visual seperti setup PC high-end.
</p>
</div>

<!-- TECH ICONS -->
<div class="tech-icons">
<i class="fab fa-html5" style="color:#ff4c4c"></i>
<i class="fab fa-css3-alt" style="color:#00bfff"></i>
<i class="fab fa-js-square" style="color:#f7ff00"></i>
<i class="fab fa-python" style="color:#b366ff"></i>
<i class="fas fa-microchip" style="color:#00fff0"></i>
</div>

</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
