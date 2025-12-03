document.addEventListener("DOMContentLoaded", () => {
  const bienvenue = document.querySelector(".bienvenue");

  // 🔹 Animation d’entrée
  requestAnimationFrame(() => {
    bienvenue.classList.add("active");
  });

  /* ==========================
     🔹 0. MISE À JOUR CONTACTS
     ========================== */
  async function mettreAJourContacts() {
    try {
      const response = await fetch("compter_contacts.php");
      const data = await response.json();
      const h2 = document.getElementById("mes-contacts");
      if (h2) h2.textContent = `Mes contacts ${data.total}`;
    } catch (error) {
      console.error("Erreur mise à jour contacts:", error);
    }
  }

  /* ==========================
     🔹 1. GESTION DES MODALES
     ========================== */
  document.addEventListener("click", (e) => {
    const bouton = e.target.closest("button[data-modal]");
    if (bouton) {
      const id = bouton.dataset.modal;
      const modal = document.getElementById(id);
      if (modal) modal.style.display = "flex";
    }

    if (e.target.matches(".fermer")) {
      const modal = e.target.closest(".modal");
      if (modal) modal.style.display = "none";
    }

    if (e.target.classList.contains("modal")) {
      const modal = e.target.closest(".modal");
      if (modal) modal.style.display = "none";
    }
  });

  /* ===================================
     🔹 2. FONCTION GÉNÉRIQUE FORMULAIRE AJAX
     =================================== */
  async function envoyerFormulaire(
    form,
    url,
    messageModalId,
    reloadAfterSuccess = false
  ) {
    const messageModal = document.getElementById(messageModalId);
    const messageContent = messageModal.querySelector(".modal-content");
    const formData = new FormData(form);

    try {
      const response = await fetch(url, { method: "POST", body: formData });
      const data = await response.json();

      messageContent.textContent = data.message || "Opération réussie";
      messageContent.style.color = data.success ? "white" : "red";
      messageModal.style.display = "flex";

      setTimeout(() => {
        messageModal.style.display = "none";

        // 🔹 Redirection ou mise à jour immédiate
        if (data.success && data.redirect) {
          window.location.href = data.redirect;
        } else if (data.success && reloadAfterSuccess) {
          // 🔸 Mise à jour instantanée des contacts
          mettreAJourContacts();
        }
      }, 1500);
    } catch (err) {
      messageContent.textContent = "Erreur réseau ou serveur";
      messageContent.style.color = "red";
      messageModal.style.display = "flex";
      setTimeout(() => {
        messageModal.style.display = "none";
      }, 2000);
    }
  }

  /* =====================================
     🔹 3. GESTION DES FORMULAIRES CONTACT
     ===================================== */
  

  const formsConnexion = document.querySelectorAll(".form_connexion");
  formsConnexion.forEach((form) => {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      envoyerFormulaire(
        form,
        "traitement_connexion.php",
        "message_connexion",
        true
      );
    });
  });

  const formsCompte = document.querySelectorAll(".form_creer_compte");
  formsCompte.forEach((form) => {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      envoyerFormulaire(form, "traitement_creer_compte.php", "message_compte", true);
    });
  });
  const formsTechnicien = document.querySelectorAll(".form_technicien");
  formsTechnicien.forEach((form) => {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      envoyerFormulaire(form, "traitement_technicien.php", "message_technicien", true);
    });
  });

  const formsPublication = document.querySelectorAll(".form_publication");
  formsPublication.forEach((form) => {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      envoyerFormulaire(
        form,
        "traitement_publication.php",
        "message_publication",
        true
      );
    });
  });

  const formsCreerCompte = document.querySelectorAll(".form3");
  formsCreerCompte.forEach((form) => {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      envoyerFormulaire(form, "traitement.php", "message_compte", true);
    });
  });

 

  /* ===========================
     🔹 4. ENVOI DES MESSAGES
     =========================== */
  const form = document.getElementById("formulaire2");
  const envoyer = document.getElementById("envoyer");
  const message = document.getElementById("message");

  if (form && envoyer && message) {
    form.addEventListener("submit", (e) => e.preventDefault());

    envoyer.addEventListener("click", async (e) => {
      e.preventDefault();
      const texteMessage = message.value.trim();
      if (!texteMessage) return;

      const formData = new FormData(form);
      try {
        const response = await fetch("pop.php", {
          method: "POST",
          body: formData,
        });
        const data = await response.json();
        console.log(data);
        message.value = "";
        message.focus();
        chargerMessages();
      } catch (error) {
        console.error("Erreur d'envoi:", error);
      }
    });
  }

  async function chargerMessages() {
    const id = new URLSearchParams(window.location.search).get("id");
    try {
      const response = await fetch("envoie.php?id=" + id + "&t=" + Date.now());
      const html = await response.text();
      const zone = document.getElementById("zone-de-texte");
      if (zone) {
        zone.innerHTML = html;
        zone.scrollTop = zone.scrollHeight;
      }
    } catch (error) {
      console.error("Erreur chargement messages:", error);
    }
  }

  setInterval(chargerMessages, 3000);
  chargerMessages();

  /* ===========================
  /* ===========================
   🔹 5. BARRE DE RECHERCHE
   =========================== */
  function initialiserRecherche(
    inputId,
    suggestionId,
    buttonId,
    urlTraitement,
    paramName = "recherche"
  ) {
    const champ = document.getElementById(inputId);
    const suggestion = document.getElementById(suggestionId);
    const boutonChercher = document.getElementById(buttonId);
    const main = document.querySelector("main");

    if (!champ || !suggestion || !boutonChercher) return;

    // 🔹 Crée un seul bouton de suppression s’il n’existe pas déjà
    let clearBtn = champ.nextElementSibling;
    if (!clearBtn || !clearBtn.classList.contains("clear-btn")) {
      clearBtn = document.createElement("span");
      clearBtn.innerHTML = "&times;";
      clearBtn.className = "clear-btn";
      clearBtn.style.cursor = "pointer";
      clearBtn.style.marginLeft = "8px";
      clearBtn.style.fontSize = "20px";
      clearBtn.style.display = "none";
      champ.insertAdjacentElement("afterend", clearBtn);
    }

    // 🔹 Effacer le champ
    clearBtn.addEventListener("click", () => {
      champ.value = "";
      suggestion.innerHTML = "";
      suggestion.style.display = "none";
      clearBtn.style.display = "none";
      afficherTousLesUsers();
      champ.focus();
    });

    async function lancerRecherche() {
      const recherche = champ.value.trim();

      // 🔹 Affiche ou cache le bouton selon le contenu du champ
      clearBtn.style.display = recherche ? "inline" : "none";

      if (!recherche) {
        suggestion.style.display = "none";
        suggestion.innerHTML = "";
        afficherTousLesUsers();
        return;
      }

      try {
        const response = await fetch(urlTraitement, {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: new URLSearchParams({ [paramName]: recherche }),
        });

        const data = await response.json();
        suggestion.innerHTML = "";

        if (Array.isArray(data) && data.length > 0) {
          suggestion.style.display = "block";
          data.forEach((item) => {
            const texte = document.createElement("p");
            texte.className = "suggestion";
            texte.textContent = `${item.nom} ${item.prenom}`;
            texte.addEventListener("click", async () => {
              champ.value = `${item.nom} ${item.prenom}`;
              suggestion.style.display = "none";
              await afficherUsersFiltres(item.nom, item.prenom);
              clearBtn.style.display = "inline"; // Garde le bouton visible
            });
            suggestion.appendChild(texte);
          });
        } else {
          suggestion.style.display = "block";
          suggestion.innerHTML =
            '<p class="aucun-contact">Aucun contact trouvé.</p>';
        }
      } catch (error) {
        console.error("Erreur recherche:", error);
      }
    }

    async function afficherUsersFiltres(nom, prenom) {
      try {
        const response = await fetch(urlTraitement, {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: new URLSearchParams({ [paramName]: nom, prenom }),
        });
        const data = await response.json();

        document.querySelectorAll(".profil").forEach((p) => p.remove());

        data.forEach((user) => {
          const div = document.createElement("div");
          div.className = "profil";
          div.innerHTML = `
                    <a href="profil.php?id=${user.id_utilisateur}" class="liens_profil">
                        <img src="${user.photo}" alt="">
                        <p><b>${user.nom} ${user.prenom}</b></p>
                    </a>
                    <a href="#" data-supprimer="${user.id_utilisateur}"><div class="del"></div></a>
                `;
          main.appendChild(div);
        });
      } catch (error) {
        console.error("Erreur affichage users filtrés:", error);
      }
    }

    function afficherTousLesUsers() {
      window.location.reload();
    }

    champ.addEventListener("input", lancerRecherche);
    boutonChercher.addEventListener("click", lancerRecherche);

    document.addEventListener("click", (e) => {
      if (!champ.contains(e.target) && !suggestion.contains(e.target)) {
        suggestion.style.display = "none";
      }
    });
  }

  // ✅ Initialisation
  initialiserRecherche(
    "texte",
    "suggestion",
    "chercher",
    "recherche.php",
    "recherche"
  );

  /* ===========================
     🔹 6. SUPPRESSION CONTACTS
     =========================== */
  document.addEventListener("click", (e) => {
    const lien = e.target.closest("a[data-supprimer]");
    if (!lien) return;

    e.preventDefault();
    const id = lien.dataset.supprimer;

    fetch(`supprimer_contact.php?id=${id}`)
      .then((res) => res.json())
      .then((data) => {
        lien.closest(".profil").remove();
        mettreAJourContacts(); // 🔹 mise à jour instantanée
      })
      .catch((err) => console.error(err));
  });

  const nav = document.querySelector('.nav-page');
  let lastScroll = 0; // position précédente

window.addEventListener("scroll", function () {
    let currentScroll = window.scrollY; // position actuelle du scroll

    if (currentScroll > lastScroll) {
        // 👉 L'utilisateur scroll vers le bas
        console.log("Scroll vers le bas");
      nav.style.display = 'none';
        // Exemple : masquer un élément
        // document.querySelector(".header").style.top = "-80px";
    } else {
        // 👉 L'utilisateur scroll vers le haut
      console.log("Scroll vers le haut");
       nav.style.display = 'flex';

        // Exemple : afficher un élément
        // document.querySelector(".header").style.top = "0";
    }

    lastScroll = currentScroll; // mise à jour pour la prochaine comparaison
});

});
