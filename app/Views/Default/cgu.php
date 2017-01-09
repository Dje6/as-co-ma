<!-- PAGE DES CONDITIONS GENERALES D'UTILISATION DU SITE -->
<?php $this->layout('layout', ['title' => 'AS-CO-MA - Conditions Générales d\'utilisation']) ?>
<!-- tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_home.css'); ?>">
<?php $this->stop('main_head') ?>


<?php $this->start('main_content') ?>

<!-- BLOC DES CGU. Se déroule et se cache au click du bouton dérouler -->
<div class="row">
  <blockquote class="cgu">
    <h2 class="text-center">Présentation</h2>

    <p class="text-justify">
      Le présent document a pour objet de définir les modalités et conditions dans lesquelles nous mettons, d’une part à disposition des utilisateurs le site, et les services disponibles sur celui-ci et d’autre part, la manière par laquelle l’utilisateur accède au site et utilise ses services.

      Toute connexion au site est subordonnée au respect des présentes conditions.

      Pour l’utilisateur, le simple accès au site implique l’acceptation de l’ensemble des conditions décrites ci-après.
    </p>

      <h3><b>Propriété intellectuelle : </b></h3>
      <p class="text-justify">
        <h4><b>Equipe de Développement, Administration du site : </b><br><br>
          <p>
            - Associés Développement / Programmation Backend : SAVALLE Simon, LEROY Jessy <br>
            - Associés Développement / Intégration Frontend : BLONDEL Benoît (Front-office), DUBEC Laurent (Back-office).
          </p>
        </h4>
        La structure générale du site "AS-CO-MA" , ainsi que les textes, graphiques, images, sons et  vidéos la composant, sont la propriété de ses développeurs ou de leurs partenaires. Toute représentation et/ou reproduction et/ou exploitation partielle ou totale des contenus et services proposés par le site "AS-CO-MA" , par quelque procédé que ce soit, sans l'autorisation préalable et par écrit de  l'équipe en charge du développement est strictement interdite et serait susceptible de constituer une contrefaçon au sens des articles L 335-2 et suivants du Code de la propriété intellectuelle.
      </p>

      <h3><b>Liens hypertextes : </b></h3>
      <p class="text-justify">
        Le site  "AS-CO-MA"  peut contenir des liens hypertextes vers d’autres sites présents sur le réseau Internet. Les liens vers ces autres ressources vous font quitter le site "AS-CO-MA".

        Il est possible de créer un lien vers la page de présentation de ce site sans autorisation expresse des développeurs. Aucune autorisation ou demande d’information préalable ne peut être exigée par les développeurs à l’égard d’un site qui souhaite établir un lien vers le site. Il convient toutefois d’afficher ce site dans une nouvelle fenêtre du navigateur. Cependant, l'équipe de développement se réserve le droit de demander la suppression d’un lien qu’il estime non conforme à l’objet du site "AS-CO-MA".
      </p>

      <!-- Partie caché des cgu qui se déroule au clic -->
    <div class="cguHidden">
      <h3><b>Responsabilité des développeurs :</b></h3>
      <p class="text-justify">
        Les informations et/ou documents figurant sur ce site et/ou accessibles par ce site proviennent de sources considérées comme étant fiables.

        Toutefois, ces informations et/ou documents sont susceptibles de contenir des inexactitudes techniques et des erreurs typographiques.

        L'équipe de développement se réserve le droit de les corriger, dès que ces erreurs sont portées à sa connaissance.

        Il est fortement recommandé de vérifier l’exactitude et la pertinence des informations et/ou documents mis à disposition sur ce site.

        Les informations et/ou documents disponibles sur ce site sont susceptibles d’être modifiés à tout moment, et peuvent avoir fait l’objet de mises à jour. En particulier, ils peuvent avoir fait l’objet d’une mise à jour entre le moment de leur téléchargement et celui où l’utilisateur en prend connaissance.

        L’utilisation des informations et/ou documents disponibles sur ce site se fait sous l’entière et seule responsabilité de l’utilisateur, qui assume la totalité des conséquences pouvant en découler, sans que l’équipe de développement puisse être recherché à ce titre, et sans recours contre ce dernier.

        L’équipe de développement ne pourra en aucun cas être tenu responsable de tout dommage de quelque nature qu’il soit résultant de l’interprétation ou de l’utilisation des informations et/ou documents disponibles sur ce site.
      </p>

      <h3><b>Accès au site : </b></h3>
      <p class="text-justify">
        L'équipe de développement ne peut garantir une disponibilité du site et/ou des services, une fiabilité des transmissions et des performances en terme de temps de réponse ou de qualité. Il n’est prévu aucune assistance technique vis à vis de l’utilisateur que ce soit par des moyens électronique ou téléphonique.

        La responsabilité de l’équipe de développement ne saurait être engagée en cas d’impossibilité d’accès à ce site et/ou d’utilisation des services.

        Par ailleurs, les développeurs peuvent être amené à interrompre le site ou une partie des services, à tout moment sans préavis, le tout sans droit à indemnités. L’utilisateur reconnaît et accepte que l’équipe de développement ne soit pas responsable des interruptions, et des conséquences qui peuvent en découler pour l’utilisateur ou tout tiers.
      </p>

      <h3><b>Modification des conditions d’utilisation : </b></h3>
      <p class="text-justify">
        Les développeurs se réservent la possibilité de modifier, à tout moment et sans préavis, les présentes conditions d’utilisation afin de les adapter aux évolutions du site et/ou de son exploitation.
      </p>

      <h3><b>Règles d'usage d'Internet : </b></h3>
      <p class="text-justify">
        L’utilisateur déclare accepter les caractéristiques et les limites d’Internet, et notamment reconnaît que :

        L’équipe de développement n’assume aucune responsabilité sur les services accessibles par Internet et n’exerce aucun contrôle de quelque forme que ce soit sur la nature et les caractéristiques des données qui pourraient transiter par l’intermédiaire de son centre serveur.

        L’utilisateur reconnaît que les données circulant sur Internet ne sont pas protégées notamment contre les détournements éventuels. La présence du logo   "AS-CO-MA"  institue une présomption simple de validité. La communication de toute information jugée par l’utilisateur de nature sensible ou confidentielle se fait à ses risques et périls.

        L’utilisateur reconnaît que les données circulant sur Internet peuvent être réglementées en termes d’usage ou être protégées par un droit de propriété.

        L’utilisateur est seul responsable de l’usage des données qu’il consulte, interroge et transfère sur Internet.

        L’utilisateur reconnaît que l’équipe de développement ne dispose d’aucun moyen de contrôle sur le contenu des services accessibles sur Internet.
      </p>

      <h3><b>Droit applicable : </b></h3>
      <p class="text-justify">
        Tant le présent site que les modalités et conditions de son utilisation sont régis par le droit français, quel que soit le lieu d’utilisation. En cas de contestation éventuelle, et après l’échec de toute tentative de recherche d’une solution amiable, les tribunaux français seront seuls compétents pour connaître de ce litige.

        Pour toute question relative aux présentes conditions d’utilisation du site, vous pouvez nous contacter via le formulaire présent sur le site.
      </p>
      <footer><strong>Les Administrateurs</strong>, <cite title="Source Title">AS-CO-MA</cite></footer>
    </div>
    <br>
  </blockquote>
  <button id="toggleCGU" class="btn btn-success btn-lg" type="button">Dérouler</button>
</div>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
<!-- //ici les script js de la Page courante UNIQUEMENT
//si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
