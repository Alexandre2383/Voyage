$(document).ready(function() {
  // Your existing scroll event handling for the header and nav bar
  $(window).scroll(function () {
    var heroHeight = $("header").height();
    var yPosition = $(document).scrollTop();

    if (heroHeight) { // Checking if heroHeight is not null or undefined
      if (yPosition <= heroHeight) {
        var effectFactor = yPosition / heroHeight;
        var rotation =
          effectFactor *
          (Math.PI / 2 - Math.asin((heroHeight - yPosition) / heroHeight));
        $(".hero")
          .css({
            "-webkit-transform": "rotateX(" + rotation + "rad)",
            transform: "rotateX(" + rotation + "rad)"
          })
          .find(".overlay")
          .css("opacity", effectFactor);
      }
    }

    var navElement = $("nav");
    if (navElement.length > 0) { // Checking if navElement exists
      if (yPosition <= heroHeight) {
        navElement.removeClass("fixed");
      } else {
        navElement.addClass("fixed");
      }
    }
  });

  // Back to top button
  const button = document.getElementById("back-to-top-btn");

  if (button) { // Checking if button exists
    window.addEventListener("scroll", scrollFunction);

    function scrollFunction() {
      var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
      if (scrollTop > 300) {
        button.style.display = "block";
      } else {
        button.style.display = "none";
      }
    }

    button.addEventListener("click", backToTop);

    function backToTop() {
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    }
  }
});
