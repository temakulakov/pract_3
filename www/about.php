
<body>
  <canvas id="bgCanvas"></canvas>

  <div class="about-page-wrap" style="position:relative; z-index:1;">
    <a href="index.html" class="back-link">&#8592; На главную</a>

    <div class="page-heading">
      <div class="page-icon">&#128196;</div>
      <div>
        <h1>О сайте</h1>
        <p class="page-subtitle">Практическое задание №1</p>
      </div>
    </div>

    <div class="notion-divider"></div>

    <h2>Цель работы</h2>
    <p>
      Изучить принципы проектирования статических веб-страниц,
      освоить HTML5, CSS3 и основы jQuery/jQuery UI.
    </p>

    <h2 style="margin-top:24px;">Технологии</h2>
    <ul class="notion-list">
      <li>HTML5 — семантическая разметка</li>
      <li>CSS3 — Notion-like оформление, анимации, адаптив</li>
      <li>JavaScript — SPA-навигация, Canvas-анимация</li>
      <li>jQuery 3.7 — DOM-манипуляции (13 методов)</li>
      <li>jQuery UI 1.13 — Datepicker, Dialog</li>
    </ul>

    <h2 style="margin-top:24px;">Автор</h2>
    <p>Кулаков Артем, группа Пи2у/23Б, 2026</p>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    // Canvas-фон (минимальная версия для второй страницы)
    (function () {
      var c = document.getElementById('bgCanvas'), ctx = c.getContext('2d');
      function resize() { c.width = window.innerWidth; c.height = window.innerHeight; }
      resize(); window.addEventListener('resize', resize);
      var dots = [];
      for (var i = 0; i < 50; i++) {
        dots.push({ x: Math.random()*c.width, y: Math.random()*c.height,
          r: Math.random()*1.2+0.4, vx: (Math.random()-.5)*.2, vy: (Math.random()-.5)*.2, a: Math.random()*.06+.02 });
      }
      function draw() {
        ctx.clearRect(0,0,c.width,c.height);
        dots.forEach(function(d) {
          ctx.beginPath(); ctx.arc(d.x,d.y,d.r,0,Math.PI*2);
          ctx.fillStyle='rgba(0,0,0,'+d.a+')'; ctx.fill();
          d.x+=d.vx; d.y+=d.vy;
          if(d.x<0) d.x=c.width; if(d.x>c.width) d.x=0;
          if(d.y<0) d.y=c.height; if(d.y>c.height) d.y=0;
        });
        requestAnimationFrame(draw);
      }
      draw();
    }());
  </script>
</body>
