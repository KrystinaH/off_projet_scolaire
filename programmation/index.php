<?php
//Définition de la variable de niveau
$niveau='../';

# pour menu #
$menuActifLeOFF = "";
$menuActifProgrammation = "";
$menuActifArtistes = "";

if (strpos($_SERVER['PHP_SELF'], 'artistes')) {
    $suffixe = "Artistes";
} else if (strpos($_SERVER['PHP_SELF'], 'programmation')) {
    $suffixe = "Programmation";
} else {
    $suffixe = "LeOFF";
}

${"menuActif" . $suffixe} = "menu--large__listeItem--actif";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width"/>
  <title>titre page - titre site</title>
  <!--URL de base pour la navigation -->
  <base href="<?php echo $niveau?>"/>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body><!--http://webaim.org/techniques/skipnav/-->
<a href="#contenu" class=" ">Allez au contenu</a>
<div id="top" class="wrap">
  <header>
      <?php include($niveau."inc/fragments/header.inc.php") ?>
  </header>

  <main>
    <h1 id="contenu">Programmation</h1>
    <p><span>Accusamus aperiam architecto at atque, commodi corporis eum eveniet explicabo fuga harum id ipsum nam necessitatibus numquam officiis perferendis quas qui rem, repellat reprehenderit, sed soluta ullam veritatis vitae voluptatem.</span><span>Accusantium architecto commodi culpa cupiditate deserunt dolores eos facere fugiat iste molestiae officia omnis perferendis praesentium repellat repellendus sapiente, sequi sint ut vel voluptate? Dolores maxime minus qui sapiente sunt!</span><span>Aliquam, consequatur cupiditate delectus eos explicabo illo in iure, nam nulla omnis provident saepe sequi sint ut voluptatem? Debitis deleniti dolores est modi natus nobis non ratione sunt ullam vitae!</span><span>Ab consequuntur dolor dolore exercitationem facere fugiat, nihil quas repellendus tenetur voluptate. Ab aliquid aut consequuntur doloremque dolores, esse, molestias odio officiis placeat porro quaerat quia sunt temporibus tenetur voluptatibus.</span><span>Commodi cum deserunt ea excepturi laboriosam laudantium libero neque numquam officia repudiandae, sint veniam? Ab aperiam consequuntur cupiditate dolorem esse, id ipsam, modi omnis praesentium quam quibusdam quod, sunt tenetur!</span><span>Assumenda autem beatae delectus deleniti dolor doloremque ea enim eveniet ex fugiat harum hic impedit labore, libero nobis nostrum omnis pariatur placeat quasi quia quis repellat, suscipit tempora, ullam voluptate?</span><span>Eligendi magni minima nisi quaerat quisquam repellat repudiandae saepe soluta sunt. Ab accusantium beatae, blanditiis et excepturi expedita fugiat incidunt laudantium, minus mollitia nostrum omnis, perspiciatis porro quo sint ut.</span>
    </p>

    <p class="top"><a href="<?php echo $_SERVER['PHP_SELF'];?>#top">haut de page</a></p>
  </main>
    <?php include($niveau."inc/fragments/footer.inc.php");
    include($niveau."inc/fragments/scripts.inc.php");?>
</div><!-- fermeture du div.wrap -->
</body>
</html>