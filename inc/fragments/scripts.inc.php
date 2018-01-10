<script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>

<script>window.jQuery || document.write('<script src="bower_components/jquery/dist/jquery.min.js">\x3C/script>')</script>

<script src="js/_accordeon.js"></script>
<script src="js/_menuAccordeon.js"></script>
<script>
$('body').addClass('js');
    $(document).ready(function ()
    {
        accordeon.initialiser();
        menuAccordeon.configurerNav();
    });
</script>