// La constante icons prend la méthode document.querySelectorAll() de JavaScript qui
// renvoie une liste statique (NodeList) des éléments correspondants à la class menu-btn
const icons = document.querySelectorAll('.menu-btn');
// la boucle forEach permet de créer une boucle qui itére la liste statique des éléments correspondants à la class menu-btn
icons.forEach (icon => {
// La méthode addEventListener() de JavaScript est utilisée pour attacher un gestionnaire d'événements à un élément HTML 
// qui est la class menu-btn, à cette événement, je lui attribut un événement click 
icon.addEventListener('click', () => {
// la méthode toggle() affichera ou masquera la class open
    icon.classList.toggle("open");
  });
});

// la méthode ready methode qui va être va systématiquement appliquer est elle meme un evenement, c'est la methode ou l'évenement ready. C'est le gestionnaire d'événement  
$(document).ready(function(){
//
  $("#main").click(function() {
//  la méthode slideToggle() affichera ou masquera l'id navbarNav avec un mouvement coulissant grâce à la méthode click
    $("#navbarNav").slideToggle();
    });
});

window.addEventListener('scroll', function () {
	if (window.scrollY > 500) {
		document.getElementById('remonte').classList.add('affiche');
}	else {
	document.getElementById('remonte').classList.remove('affiche');
}
});

$(document).ready(function() {
  $("#top").click(function() {
    $("header").scrollTop() 
  }); // Défilement vers le haut en 1 seconde (1000 millisecondes)
});

console.log($("#head"));
console.log($("#top"));

function strVideo() {
  var maVideo = document.getElementById('mavideo');
  maVideo.play();
}
setTimeout(strVideo, 15000);


// // remonte-two
// window.addEventListener('scroll', function() {
// 	if (window.scrollY > 200) {
// 		document.getElementById('remonte').classList.add('affiche');
//   }
//   else {
//     document.getElementById('remonte').classList.remove('affiche');
//   }
// });

const appHeight = () => {
  const vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', `${vh}px`);
}
window.addEventListener('resize', appHeight);
appHeight();

const viewportHeight = window.outerHeight;
console.log(viewportHeight);
