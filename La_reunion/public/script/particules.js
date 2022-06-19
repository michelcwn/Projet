// on selectionne notre canvas
const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');
ctx.canvas.width = window.innerWidth;
ctx.canvas.height = window.innerHeight;

// on crée un tableau pour mettre des particules
let particuleTab;

// on crée une class
class Particule {
    // constructor va gérer les propriétés crées dans l'objet avec la class
    constructor(x, y, directionX, directionY, taille, couleur) {
        // on va lier ces paramètres avec des this.
        this.x = x;
        this.y = y;
        this.directionX = directionX;
        this.directionY = directionY;
        this.taille = taille;
        this.couleur = couleur;
    }
    // on créer une méthode
    dessine() {
        // on va créer des cercles
        ctx.beginPath();
        // false pour le sens horaire ou antihoraire
        ctx.arc(this.x, this.y, this.taille, 0, Math.PI * 2, false);
        // couleur de remplissage
        ctx.fillStyle = this.couleur;
        // on le dessine, remplit
        ctx.fill();
    }
    MAJ() {
        // est ce que la position de x + sa taille est > à la largeur du canvas ?
        // ie est ce qu'elle a touché le canvas à droite
        // ou est ce qu'elle a touché à gauche
        if(this.x + this.taille > canvas.width || this.x - this.taille < 0) {
            // alors on change sa direction
            this.directionX = -this.directionX;
        }
        // on fait la meme chose sur y
        if(this.y + this.taille > canvas.height || this.y - this.taille < 0){
            this.directionY = -this.directionY;
        }

        // à chaque fois on actualise la position sur x et y
        this.x += this.directionX;
        this.y += this.directionY;
        // on dessine les elements qui ont ces positions
        this.dessine();
    }
}

// on peut créer des objets avec cette class
// const obj1 = new Particule(100, 100, 1, 1, 100, "black");
// obj1.dessine();

function init() {
    particuleTab = [];
    // on va créer 100 particules
    for(let i = 0; i < 100; i++) {
        // on évite que math.random a une valeur de 0
        let taille = (Math.random() + 0.01) * 20;
        // on va faire apparaitre sur x de maniere aleatoire, sur la fenetre de gauche a droite
        // et on enleve taille * 2 pour éviter qu'elles apparaissent sur les bordures
        let x = Math.random() * (window.innerWidth - taille * 2);
        let y = Math.random() * (window.innerHeight - taille * 2);
        // ici on cherche à avoir des chiffres positifs ou negatifs qui donner le sens
        // c'est une intervalle qui définit la vitesse de déplacement
        // on retourne des valeurs entre -0.2 et 0.2
        let directionX = (Math.random() * 0.4) - 0.2;
        let directionY = (Math.random() * 0.4) - 0.2;
        let couleur = "white";

        particuleTab.push(new Particule(x, y, directionX, directionY, taille, couleur));
    }
}

// function récursive, elle s'apelle elle-meme
function animation() {
    requestAnimationFrame(animation);
    // clearRect va nettoyer un rectangle qui par de 0 sur x et y et fera toute la largeur et hauteur
    ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
    // on vait apparaitre les elements
    for(let i = 0; i < particuleTab.length; i++) {
        particuleTab[i].MAJ();
    }
}

init();
animation();
console.log(particuleTab);
console.log(init());

// probleme d'etirement des particules quand on redimensionne le fenetre
function resize() {
    // cette fonction rappelle init et animation
    init();
    animation();
} 

// chaque fois qu'on resize l'écran on resize au bout de 0.1s
let doit;
window.addEventListener('resize', () => {
    clearTimeout(doit);
    doit = setTimeout(resize, 100);
    ctx.canvas.width = window.innerWidth;
    ctx.canvas.height = window.innerHeight;
})