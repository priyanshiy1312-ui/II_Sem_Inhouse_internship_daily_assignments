
<?php
session_start();

if(!isset($_SESSION['user_id']))
{
header("Location: login.php");
exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BMI Calculator &mdash; Your Health Report</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="top-bar-title" >
    🩺 Welcome, <?php echo $_SESSION['user_name']; ?>
</div>


 <header class="navbar navbar-expand-lg navbar-dark bg-success px-4">

<a class="navbar-brand fw-bold" href="dashboard.php">

🩺 BMI Health

</a>





</div>
<button id="themeToggle" class="theme-toggle" aria-label="Toggle dark and light mode">
    <span class="toggle-track">
      <span class="toggle-thumb">
        <i class="fa-solid fa-sun icon-sun"></i>
        <i class="fa-solid fa-moon icon-moon"></i>
      </span>
    </span>
  </button>
<a

href="logout.php"

class="btn btn-danger" id="logout">

Logout

</a>
</header>


<div class="bg-decor" aria-hidden="true">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
</div>

<div class="container app-wrap">

  <div class="card-shell">

   
    <section id="formView" class="panel form-panel">
      <div class="form-heading text-center">
        <h1 class="app-title"><i class="fa-solid fa-calculator"></i> BMI Calculator</h1>
        <p class="app-sub">Calculate your Body Mass Index and receive personalized health suggestions.</p>
      </div>

      <form id="bmiForm" novalidate>

        <div class="mb-3">
          <label class="field-label" for="fullName"><i class="fa-solid fa-user"></i> Full Name</label>
          <input type="text" id="fullName" class="form-control field-input" placeholder="e.g. Priyanshi" required>
        </div>

        <div class="row g-3">
          <div class="col-6">
            <label class="field-label" for="age"><i class="fa-solid fa-calendar-days"></i> Age</label>
            <input type="number" id="age" class="form-control field-input" min="2" max="120" placeholder="e.g. 28" required>
          </div>
          <div class="col-6">
            <label class="field-label" for="gender"><i class="fa-solid fa-venus-mars"></i> Gender</label>
            <select id="gender" class="form-select field-input" required>
              <option value="female">Female</option>
              <option value="male">Male</option>
              <option value="other">Other</option>
            </select>
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-6">
            <label class="field-label" for="heightCm"><i class="fa-solid fa-arrows-up-down"></i> Height (cm)</label>
            <input type="number" step="0.1" id="heightCm" class="form-control field-input" placeholder="e.g. 170" required>
          </div>
          <div class="col-6">
            <label class="field-label" for="weightKg"><i class="fa-solid fa-weight-scale"></i> Weight (kg)</label>
            <input type="number" step="0.1" id="weightKg" class="form-control field-input" placeholder="e.g. 65" required>
          </div>
        </div>

        <div id="formError" class="form-error d-none mt-3"></div>

        <button type="submit" class="btn btn-primary-brand w-100 mt-4" id="calcBtn">
          <i class="fa-solid fa-calculator"></i>
          <span class="btn-label">Calculate BMI</span>
        </button>
      </form>
    </section>

  
    <section id="resultView" class="panel result-panel d-none">

      <div class="text-center result-heading">
        <h1 class="app-title"><span id="greetEmoji">😊</span> Your BMI Report</h1>
        <p class="hello-line">Hello, <strong id="greetName">there</strong></p>
      </div>

      <div class="gauge-wrap">
        <svg viewBox="0 0 220 130" class="gauge-svg">
          <path d="M 20 110 A 90 90 0 0 1 51 36" class="gauge-seg seg-under"></path>
          <path d="M 51 36 A 90 90 0 0 1 110 20" class="gauge-seg seg-normal-a"></path>
          <path d="M 110 20 A 90 90 0 0 1 169 36" class="gauge-seg seg-normal-b"></path>
          <path d="M 169 36 A 90 90 0 0 1 200 110" class="gauge-seg seg-over"></path>
          <line id="needle" x1="110" y1="110" x2="110" y2="30" class="gauge-needle"></line>
          <circle cx="110" cy="110" r="7" class="gauge-hub"></circle>
        </svg>
        <div class="gauge-readout">
          <span id="bmiValue" class="bmi-value">0.0</span>
        </div>
      </div>

      <div class="text-center">
        <span id="categoryPill" class="category-pill">—</span>
      </div>

      <div class="stat-grid">
        <div class="stat-card">
          <div class="stat-icon">⚖️</div>
          <div class="stat-label">Healthy Weight</div>
          <div class="stat-value stat-green" id="healthyWeightVal">—</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">💧</div>
          <div class="stat-label">Water Intake</div>
          <div class="stat-value stat-blue" id="waterVal">—</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">🔥</div>
          <div class="stat-label">Daily Calories</div>
          <div class="stat-value stat-amber" id="caloriesVal">—</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">❤️</div>
          <div class="stat-label">Health Risk</div>
          <div class="stat-value stat-coral" id="riskVal">—</div>
        </div>
      </div>

      <div class="suggestion-block">
        <h2 class="suggestion-heading"><i class="fa-solid fa-bowl-food"></i> Diet Suggestions</h2>
        <div class="check-grid" id="dietList"></div>
      </div>

      <div class="suggestion-block">
        <h2 class="suggestion-heading"><i class="fa-solid fa-person-running"></i> Exercise Suggestions</h2>
        <div class="check-grid" id="exerciseList"></div>
      </div>

      <div class="suggestion-block">
        <h2 class="suggestion-heading"><i class="fa-solid fa-lightbulb"></i> Health Tips</h2>
        <ul class="tips-list" id="tipsList"></ul>
      </div>

      <div class="result-actions">
        <button id="shareBtn" class="btn btn-whatsapp">
          <i class="fa-solid fa-share-nodes"></i> Share Result
        </button>
        

        <button id="changeBtn" class="btn btn-outline-brand">
          <i class="fa-solid fa-rotate-left"></i> Calculate Again
        </button>
      </div>

      <div class="text-center footer-credit">
        <p class="stay-fit">💚 Stay Healthy, Stay Fit 💚</p>
        <p class="made-with">Made with ❤️ using HTML, CSS, Bootstrap, JavaScript &amp; PHP</p>
      </div>
    </section>

  </div>

  <footer class="app-footer text-center">
    <p>This tool provides general wellness information and is not a substitute for medical advice.</p>
  </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>