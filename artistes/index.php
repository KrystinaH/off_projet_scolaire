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

//Inclusion du script de connexion
@include($niveau.'inc/scripts/config.inc.php');

//Établissement de la chaine de requête
$strRequete =  'SELECT id_style, nom_style FROM t_style';

//Assertion et exécution de la requête
$pdoResultat = $pdoConnexion->prepare($strRequete);
$pdoResultat->execute();

//Extraction des l'enregistrements de la BD
$arrStyles= array();
$ligne=$pdoResultat->fetch();
for($intCpt=0;$intCpt<$pdoResultat->rowCount();$intCpt++)
{
    $arrStyles[$intCpt]['id_style']=$ligne['id_style'];
    $arrStyles[$intCpt]['nom_style']=$ligne['nom_style'];
    $ligne=$pdoResultat->fetch();
}

//Libération de la requête
$pdoResultat->closeCursor();

//Récupération du filtre (s'il y a lieu)
if(isset($_GET["id_style"]))
{
    $id_style = $_GET["id_style"];
}
else
{
    $id_style = 0;
}

//Récupération de l'id de page (s'il y a lieu)
if(isset($_GET["id_page"]))
{
    $id_page = $_GET["id_page"];
}
else{
    $id_page = 0;
}

//Paramètres de pagination
$intMaxParPage = 4;
$enregistrementDepart = $id_page * $intMaxParPage;

//Établissement de la chaine de requête pour connaître le nombre d'artistes
if($id_style != 0)
{
    $strRequete =  'SELECT ti_style_artiste.id_artiste, nom_artiste 
                  FROM t_artiste 
                  INNER JOIN ti_style_artiste ON ti_style_artiste.id_artiste = t_artiste.id_artiste
                  WHERE id_style = '.$id_style;
}
else
{
    $strRequete = 'SELECT id_artiste, nom_artiste
                    FROM t_artiste';
}

//Assertion et exécution de la requête
$pdoResultat = $pdoConnexion->prepare($strRequete);
$pdoResultat->execute();

//Déterminer le nombre d'artistes et de pages
$intNbArtistes = $pdoResultat->rowCount();
$nbPages = ceil($intNbArtistes / $intMaxParPage);

$pdoResultat->closeCursor();

//Établissement de la chaine de requête pour afficher le bon nombre d'artistes
if($id_style != 0)
{
    $strRequete =  'SELECT DISTINCT t_artiste.id_artiste, nom_artiste 
                  FROM t_artiste 
                  INNER JOIN ti_style_artiste ON ti_style_artiste.id_artiste = t_artiste.id_artiste
                  WHERE id_style = '.$id_style.'
                  ORDER BY nom_artiste
                  LIMIT '.$enregistrementDepart.",".$intMaxParPage;
}
else
{
    $strRequete = 'SELECT DISTINCT id_artiste, nom_artiste
                    FROM t_artiste
                    ORDER BY nom_artiste
                    LIMIT '.$enregistrementDepart.",".$intMaxParPage;;
}

//Assertion et exécution de la requête
$pdoResultat = $pdoConnexion->prepare($strRequete);
$pdoResultat->execute();

//Extraction des l'enregistrements de la BD
$arrArtistes= array();
$ligne=$pdoResultat->fetch();

//Récupération des artistes et attribution de leur(s) style(s)
for($intCpt=0;$intCpt<$pdoResultat->rowCount();$intCpt++)
{
    $arrArtistes[$intCpt]['id_artiste']=$ligne['id_artiste'];
    $arrArtistes[$intCpt]['nom_artiste']=$ligne['nom_artiste'];

    //Sous-requête des styles relié à l'artiste
    $strRequete = 'SELECT nom_style 
                    FROM ti_style_artiste 
                    INNER JOIN t_artiste ON ti_style_artiste.id_artiste = t_artiste.id_artiste 
                    INNER JOIN t_style ON ti_style_artiste.id_style = t_style.id_style 
                    WHERE ti_style_artiste.id_artiste = '. $ligne["id_artiste"];

    //Assertion et exécution de la requête
    $pdoSousResultat = $pdoConnexion->prepare($strRequete);
    $pdoSousResultat->execute();

    $ligneStyle=$pdoSousResultat->fetch();
    $styles = "";

    for($intCptStyles=0;$intCptStyles<$pdoSousResultat->rowCount();$intCptStyles++)
    {
        if($styles != "")
        {
            $styles .= ", ";
        }
        $styles .= $ligneStyle["nom_style"];
        $ligneStyle=$pdoSousResultat->fetch();
    }
    $arrArtistes[$intCpt]['styles']=$styles;
    $ligne=$pdoResultat->fetch();
}

//Libération de la requête
$pdoResultat->closeCursor();

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
    <h1 id="contenu">Artistes</h1>
      <h2>Styles</h2>
      <ul>
          <li><a href="artistes/index.php">Tous les styles</a></li>
          <?php
          //Affichage de la liste des sports
          for($intCpt=0;$intCpt<count($arrStyles);$intCpt++)
          {?>
              <li>
                  <a href="artistes/index.php?id_style=<?php echo $arrStyles[$intCpt]['id_style'] ?>">
                      <?php echo $arrStyles[$intCpt]["nom_style"] ?>
                  </a>
              </li>
          <?php }?>
      </ul>
      <ul>
          <?php
          //Affichage des noms et prénoms dans une liste
          for($intCpt=0;$intCpt<count($arrArtistes);$intCpt++){ ?>
              <li>
                  <img src="http://via.placeholder.com/50x50">
                  <a href='<?php echo "artistes/fiche/index.php?id_artiste=" .
                      $arrArtistes[$intCpt]['id_artiste'];?>'>
                      <?php echo $arrArtistes[$intCpt]['nom_artiste'];?>
                  </a>
                  <span><?php echo $arrArtistes[$intCpt]['styles']; ?></span>
              </li>
          <?php } ?>
      </ul>

      <?php if($id_page>0){
          //Si la page courante n'est pas la première, afficher le bouton précédent ?>
          <a href="artistes/index.php?id_page=<?php echo $id_page-1; ?>">Précédent</a>
      <?php }
      if($id_page<$nbPages-1){
          //Si la page cournte n'est pas la dernière, afficher le bouton suivant ?>
          <a href="artistes/index.php?id_page=<?php echo $id_page+1; ?>">Suivant</a>
      <?php } ?>

      <p>
          <?php
          //Affichage du numéro de la page courante sur le total de page
          echo ($id_page+1); ?> de <?php echo $nbPages; ?>
      </p>

    <p class="top"><a href="<?php echo $_SERVER['PHP_SELF'];?>#top">haut de page</a></p>
  </main>
    <?php include($niveau."inc/fragments/footer.inc.php");
    include($niveau."inc/fragments/scripts.inc.php");?>
</div><!-- fermeture du div.wrap -->
</body>
</html>