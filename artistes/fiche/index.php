<?php
//Définition de la variable de niveau
$niveau='../../';

# pour menu #
$menuActifLeOFF = "";
$menuActifProgrammation = "";
$menuActifArtistes = "";

if (strpos($_SERVER['REQUEST_URI'], 'artistes')) {
    $suffixe = "Artistes";
} else if (strpos($_SERVER['REQUEST_URI'], 'programmation')) {
    $suffixe = "Programmation";
} else {
    $suffixe = "LeOFF";
}

${"menuActif" . $suffixe} = "menu--large__listeItem--actif";

//Inclusion du script de connexion
@include($niveau.'inc/scripts/config.inc.php');

//Récupération de la querystring
$id_artiste=$_GET['id_artiste'];

//Requête des informations de l'artiste
$strRequete =  'SELECT * 
                FROM t_artiste 
                WHERE id_artiste='.$id_artiste;

//Assertion et exécution de la requête
$pdoResultat = $pdoConnexion->prepare($strRequete);
$pdoResultat->execute();

//Extraction des infos de l'artiste
$ligne=$pdoResultat->fetch();
$arrInfosArtiste['id_artiste']=$ligne['id_artiste'];
$arrInfosArtiste['nom_artiste']=$ligne['nom_artiste'];
$arrInfosArtiste['description']=$ligne['description'];
$arrInfosArtiste['provenance']=$ligne['provenance'];
$arrInfosArtiste['site_web_artiste']=$ligne['site_web_artiste'];

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
$arrInfosArtiste['styles']=$styles;

//Libération de la requête
$pdoResultat->closeCursor();

//Préparation de la chaîne des styles à entrer dans le "WHERE IN"
$strStyles = explode(", ", $styles);
$strStyles = implode("', '", $strStyles);
$strStylesWhere = "'" . $strStyles . "'";

//Requête pour récupérer les artistes qui ont le même style
$strRequete = 'SELECT DISTINCT t_artiste.id_artiste, nom_artiste
                FROM t_artiste
                INNER JOIN ti_style_artiste ON t_artiste.id_artiste = ti_style_artiste.id_artiste
                INNER JOIN t_style ON t_style.id_style = ti_style_artiste.id_style
                WHERE (nom_style) IN ('.$strStylesWhere.') AND NOT ti_style_artiste.id_artiste = '.$arrInfosArtiste["id_artiste"];

$pdoResultat = $pdoConnexion->prepare($strRequete);
$pdoResultat->execute();

//Extraction des artistes
$ligneAutreArtiste=$pdoResultat->fetch();
$arrAutresArtistes = array();

for($intCpt=0;$intCpt<$pdoResultat->rowCount();$intCpt++)
{
    $arrAutresArtistes[$intCpt]["id_artiste"]=$ligneAutreArtiste["id_artiste"];
    $arrAutresArtistes[$intCpt]["nom_artiste"]=$ligneAutreArtiste["nom_artiste"];
    $ligneAutreArtiste=$pdoResultat->fetch();
}

//Libération de la requête
$pdoResultat->closeCursor();

//Requête pour récupérer les évènements auxquels l'artiste participe
$strRequete =  'SELECT nom_lieu, DAYOFMONTH(date_et_heure) AS jour, MONTH(date_et_heure) AS mois, HOUR(date_et_heure) AS heure, MINUTE(date_et_heure) AS minutes 
                FROM t_artiste 
                INNER JOIN ti_evenement ON t_artiste.id_artiste = ti_evenement.id_artiste 
                INNER JOIN t_lieu ON ti_evenement.id_lieu = t_lieu.id_lieu 
                WHERE t_artiste.id_artiste='.$id_artiste.
                ' ORDER BY date_et_heure';

$pdoResultat = $pdoConnexion->prepare($strRequete);
$pdoResultat->execute();

//Extraction des évènements
$ligneEvenement=$pdoResultat->fetch();
$arrEvenements = array();

for($intCpt=0;$intCpt<$pdoResultat->rowCount();$intCpt++)
{
    $arrEvenements[$intCpt]["nom_lieu"]=$ligneEvenement["nom_lieu"];
    $arrEvenements[$intCpt]["jour"]=$ligneEvenement["jour"];
    $arrEvenements[$intCpt]["mois"]=$ligneEvenement["mois"];
    $arrEvenements[$intCpt]["heure"]=$ligneEvenement["heure"];
    $arrEvenements[$intCpt]["minutes"]=$ligneEvenement["minutes"];
    $ligneEvenement=$pdoResultat->fetch();
}

//Tableau des mois
$arrMois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width"/>
  <title>Artistes - <?php $arrInfosArtiste["nom_artiste"]; ?></title>
  <!--URL de base pour la navigation -->
  <base href="<?php echo $niveau?>"/>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body><!--http://webaim.org/techniques/skipnav/-->
<div class="arriereplan">
<a href="#contenu" class="visuallyhidden focusable lienevitement">Allez au contenu</a>
<div id="top" class="wrap">
  <header>
      <?php include($niveau."inc/fragments/header.inc.php") ?>
  </header>
  <main>
      <div class="infosartiste">
          <section class="audiovisuelle">
              <h1 id="contenu" class="h2"><?php echo $arrInfosArtiste["nom_artiste"]; ?></h1>
              <h2 class="h3"><?php echo $arrInfosArtiste["provenance"]; ?></h2>
              <?php $imgRand = rand(1,3); ?>
              <picture>
                  <source media="(min-width:601px)"
                          srcset="<?php echo 'images/'.$id_artiste.'/'.$id_artiste.'_img'.$imgRand.'__w490.jpg';?> 1x,
                  <?php echo 'images/'.$id_artiste.'/'.$id_artiste.'_img'.$imgRand.'__w980.jpg';?> 2x">
                  <source media="(max-width:600px)"
                          srcset="<?php echo 'images/'.$id_artiste.'/'.$id_artiste.'_img'.$imgRand.'__w640.jpg';?> 1x,
                  <?php echo 'images/'.$id_artiste.'/'.$id_artiste.'_img'.$imgRand.'__w1200.jpg';?> 2x">
                  <img src="<?php echo 'images/'.$id_artiste.'/'.$id_artiste.'_img'.$imgRand.'__w640.jpg';?>" alt="Image du groupe <?php echo $arrInfosArtiste['nom_artiste'];?>">
              </picture>
          </section>
          <section class="details">
              <p class="alignerDroite"><a href="https://lepointdevente.com/" class="lienBouton">Achetez votre passe</a></p>
              <p class="h3">VOUS POUVEZ LES VOIR LE...</p>
              <ul>
                  <?php for($intCpt=0;$intCpt<count($arrEvenements);$intCpt++){?>
                      <li>
                          <?php
                          $heure = date_create($arrEvenements[$intCpt]["heure"].":".$arrEvenements[$intCpt]["minutes"]);
                          echo $arrEvenements[$intCpt]["jour"].' '.$arrMois[$arrEvenements[$intCpt]["mois"]]." à ".$arrEvenements[$intCpt]["nom_lieu"]." à ".date_format($heure, "H:i");?>
                      </li>
                  <?php } ?>
              </ul>
              <div class="description">
                  <p class="h2">UN GROUPE DE...</p>
                  <h2 class="h4"><?php echo $arrInfosArtiste["styles"]; ?></h2>
                  <p><?php echo $arrInfosArtiste["description"]; ?></p>
                  <a href="<?php echo $arrInfosArtiste["site_web_artiste"]; ?>"><?php echo $arrInfosArtiste["site_web_artiste"]; ?></a>
              </div>
          </section>
      </div>

<div class="suggestions">
    <?php $arrTempoArtistes = array();
    if(count($arrAutresArtistes)!= 0){?>
        <p class="h3">ON VOUS SUGGÈRE AUSSI...</p>
        <?php for($intCpt=0;$intCpt<count($arrAutresArtistes) && $intCpt<3;$intCpt++)
        {
            $randArtiste = rand(0, count($arrAutresArtistes)-1);
            array_push($arrTempoArtistes, $arrAutresArtistes[$randArtiste]);
            array_splice($arrAutresArtistes, $randArtiste, 1);
        }
    } ?>
    <ul class="suggestions__artistes">
        <?php for($intCpt=0;$intCpt<count($arrTempoArtistes);$intCpt++){
            $imgRand = rand(1,3);?>
            <li>
                <?php $idAutreArtiste = $arrTempoArtistes[$intCpt]['id_artiste']?>
                <a href="<?php echo 'artistes/fiche/index.php?id_artiste='.$idAutreArtiste; ?>">
                    <figure>
                        <figcaption><h2 class="h4"><?php echo $arrTempoArtistes[$intCpt]["nom_artiste"]; ?></h2></figcaption>
                        <picture>
                            <source media="(min-width:601px)"
                                    srcset="<?php echo 'images/'.$idAutreArtiste.'/'.$idAutreArtiste.'_img'.$imgRand.'__w320.jpg';?> 1x,
                  <?php echo 'images/'.$idAutreArtiste.'/'.$idAutreArtiste.'_img'.$imgRand.'__w640.jpg';?> 2x">
                            <source media="(max-width:600px)"
                                    srcset="<?php echo 'images/'.$idAutreArtiste.'/'.$idAutreArtiste.'_img'.$imgRand.'__w640.jpg';?> 1x,
                  <?php echo 'images/'.$idAutreArtiste.'/'.$idAutreArtiste.'_img'.$imgRand.'__w1200.jpg';?> 2x">
                            <img src="<?php echo 'images/'.$idAutreArtiste.'/'.$idAutreArtiste.'_img'.$imgRand.'__w640.jpg';?>" alt="Image du groupe <?php echo $arrTempoArtistes[$intCpt]['nom_artiste'];?>">
                        </picture>
                    </figure>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
    <p class="top"><a href="<?php echo $_SERVER['REQUEST_URI'];?>#top">Haut de page</a></p>
  </main>
    </div><!-- fermeture du div.wrap -->
</div><!-- fermeture du div.arriereplan -->
  <?php include($niveau."inc/fragments/footer.inc.php");
        include($niveau."inc/fragments/scripts.inc.php");?>
</body>
</html>