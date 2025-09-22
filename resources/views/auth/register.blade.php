<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mastermind Academy MBC - Register</title>
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
    background: #fff;
    color: #333;
    flex-direction: column;
  }

  .right-panel {
    background: linear-gradient(135deg, #8e44ad, #2980b9);
    color: white;
    text-align: center;
    flex-direction: column;
    justify-content: flex-start;
  }

  .register-box {
    width: 100%;
    max-width: 400px;
    text-align: center;
  }

  .logo {
    width: 180px;
    margin-bottom: 10px;
  }

  h1 { margin: 10px 0 5px; font-size: 20px; }
  h2 { font-size: 14px; margin-bottom: 20px; color: #666; }

  input {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
  }

  .btn {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    background: #27ae60;
    color: white;
    transition: 0.3s;
  }

  .btn:hover { opacity: 0.9; }

  .kelas-img {
    max-width: 100%;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    margin-bottom: 10px;
  }

  .quote-box { max-width: 500px; margin-top: 20px; }
  .quote { font-size: 18px; font-style: italic; margin-bottom: 10px; }
  .quote-author { font-weight: bold; }

  .login-link {
    display: block;
    margin-top: 12px;
    font-size: 13px;
    color: #2980b9;
    text-decoration: none;
    transition: 0.2s;
  }

  .login-link:hover { text-decoration: underline; color: #1a5276; }

  /* RESPONSIVE MOBILE */
  @media (max-width: 768px) {
    body {
      flex-direction: column;
    }
    .left-panel, .right-panel {
      width: 100%;
      padding: 20px;
    }
    .kelas-img {
      max-height: 250px;
    }
    h1 { font-size: 18px; }
    h2 { font-size: 12px; }
    .quote { font-size: 16px; }
  }
</style>

</head>
<body>
  <!-- Panel Kiri (Form Register) -->
  <div class="left-panel">
    <div class="register-box">
      <img src="{{ asset('img/mma.png') }}" alt="Logo Mastermind Academy" class="logo">
      <h1>Daftar Akun Baru</h1>
      <h2>Mastermind Academy MBC</h2>

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <input id="name" type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
      @error('name') <small style="color:red">{{ $message }}</small> @enderror

      <input id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
      @error('email') <small style="color:red">{{ $message }}</small> @enderror

      <input id="password" type="password" name="password" placeholder="Password" required>
      @error('password') <small style="color:red">{{ $message }}</small> @enderror

      <input id="password-confirm" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>

      <!-- Omset -->
      <select id="omset" name="omset" class="form-control" required>
          <option value="">-- Pilih Omset --</option>
          <option value="0-100">0 - 100 Juta</option>
          <option value="100-300">100 - 300 Juta</option>
          <option value="300-500">300 - 500 Juta</option>
          <option value="500-1000">500 Juta - 1 M</option>
          <option value="1000-up">> 1 M</option>
      </select>

      <!-- Keterangan Level -->
      <input type="text" id="level_text" class="form-control" placeholder="Level" readonly>
      <input type="hidden" name="level" id="level">

      <!-- No. WA -->
      <input type="text" name="wa" placeholder="Nomor WhatsApp" value="{{ old('wa') }}" required>

      <!-- Provinsi -->
      <select id="provinsi" name="provinsi" class="form-control" required>
          <option value="">-- Pilih Provinsi --</option>
          <option value="Jawa Barat">Jawa Barat</option>
          <option value="Jawa Tengah">Jawa Tengah</option>
          <option value="Jawa Timur">Jawa Timur</option>
          <option value="DKI Jakarta">DKI Jakarta</option>
          <option value="DI Yogyakarta">DI Yogyakarta</option>
      </select>

      <!-- Kota -->
      <select name="kota" id="kota" class="form-control" required>
          <option value="">-- Pilih Kota --</option>
      </select>

      <button type="submit" class="btn">Register</button>
      <a href="{{ route('login') }}" class="login-link">Sudah punya akun? Login di sini</a>
  </form>

      </div>
    </div>

    <!-- Panel Kanan (Foto + Quote) -->
    <div class="right-panel">
      <img src="{{ asset('img/gp11.jpg') }}" alt="Foto Kelas Mastermind" class="kelas-img">

      <div class="quote-box">
        <div class="quote">“Bersama-sama tumbuh, melahirkan pengusaha Muslim langit yang bermental juang.”</div>
        <div class="quote-author">– Mastermind Academy</div>
      </div>
    </div>
  </body>
  </html>
  <script>
  document.getElementById('omset').addEventListener('change', function() {
      let val = this.value;
      let level = '';
      switch (val) {
          case '0-100': level = 'Start-Up 🚀'; break;
          case '100-300': level = 'Stand-Up 💪'; break;
          case '300-500': level = 'Step-Up 📈'; break;
          case '500-1000': level = 'Grow-Up 🌱'; break;
          case '1000-up': level = 'Scale-Up 🌍'; break;
      }
      document.getElementById('level_text').value = level;
      document.getElementById('level').value = level;
  });

const kotaByProvinsi = {
    "Jawa Barat": ["Bandung", "Bogor", "Depok", "Bekasi", "Cirebon"],
    "Jawa Tengah": ["Semarang", "Solo", "Magelang", "Purwokerto", "Tegal"],
    "Jawa Timur": ["Surabaya", "Malang", "Kediri", "Madiun", "Jember"],
    "DKI Jakarta": ["Jakarta Selatan", "Jakarta Timur", "Jakarta Barat", "Jakarta Utara", "Jakarta Pusat"],
    "DI Yogyakarta": ["Kota Yogyakarta", "Sleman", "Bantul", "Gunung Kidul", "Kulon Progo"]
};

document.getElementById('provinsi').addEventListener('change', function() {
    let provinsi = this.value;
    let kotaSelect = document.getElementById('kota');
    kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
    if (provinsi && kotaByProvinsi[provinsi]) {
        kotaByProvinsi[provinsi].forEach(kota => {
            let option = document.createElement('option');
            option.value = kota;
            option.textContent = kota;
            kotaSelect.appendChild(option);
        });
    }
});
</script>
