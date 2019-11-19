<?php
/** Template Name: Search Form **/
?>

<form id="searchform" method="get" action="<?php echo home_url('/'); ?>">
    <div class="input-field">
        <i class="material-icons prefix">search</i>
        <input type="text" class="search-field" name="s" placeholder="Pesquise o nome do treinamento" value="<?php the_search_query(); ?>">
        <input type="hidden" name="post_type" value="treinamento" />
        <label for="search">Pesquisa</label>

    </div>
</form>