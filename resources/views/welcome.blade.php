<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome - Mastermind Academy MBC</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon_clean.ico') }}">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: row;
    }

    .left-panel, .right-panel {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }

    .left-panel {
      background: linear-gradient(135deg, #2980b9, #27ae60);
      color: white;
      flex-direction: column;
      text-align: center;
    }

    .right-panel {
      background: #fff;
      color: #333;
      text-align: center;
      flex-direction: column;
    }

    .logo {
      width: 200px;
      margin-bottom: 20px;
    }

    h1 {
      font-size: 28px;
      margin: 10px 0;
    }

    h2 {
      font-size: 18px;
      margin-bottom: 30px;
      color: #eee;
    }

    .btn {
      padding: 12px 20px;
      margin: 10px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      background: #8e44ad;
      color: white;
      transition: 0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .btn:hover {
      opacity: 0.9;
    }

    /* Animasi teks berjalan */
    .typing {
      font-size: 20px;
      font-weight: bold;
      border-right: 2px solid white;
      white-space: nowrap;
      overflow: hidden;
      width: 0;
      animation: typing 4s steps(40, end) forwards,
                 blink .8s infinite;
    }

    @keyframes typing {
      from { width: 0 }
      to { width: 100% }
    }
    @keyframes blink {
      0%, 100% { border-color: transparent }
      50% { border-color: white }
    }

    /* Logo */
     .logo-circle {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: white; /* bisa diganti #f9f9f9 atau transparan */
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    margin: 0 auto 15px auto;
  }

  .logo-circle .logo {
    max-width: 80%;
    max-height: 80%;
    object-fit: contain;


  }

  

    /* Carousel */
    .carousel {
      position: relative;
      width: 100%;
      max-width: 500px;
      overflow: hidden;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .carousel img {
      width: 100%;
      display: none;
    }

    .carousel img.active {
      display: block;
      animation: fade 1s;
    }

    @keyframes fade {
      from { opacity: 0.4 }
      to { opacity: 1 }
    }

    /* Responsive */
    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }
      .left-panel, .right-panel {
        width: 100%;
        padding: 20px;
      }
      h1 { font-size: 22px; }
      h2 { font-size: 14px; }
      .typing { font-size: 16px; }
    }
  </style>
</head>
<body>
  <!-- Panel Kiri (Welcome Text + Button) -->
  <div class="left-panel">
 <div class="logo-circle">
  <img src="{{ asset('img/mma.png') }}" alt="Logo Mastermind Academy" class="logo">
</div>
    <h1>Selamat Datang di <br> Mastermind Academy MBC</h1>
    <h2>Growth Management System</h2>

    <div class="typing">Membantu pengusaha Muslim untuk naik kelas </div>

    <div style="margin-top: 30px;">
      <a href="{{ route('login') }}" class="btn">Login</a>
      <a href="{{ route('register') }}" class="btn">Register</a>
    </div>
  </div>

  <!-- Panel Kanan (Foto-foto carousel) -->
  <div class="right-panel">
    <div class="carousel">
      <img src="{{ asset('img/gp11.jpg') }}" alt="Kegiatan 1" class="active">
      <img src="{{ asset('img/gp12.jpg') }}" alt="Kegiatan 2">
      <img src="{{ asset('img/gp13.jpg') }}" alt="Kegiatan 3">
    </div>
    <p style="margin-top: 20px; font-style: italic;">“Bersama-sama tumbuh, berilmu, bertauhid, bermental juang.”</p>
  </div>

  <script>
    // Carousel otomatis
    let currentIndex = 0;
    const images = document.querySelectorAll(".carousel img");

    setInterval(() => {
      images[currentIndex].classList.remove("active");
      currentIndex = (currentIndex + 1) % images.length;
      images[currentIndex].classList.add("active");
    }, 3000);
  </script>
</body>
</html>
