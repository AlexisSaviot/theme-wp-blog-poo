<!-- The template for the custom search's form -->
<form id="searchform" method="get" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="searchinput">
        <i class="fas fa-search"></i>
    </label>
    <input type="text" id="searchinput" name="s" placeholder="Recherche" />
</form>