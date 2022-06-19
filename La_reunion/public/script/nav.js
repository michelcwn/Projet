const toggle    = document.getElementById('toggle');
const nav       = document.getElementById('nav');

toggle.addEventListener('click', () => {
    // on prend bascule la nav sur la class active
    // si elle est appliquée, elle est supprimée, vice versa
    // toutes les transitions sont appliquées
    nav.classList.toggle('active');
})