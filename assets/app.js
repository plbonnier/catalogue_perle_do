import './styles/app.css';

import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

document.addEventListener('DOMContentLoaded', () => {
    const images = document.querySelectorAll('.card-product');

    // Ajoute des gestionnaires d'événements pour chaque image
    images.forEach(image => {
        image.addEventListener('mouseover', function() {
            image.style.transition = 'transform 0.3s ease-in-out';
            image.style.transform = 'scale(1.1)'; // Agrandit l'image lors du survol
        });

        image.addEventListener('mouseout', function() {
            image.style.transform = 'scale(1)'; // Réinitialise la taille de l'image lors de la sortie
        });
    });

    // Ajoute un gestionnaire d'événements pour chaque image
    const images2 = document.querySelectorAll('.images2');
    const bigImage = document.querySelector('.big-image');

    images2.forEach(image => {
        image.addEventListener('click', function() {
            const src = image.getAttribute('src');
            bigImage.setAttribute('src', src);
        });
    });
});