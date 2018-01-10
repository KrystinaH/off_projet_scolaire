Enjeux de la navigation  
=======================

## Balise `<base>`  
   La balise base permet de gérer tout les liens à la racine du répertoire de projet.
   Tout les liens relatifs doivent être construits comme si le fichier de logique
   se trouvait à la racine du projet.
   Exemple pour la balise link vers styles.css dans le sous-sous-répertoire fiche (index.php):
```
<base href="../../"/>
<link rel="stylesheet" href="css/styles.css">
```

## La variable $niveau   
   est utilisée pour définir la valeur de la balise `<base>`   
```
  <base href="<?php echo $niveau?>"/>
```

## Liens rapides
   Référence: http://webaim.org/techniques/skipnav/  
   Il est impératif du point de vue de l'accessibilité, 
   de fournir au tout début du code html, soit, tout de suite après l'ouverture de <body>,
   un lien pour sauter par-dessus tout le code de la navigation et
   aller directement au contenu principal de la page.
   Ce lien est une ancre vers le premier contenu, soit, souvent, le h1.  
   Voir dans le template imbriqué header.tpl.php:  
```
<a href="index.php#contenu" class="visuallyhidden focusable">Allez au contenu</a>
```

## Navigation responsive et accessible
   Avec ou sans les styles  
   Avec ou sans JavaScript  
   En respectant l'amélioration progressive  
   En utilisant l'approche BEM pour styler et programmer  
   
   VARIANTES:

###  Mobile avec JavaScript : menuAccordéon 
###  Mobile sans JavaScript : fauxBoutonMenu avec lien vers le menu--footer
###  Écran large : menu--large
 

## Ajout dynamique en PHP de la classe menu__listeItem--actif  
Utilisation de la variable serveur PHP_SELF :  
```
    if (strpos($_SERVER['PHP_SELF'], 'artistes')) {
        $suffixe = "Artistes";
    } 
```

## Précautions à prendre pour les ancres # 
   L'effet de la balise base s'applique aussi aux ancres...  
   Cela peut être embêtant car si on ne fait rien, le clic sur une ancre  
    amènera toujours à la page index.php qui est à la racine du répertoire.
   Par exemple, pour un lien __Haut de page__ pointant sur un id #top,  
   Au lieu d'écrire:  
   ```
   <a href="#top">Haut de page</a>
   ```
   On pourra utiliser la variable `$_SERVER['PHP_SELF']`:
   ```
   <a href="<?php echo $this->variableServerPHP_SELF?>#top">Haut de page</a>
   ```

