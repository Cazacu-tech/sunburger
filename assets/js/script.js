const appHeight = () => {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
}
window.addEventListener('resize', appHeight);
appHeight();

// const navBar = document.getElementById('navbarNav');
const icons = document.querySelectorAll('.menu-btn');
icons.forEach (icon => {
  icon.addEventListener('click', (event) => {
    icon.classList.toggle("open");
  });
});
// const buttonModi = document.querySelectorAll('.modifier');

// buttonModi.forEach (button => {
//   button.addEventListener('click', (event) => {
//     button.classList.add("show");
//     console.log(button);
//   });
// });

// console.log(buttonModi);



$(document).ready(() => {
  $("#main").click(function(){
    $("#navbarNav").animate({
      height: 'toggle'
    });
  });
});

$(window).on("resize", () => {
  if (window.innerWidth < 767) {
      $("#navbarNav").css('display', 'none');
  }
  else{
    $("#main").removeClass("open");
    $("#navbarNav").css('display', 'flex');
  }
  if (window.innerWidth < 320) {
    $("#main").removeClass("menu-bt-burger");
    $("#navbarNav").css('display', 'none');
  }
});




// $(document).ready(() => {
//   $("#main").click(function() {
//       $("this").toggleClass("open");
//       $("#navbarNav").slideToggle();
//   });
// });


// $(document).ready(() => {
//   $("#main").click(function() {
//     $(this).toggleClass("open");
//     $("#navbarNav").slideToggle();
//   });
// });
// $(document).ready(() => {
//   $("#main").click(function() {
//     if ($(this).hasClass("open")) {
//       $(this).removeClass("open");
//       $("nav #navbarNav").slideUp();
//     } else {
//       $(this).addClass("open");
//       $("nav #navbarNav").slideDown();
//     }
//   });
// });
// $(document).ready(function(){
//   //
//     $("#boutonSupprimer").click(function(){
//   //  la méthode slideToggle() affichera ou masquera l'id navbarNav avec un mouvement coulissant grâce à la méthode click
//       $("#modalSup").fadeToggle();
//     });
// });

// const bouttonMod = document.getElementById("boutonSupprimer");

// document.addEventListener('click', function () {
//   document.getElementById("modalSup").style.display = 'block';
// });

// const buttonModif = document.getElementById('modifier');
// let fullscreenmenu = document.getElementById('fullscreenmenu');
// let openNav = 0;
// buttonModif.addEventListener('click', function() {
//   if (openNav == 0) {
//     // fullscreenmenu.classList.toggle("show");
//     fullscreenmenu.style.display='block';
//     openNav = 1;
//   }
//   else {
//     fullscreenmenu.style.display='none';
//     openNav = 0;
//   }
// });
// console.log(fullscreenmenu);

// let fullscreenmenu = document.getElementById('fullscreenmenu');
// let butModif = document.getElementById('modifier');
// butModif.addEventListener('click', function () {
// 	fullscreenmenu.classList.add('show');
// });
// console.log(butModif);

// document.getElementById('close').addEventListener('click', function (event) {
// 	console.log('ferme');
// 	document.body.classList.remove('hamburger-affiche');
// });
function affMenu(cont) {
  $("#fullscreenmenu-".cont).css("display","none");
  console.log(cont);
}