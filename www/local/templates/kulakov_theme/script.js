/* =========================================================
   Canvas — анимированный фон
========================================================= */
(function () {
  var canvas = document.getElementById('bgCanvas');
  if (!canvas) return;
  var ctx = canvas.getContext('2d');

  function resize() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  resize();
  window.addEventListener('resize', resize);

  var dots = [];
  for (var i = 0; i < 70; i++) {
    dots.push({
      x:  Math.random() * canvas.width,
      y:  Math.random() * canvas.height,
      r:  Math.random() * 1.4 + 0.4,
      vx: (Math.random() - 0.5) * 0.25,
      vy: (Math.random() - 0.5) * 0.25,
      a:  Math.random() * 0.07 + 0.025
    });
  }

  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    dots.forEach(function (d) {
      ctx.beginPath();
      ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(0,0,0,' + d.a + ')';
      ctx.fill();
      d.x += d.vx; d.y += d.vy;
      if (d.x < 0) d.x = canvas.width;
      if (d.x > canvas.width)  d.x = 0;
      if (d.y < 0) d.y = canvas.height;
      if (d.y > canvas.height) d.y = 0;
    });
    requestAnimationFrame(draw);
  }
  draw();
}());

/* =========================================================
   jQuery — мобильное меню
========================================================= */
$(document).ready(function () {

  // Бургер-меню
  $('#burgerBtn').click(function () {
    $('#sidebar').toggleClass('sidebar-open');
    $('#overlay').toggle();
  });

  $('#overlay').click(function () {
    $('#sidebar').removeClass('sidebar-open');
    $(this).hide();
  });

  // Подсветка активного пункта меню по текущему URL
  var path = window.location.pathname;
  $('#navList .nav-link').each(function () {
    var href = $(this).attr('href');
    if (href === '/' && path === '/') {
      $(this).addClass('active');
    } else if (href !== '/' && path.indexOf(href) === 0) {
      $(this).addClass('active');
    }
  });

});
