<?php include 'header.php'; ?>
<style>
    /* General body styles */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9f9f9;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Navbar styles */
    .navbar {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 10;
        transition: background-color 0.3s, box-shadow 0.3s;
    }
    .navbar.transparent {
        box-shadow: none;
    }
    .navbar.scrolled {
        background-color: #343a40 !important;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5);
    }
    .navbar .nav-link {
        color: black;
        transition: color 0.3s;
    }
    .navbar.scrolled .nav-link {
        color: #ffc107;
    }
    .navbar-brand img {
        height: 50px;
        transition: transform 0.3s;
    }
    .navbar.scrolled .navbar-brand img {
        transform: scale(0.8);
    }
    /* Hero section */
    .hero {
        position: relative;
        background: url('img/background.jpg') no-repeat center center/cover;
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        margin-bottom: 50px; /* Adăugăm un spațiu între imagine și secțiunea următoare */
    }

    .hero h1 {
        font-size: 3.5rem;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 20px;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
    }

    .hero a {
        font-size: 1.2rem;
        font-weight: bold;
        padding: 10px 20px;
    }

    /* Content sections */
    .content-sections {
        padding: 50px 10px;
        background-color: #fff; /* Fundal alb pentru a separa clar conținutul de imagine */
        box-shadow: 0 -5px 10px rgba(0, 0, 0, 0.1); /* Efect de separare */
    }

    .content-sections h2 {
        margin-bottom: 30px;
    }

    .card {
        border: none;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-weight: bold;
        color: #333;
    }

    /* Footer */
    footer {
        background-color: #343a40;
        color: #ffffff;
        padding: 20px 0;
        text-align: center;
    }

    footer a {
        color: #ffc107;
        text-decoration: none;
    }

    footer a:hover {
        text-decoration: underline;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1rem;
        }

        .content-sections {
            padding: 30px 10px;
        }
    }
/* Bootstrap carousel fullscreen */
.carousel-item {
  height: 100vh; /* Pe toată înălțimea viewport */
  min-height: 600px; /* fallback */
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
}
.carousel-caption {
  bottom: 40%;
}
.carousel-caption h1 {
  font-size: 3.5rem;
  text-shadow: 0 2px 6px rgba(0,0,0,0.7);
}
.carousel-caption p {
  font-size: 1.3rem;
  text-shadow: 0 1px 3px rgba(0,0,0,0.7);
}
.carousel-caption a.btn-hero {
  background-color: #ffc107;
  color: #000;
  padding: 15px 30px;
  font-size: 1.2rem;
  border: none;
  border-radius: 5px;
  font-weight: bold;
}
.carousel-caption a.btn-hero:hover {
  background-color: #e0a800;
}
    @media (max-width: 576px) {
        .hero h1 {
            font-size: 2rem;
        }

        .hero p {
            font-size: 0.9rem;
        }

        .btn {
            font-size: 0.9rem;
            padding: 8px 15px;
        }
    }
</style>


<script>
    // Schimbare navbar la scroll
    document.addEventListener("scroll", function () {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
            navbar.classList.remove('transparent');
        } else {
            navbar.classList.add('transparent');
            navbar.classList.remove('scrolled');
        }
    });
</script>

<!-- Carousel -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="15000">
  <div class="carousel-inner">
    <div class="carousel-item active" style="background-image: url('img/background.jpg');">
      <div class="carousel-caption text-center">
        <h1 class="display-3">Sabaya Yemeni Kitchen</h1>
        <p class="lead">Descoperă savoarea bucătăriei tradiționale yemeni!</p>
        <a href="reservation.php" class="btn-hero">Rezervă acum</a>
      </div>
    </div>
    <div class="carousel-item" style="background-image: url('img/background2.jpg');">
      <div class="carousel-caption text-center">
        <h1 class="display-3">Arome autentice</h1>
        <p class="lead">Meniuri irezistibile cu ingrediente proaspete</p>
        <a href="menu.php" class="btn-hero">Vezi Meniul</a>
      </div>
    </div>
    <div class="carousel-item" style="background-image: url('img/background3.jpg');">
      <div class="carousel-caption text-center">
        <h1 class="display-3">Te așteptăm în Brașov!</h1>
        <p class="lead">Vino să guști rețetele tradiționale yemeni</p>
        <a href="about.php" class="btn-hero">Afla mai multe</a>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </button>
</div>
<div class="content-sections">
    <div class="container">
        <h2 class="text-center mb-4">De ce să alegi restaurantul nostru?</h2>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card p-3">
                    <h4 class="card-title">Ingrediente proaspete</h4>
                    <p>Folosim doar ingrediente proaspete și autentice, selectate cu grijă.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card p-3">
                    <h4 class="card-title">Livrare rapidă</h4>
                    <p>Comandă online și livrează direct la ușa ta, simplu și rapid.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card p-3">
                    <h4 class="card-title">Rețete tradiționale</h4>
                    <p>Rețete transmise din generație în generație, respectând gustul tradițional.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.about-section {
    background: #fdfdfd;
    padding:50px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}
.about-section h2 {
    font-size:2.5rem;
    margin-bottom:30px;
    text-align:center;
}
.about-section img {
    max-width:100%;
    border-radius:10px;
    margin-bottom:20px;
}
</style>

<div class="about-section">
    <h2>Despre noi</h2>
    <p>Sabaya Yemeni Kitchen a luat naștere din dorința de a aduce aromele autentice ale bucătăriei yemeni direct în inima Brașovului. Înființat în 2024 de către doi prieteni pasionați de gastronomie și călătorii, restaurantul nostru își propune să fie o poartă culinară către Orientul Mijlociu, chiar la poalele Tâmpei.</p>


    <p>Povestea a început atunci când fondatorii, Amir și Radu, au călătorit în Yemen și au descoperit gustul inconfundabil al preparatelor tradiționale: Mandi, Haneeth și Saltah. Încântați de combinația de mirodenii, arome și texturi, s-au întors în România cu ideea de a aduce aceste rețete unice acasă. Au ales Brașovul, oraș cunoscut pentru diversitatea culinară și atmosfera sa cosmopolită, fiind convinși că locuitorii și turiștii vor îmbrățișa cu entuziasm această noutate.</p>

    <p>Folosim ingrediente proaspete, atent selecționate, iar echipa noastră de bucătari, instruită să respecte rețetele tradiționale, reușește să recreeze gustul autentic al preparatelor yemeni. Decorul restaurantului nostru îmbină elemente moderne cu accente orientale: lampadare cu modele geometrice, țesături colorate și motive arabe, creând o ambianță confortabilă și primitoare.</p>


    <p>Fie că ești la prima întâlnire cu bucătăria yemeni sau ești un cunoscător al aromelor orientale, meniul nostru diversificat - de la preparate cu carne fragedă și orez aromat la deserturi dulci și băuturi parfumate - te va cuceri. Oferim servicii de livrare rapidă în tot Brașovul, astfel încât poți savura preparatele noastre acasă, cu familia sau prietenii.</p>

    <p>Sabaya Yemeni Kitchen este mai mult decât un simplu restaurant - este un loc în care cultura și gastronomia se întâlnesc pentru a crea o experiență culinară de neuitat. Te așteptăm cu drag să descoperi gusturile bogate și autentice ale Yemenului, chiar aici, în inima Brașovului.</p>
</div>
<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'ro', 
      includedLanguages: 'en,ro,fr,it,es,ar', 
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
  }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<?php include 'footer.php'; ?>
