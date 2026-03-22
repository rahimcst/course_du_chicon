document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registrationForm");

    form.addEventListener("submit", function (event) {
        let hasErrors = false;

        // Liste des champs obligatoires
        const fields = ["nom", "prenom", "dateNaissance", "adresse", "course", "email", "password"];

        fields.forEach(id => {
            const input = document.getElementById(id);
            const errorElement = document.getElementById(id + "Error");

            if (!input.value.trim() || (id === "course" && input.value === "Sélectionner la course")) {
                errorElement.textContent = "Ce champ est obligatoire";
                hasErrors = true;
            } else {
                errorElement.textContent = "";
            }

            // Supprimer l'erreur dès que l'utilisateur corrige
            input.addEventListener("input", () => {
                errorElement.textContent = "";
            });
        });

        // Vérification de l'email
        const email = document.getElementById("email").value.trim();
        const emailError = document.getElementById("emailError");
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (!emailPattern.test(email)) {
            emailError.textContent = "L'email n'est pas valide.";
            hasErrors = true;
        } else {
            emailError.textContent = "";
        }

        // Vérification du mot de passe
        const password = document.getElementById("password").value.trim();
        const passwordError = document.getElementById("passwordError");
        const passwordPattern = /^(?=.*\d)(?=.*[@$!%*?&]).{6,}$/;

        if (!passwordPattern.test(password)) {
            passwordError.textContent = "Le mot de passe doit contenir au moins 6 caractères, un chiffre et un caractère spécial.";
            hasErrors = true;
        } else {
            passwordError.textContent = "";
        }

        // Supprimer l'erreur dès que l'utilisateur corrige le mot de passe
        document.getElementById("password").addEventListener("input", () => {
            passwordError.textContent = "";
        });

        // Si des erreurs sont présentes, empêcher l'envoi
        if (hasErrors) {
            event.preventDefault();
        }
    });
});
