<p class="h1">FESTIVAL OFF</p>
<p>TOUT EST POSSIBLE</p>
<!-- menu simple pour écran large -->
<nav class="menu--large">
    <span class="menu--large__logo"></span>
    <ul class="menu--large__liste">
        <li class="menu--large__listeItem <?php echo $menuActifLeOFF?>"><a href="index.php" class="menu--large__lien">LE OFF<span class="menu--large__lien--active"></a>
            <ul class="menu--large__sousListe">
                <li class="menu--large__sousListeItem"><a href="<?php echo $_SERVER['REQUEST_URI'] ?>#" class="menu--large__lien">Artistes</a></li>
                <li class="menu--large__sousListeItem"><a href="<?php echo $_SERVER['REQUEST_URI'] ?>#" class="menu--large__lien">Lieux</a></li>
                <li class="menu--large__sousListeItem"><a href="<?php echo $_SERVER['REQUEST_URI'] ?>#" class="menu--large__lien">Tarifs</a></li>
                <li class="menu--large__sousListeItem"><a href="<?php echo $_SERVER['REQUEST_URI'] ?>#" class="menu--large__lien">Contact</a></li>
            </ul>
        </li>
        <li class="menu--large__listeItem <?php echo $menuActifProgrammation?>">
            <a href="programmation/index.php" class="menu--large__lien">PROGRAMMATION<span class="menu--large__lien--active"></a>
            <ul class="menu--large__sousListe">
                <li class="menu--large__sousListeItem">
                    <a href="programmation/index.php" class="menu--large__lien">Par lieux</a></li>
                <li class="menu--large__sousListeItem">
                    <a href="<?php echo $_SERVER['REQUEST_URI'] ?>" class="menu--large__lien">Par dates</a>
                </li>
            </ul>
        </li>
        <li class="menu--large__listeItem <?php echo $menuActifArtistes?>">
            <a href="artistes/index.php" class="menu--large__lien">ARTISTES<span class="menu--large__lien--active"></a>
            <ul class="menu--large__sousListe">
                <li class="menu--large__sousListeItem"><a href="artistes/index.php" class="menu--large__lien">Artistes
                        A-Z</a></li>
                <li class="menu--large__sousListeItem"><a href="<?php echo $_SERVER['REQUEST_URI'] ?>" class="menu--large__lien">Par style
                        musical</a></li>
            </ul>
        </li>
        <li class="menu--large__listeItem"><a href="<?php echo $_SERVER['REQUEST_URI'] ?>" class="menu--large__lien">PARTENAIRES<span class="menu--large__lien--active"></a></li>
    </ul>
</nav>
<!-- pour écran étroit sans JavaScript, une ancre pour aller au menu du footer -->
<a class="fauxBoutonMenu" href="#fat">
      <span class="menu__icone"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     class="icone icone--hamburger"><path
                  d="M2 6h20v3H2zm0 5h20v3H2zm0 5h20v3H2z"/></svg></span>
    <span class="menu__libelle">Menu</span>
</a>
<!-- menu accordéon pour écran étroit avec JavaScript -->
<nav class="accordeon menu">
    <span class="menu__logo"></span>
    <ul class="menu__liste menu__liste--fermer">
        <li class="accordeon__pli menu__listeItem">
            <button class="accordeon__controle">LE OFF
                <span class="accordeon__controlePoignee">
            <span class="icone icone--chevron-down" aria-hidden="true"></span>
                                    <span class="visuallyhidden">Ouvrir</span>
                                </span>
            </button>
            <ul class="accordeon__bloc menu__sousListe">
                <li class="menu__sousListeItem"><a href="#" class="menu__lien">Artistes</a></span></li>
                <li class="menu__sousListeItem"><a href="#" class="menu__lien">Lieux</a></li>
                <li class="menu__sousListeItem"><a href="#" class="menu__lien">Tarifs</a></li>
                <li class="menu__sousListeItem"><a href="#" class="menu__lien">Contact</a></li>
            </ul>
        </li>
        <li class="accordeon__pli menu__listeItem">
            <button class="accordeon__controle" href="programmation/index.php">PROGRAMMATION
                <span class="accordeon__controlePoignee">
            <span class="icone icone--chevron-down" aria-hidden="true"></span>
                                    <span class="visuallyhidden">Ouvrir</span>
                                </span>
            </button>
            <ul class="accordeon__bloc menu__sousListe">
                <li class="menu__sousListeItem"><a href="programmation/index.php" class="menu__lien">Par lieux</a></li>
                <li class="menu__sousListeItem"><a href="#" class="menu__lien">Par dates</a></li>
            </ul>
        </li>
        <li class="accordeon__pli menu__listeItem">
            <button class="accordeon__controle">ARTISTES
                <span class="accordeon__controlePoignee">
            <span class="icone icone--chevron-down" aria-hidden="true"></span>
                                    <span class="visuallyhidden">Ouvrir</span>
                                </span>
            </button>
            <ul class="accordeon__bloc menu__sousListe">
                <li class="menu__sousListeItem"><a href="artistes/index.php" class="menu__lien">Artistes A-Z</a></li>
                <li class="menu__sousListeItem"><a href="#" class="menu__lien">Par style musical</a></li>
            </ul>
        </li>
        <li class="accordeon__pli menu__listeItem">
            <button class="accordeon__controle">PARTENAIRES
                <span class="accordeon__controlePoignee">
            <span class="icone icone--chevron-down" aria-hidden="true"></span>
                                    <span class="visuallyhidden">Ouvrir</span>
                                </span>
            </button>
            <ul class="accordeon__bloc menu__sousListe">
                <li class="menu__sousListeItem"><a href="#" class="menu__lien">Partenaires actuels</a></li>
                <li class="menu__sousListeItem"><a href="#" class="menu__lien">Devenir partenaire</a></li>
            </ul>
        </li>
    </ul>
</nav>