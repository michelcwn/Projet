// la clé de l'API : 23d50929d575f58449bb2e4334cfd3af


// on récupère l'url
// q pour la ville qu'on met Saint-Denis,RE
// appid pour la clé
// units qu'on spécifie en celsius
const url = 'https://api.openweathermap.org/data/2.5/weather?q=Saint-Denis,RE&appid=23d50929d575f58449bb2e4334cfd3af&units=metric&lang=fr';

// on créer une requête dans laquelle on va créer un nouvel objet
// XMLHttpRequest va servir à nos requêtes avec des propriétés
let query = new XMLHttpRequest();

// on ouvre notre requête avec "open"
// la première valeur est GET ou POST
// méthode GET car on passe des infos dans l'url
// 2e paramètre c'est l'url qu'on a mis dans une constante
query.open('GET', url);

// on précise qu'on attend du "json"
query.responseType='json';

// on envoie notre requête
query.send();

// quand on reçoit une réponse à la requête, on exécute une fonction
// quand notre requête est chargée, on exécute une fonctionne anonyme
query.onload = function() {

    // on vérifie que la requête est bien terminé, 
    // donc que l'API ne continue pas de nous envoyer des infos.
    // on vérifie l'état de notre requête, ie lorsque la requête est terminée
    // === pour vérifier que la valeur et le type correspondent
    if(query.readyState === XMLHttpRequest.DONE) {

        // 200 est un code d'erreur
        // on verifie que tout se passe bien
        if(query.status === 200) {

            // on stock la réponse de notre API
            let answer = query.response;
            
            // on recupère la temperature
            let temperature = answer.main.temp;

            // on recupère la ville
            let city = answer.name;

            // on récupère la description
            let description = answer.weather[0].description;
            
            document.getElementById('temperature__label').textContent = temperature + " °C";
            document.getElementById('city').textContent = city;
            document.getElementById('city__description').textContent = description;
        }
        else {
            alert('Un problème est survenu');
        }
    }
}