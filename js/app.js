$(function () {
  var current = 0;

  var phases = [
    [28,  16],
    [52,  24],
    [74,  30],
    [91,  38],
    [100, 12]
  ];

  function animateTo(target, delay, done) {
    function step() {
      if (current < target) {
        current++;
        $('.loader-bar-fill').css('width', current + '%');
        $('.loader-percent').text(current + '%');
        setTimeout(step, delay);
      } else {
        done && done();
      }
    }
    step();
  }

  function runPhases(i) {
    if (i >= phases.length) {
      $('.loader-percent').addClass('done');
      setTimeout(function () {
        $('#loader').addClass('hide');
        setTimeout(function () {
          $('#loader').hide();
          $('#content').addClass('visible');

          // ✅ Initialize AOS HERE after loader is fully gone
          // ✅ Remove "aos-animate" class from all elements so they re-animate
$('[data-aos]').removeClass('aos-animate');

AOS.init({
  duration: 800,
  offset: 100
});

AOS.refresh();

        }, 700);
      }, 350);
      return;
    }
    animateTo(phases[i][0], phases[i][1], function () {
      setTimeout(function () { runPhases(i + 1); }, 100);
    });
  }

  setTimeout(function () { runPhases(0); }, 250);
});