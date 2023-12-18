$(window).scroll(function () {
    var heroHeight = $("header").height();
    var yPosition = $(document).scrollTop();
  
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

    /**
     * Sticky nav-bar
     */
    if (yPosition <= heroHeight) {
      $("nav").removeClass("fixed");
    } else {
      $("nav").addClass("fixed");
    }
  });
  
  // Back to top button
const button = document.getElementById("back-to-top-btn");

window.addEventListener("scroll", scrollFunction);

function scrollFunction() {
  if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
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
