/**
 * Accordéon version jQuery avec poignées svg
 */

var accordeon = {

    initialiser: function ()
    {
        $(".accordeon__controle").on('click', accordeon.afficherCacherBloc.bind(this));
    },

    resetBlocs: function ()
    {
        $(".accordeon__pli").removeClass().addClass("menu__listeItem accordeon__pli accordeon__pli--isCollapsed");
        $(".accordeon__controlePoignee .icone").removeClass().addClass("icone icone--chevron-down");
        $(".accordeon__controlePoignee .visuallyhidden").text("Ouvrir");
    },

    /**
     * Méthode pour basculer l'affichage des "pli" d'accordéon
     * en se basant sur la présence du modificateur --isExpanded
     * @param evenement
     */
    afficherCacherBloc: function (evenement)
    {
        if ($(evenement.currentTarget).closest('.accordeon__pli').hasClass("accordeon__pli--isExpanded"))
        {
            this.resetBlocs();
        }
        else
        {
            this.resetBlocs();
            $(evenement.currentTarget).closest('.accordeon__pli').removeClass().addClass("menu__listeItem accordeon__pli accordeon__pli--isExpanded");
            $(evenement.currentTarget).find('.icone').removeClass().addClass("icone icone--chevron-up");
            $(evenement.currentTarget).find('.visuallyhidden').text("Fermer");
        }
    }
};
