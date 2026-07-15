(function () {
  'use strict';

  const root = document.documentElement;
  const themeToggle = document.getElementById('themeToggle');


  function safeGetTheme() {
    try { return localStorage.getItem('bmi-theme'); } catch (err) { return null; }
  }
  function safeSetTheme(value) {
    try { localStorage.setItem('bmi-theme', value); } catch (err) { /* ignore */ }
  }

  const savedTheme = safeGetTheme() ||
    (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
  root.setAttribute('data-theme', savedTheme);

  themeToggle.addEventListener('click', () => {
    const current = root.getAttribute('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    root.setAttribute('data-theme', next);
    safeSetTheme(next);
  });

 
  const form = document.getElementById('bmiForm');
  const formView = document.getElementById('formView');
  const resultView = document.getElementById('resultView');
  const formError = document.getElementById('formError');
  const calcBtn = document.getElementById('calcBtn');
  const changeBtn = document.getElementById('changeBtn');
  const shareBtn = document.getElementById('shareBtn');

  const needle = document.getElementById('needle');
  const bmiValueEl = document.getElementById('bmiValue');
  const categoryPill = document.getElementById('categoryPill');
  const greetName = document.getElementById('greetName');
  const greetEmoji = document.getElementById('greetEmoji');

  const healthyWeightVal = document.getElementById('healthyWeightVal');
  const waterVal = document.getElementById('waterVal');
  const caloriesVal = document.getElementById('caloriesVal');
  const riskVal = document.getElementById('riskVal');

  const dietList = document.getElementById('dietList');
  const exerciseList = document.getElementById('exerciseList');
  const tipsList = document.getElementById('tipsList');

  let lastResult = null;


  function showError(msg) {
    formError.textContent = msg;
    formError.classList.remove('d-none');
  }
  function clearError() {
    formError.classList.add('d-none');
    formError.textContent = '';
  }

  function bmiToAngle(bmi) {
    const clamped = Math.max(10, Math.min(40, bmi));
    const pct = (clamped - 10) / 30;
    return -90 + pct * 180;
  }

  const emojiForCategory = {
    under: '🙂', normal: '😊', over: '😐', obese: '😟'
  };

  function renderChecklist(container, items) {
    container.innerHTML = '';
    items.forEach((item, i) => {
      const div = document.createElement('div');
      div.className = 'check-item';
      div.style.animation = `fadeSlideUp .4s ${0.04 * i}s ease both`;
      div.innerHTML = `<span class="check-mark"><i class="fa-solid fa-check"></i></span><span class="check-icon">${item.icon}</span> ${item.label}`;
      container.appendChild(div);
    });
  }

  function renderResult(data) {
    lastResult = data;

    greetName.textContent = data.name;
    greetEmoji.textContent = emojiForCategory[data.categoryKey] || '😊';

    needle.style.transform = `rotate(${bmiToAngle(data.bmi)}deg)`;
    bmiValueEl.textContent = data.bmi.toFixed(1);

    categoryPill.textContent = data.category;
    categoryPill.style.color = data.color;
    categoryPill.style.borderColor = data.color;
    categoryPill.style.background = data.color + '1A';

    healthyWeightVal.textContent = `${data.minHealthy} kg - ${data.maxHealthy} kg`;
    waterVal.textContent = `${data.waterIntake} L/day`;
    caloriesVal.textContent = `${data.calories} kcal`;
    riskVal.textContent = data.healthRisk;

    renderChecklist(dietList, data.diet);
    renderChecklist(exerciseList, data.exercise);

    tipsList.innerHTML = '';
    data.tips.forEach((tip, i) => {
      const li = document.createElement('li');
      li.style.animation = `fadeSlideUp .4s ${0.04 * i}s ease both`;
      li.innerHTML = `<span class="tip-icon">${tip.icon}</span> ${tip.label}`;
      tipsList.appendChild(li);
    });

    formView.classList.add('d-none');
    resultView.classList.remove('d-none');
    resultView.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }


  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    clearError();

    const name = document.getElementById('fullName').value.trim();
    const age = parseInt(document.getElementById('age').value, 10);
    const gender = document.getElementById('gender').value;
    const weight = parseFloat(document.getElementById('weightKg').value);
    const height = parseFloat(document.getElementById('heightCm').value);

    if (!name) return showError('Please enter your name.');
    if (!age || age <= 0) return showError('Please enter a valid age.');
    if (!weight || weight <= 0) return showError('Please enter a valid weight.');
    if (!height || height <= 0) return showError('Please enter a valid height.');

    calcBtn.classList.add('is-loading');
    calcBtn.disabled = true;

    try {
      const body = new URLSearchParams({
        name, weight: weight.toFixed(2), height: height.toFixed(2),
        age: String(age), gender,
      });

      const res = await fetch('calculate.php', { method: 'POST', body });
      const data = await res.json();

      if (!res.ok || data.error) {
        showError(data.error || 'Something went wrong. Please check your inputs.');
        return;
      }
      renderResult(data);
    } catch (err) {
      showError('Could not reach the server. Please try again.');
    } finally {
      calcBtn.classList.remove('is-loading');
      calcBtn.disabled = false;
    }
  });


  changeBtn.addEventListener('click', () => {
    resultView.classList.add('d-none');
    formView.classList.remove('d-none');
    formView.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  
  shareBtn.addEventListener('click', () => {
    if (!lastResult) return;
    const d = lastResult;
    const lines = [
      `📊 *${d.name}'s BMI Report*`,
      ``,
      `BMI: ${d.bmi} (${d.category})`,
      `Healthy weight range: ${d.minHealthy} - ${d.maxHealthy} kg`,
      `Water Intake: ${d.waterIntake} L/day`,
      `Daily Calories: ${d.calories} kcal`,
      `Health Risk: ${d.healthRisk}`,
      ``,
      `💚 Stay Healthy, Stay Fit`,
    ];
    const text = encodeURIComponent(lines.join('\n'));
    window.open(`https://wa.me/?text=${text}`, '_blank');
  });
})();