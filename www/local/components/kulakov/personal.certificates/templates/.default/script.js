document.addEventListener("DOMContentLoaded", function () {
  var $viewer = $('#certViewer');
  if (!$viewer.length) return;

  var $thumbs = $('.cert-thumb');
  var current = 0;

  function show(index) {
    current = (index + $thumbs.length) % $thumbs.length;
    var $t = $thumbs.eq(current);
    var name = $t.data('name');
    $('#certViewerImgTag').attr({ src: $t.data('img'), alt: name });
    $('#certViewerName').text(name);
    $('#certViewerPdf').attr({ href: $t.data('file'), download: name + '.pdf' });
    $('#certViewerImg').attr({ href: $t.data('img'), download: name + '.jpg' });
  }

  function open(index) {
    show(index);
    $viewer.addClass('open').attr('aria-hidden', 'false');
    $('body').css('overflow', 'hidden');
  }

  function close() {
    $viewer.removeClass('open').attr('aria-hidden', 'true');
    $('body').css('overflow', '');
  }

  $thumbs.on('click', function () {
    open(+$(this).data('index'));
  });

  $('#certViewerClose').on('click', close);
  $('#certPrev').on('click', function () { show(current - 1); });
  $('#certNext').on('click', function () { show(current + 1); });

  $viewer.on('click', function (e) {
    if (e.target === this) close();
  });

  $(document).on('keydown', function (e) {
    if (!$viewer.hasClass('open')) return;
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft') show(current - 1);
    if (e.key === 'ArrowRight') show(current + 1);
  });
});
