<!-- PAGE DES CONDITIONS GENERALES D'UTILISATION DU SITE -->
<?php $this->layout('layout', ['title' => 'AS-CO-MA - Avenir du site']) ?>
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
    <h2 class="text-center">L'Avenir d'AS-CO-MA</h2>
    <h3><b>Fonctionalités à venir : </b></h3>
    <p>
      - Pouvoir inviter des collaborateurs dans une mairie,<br/>
      - Listing de tous les utilisateurs du site pour les Administrateurs du site,<br/>
      - Possibilité de bannir un utilisateur du site,<br/>
      - Enquête de satisfaction à la suppression d'un compte utilisateur,<br/>
      - Mise en place d'un agenda public pour les mairies et associations, souhaitant informer de futurs évènements.
    </p>

    <h3><b>Fonctionalités désirées : </b></h3>
    <p>
      <i><u>Mairies :</u></i><br/>
      - Possibilité d'intégration d'un site externe sur une page d'AS-CO-MA ou lien vers le-dit site
      <br/><br/>
      <i><u>Associations :</u></i><br/>
      - Comptabilité des cotisations,<br/>
      - Bilan simplifié rédigeable en ligne , exportable au format pdf et visible pour tous les membres de l'association,<br/>
      - Possibilité d'intégration d'un site externe sur une page d'AS-CO-MA ou lien direct vers le-dit site
      <br/><br/>
      <i><u>Membres :</u></i><br/>
      - Système de paiement de cotisations,<br/>
      - Acces aux news en back-office,<br/>
      - Accès à l'historique des bilans,<br/>
      - Tchat interne à l'association proposant un canal général et canal privé,<br/>
      - Lien pour contacter l'association en interne.<br/>

    </p>

    <footer><strong>Les Administrateurs</strong>, <cite title="Source Title">AS-CO-MA</cite></footer>
    <br>
  </blockquote>
</div>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
<!-- //ici les script js de la Page courante UNIQUEMENT
//si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
