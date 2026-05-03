{extends file="layouts/main.tpl"}

{block name="content"}

<div class="page-header">
    <h1 class="page-title">{$category.name|escape}</h1>
    {if $category.description}
    <p class="page-description">{$category.description|escape}</p>
    {/if}
</div>

<div class="sort-bar">
    <span class="sort-bar__label">Сортировка:</span>
    <a href="?sort=published_at"
       class="sort-link{if $sort == 'published_at'} sort-link--active{/if}">По дате</a>
    <a href="?sort=views"
       class="sort-link{if $sort == 'views'} sort-link--active{/if}">По просмотрам</a>
</div>

{if $articles}
<div class="articles-grid">
    {foreach $articles as $article}
        {include file="partials/article_card.tpl" article=$article}
    {/foreach}
</div>

{include file="partials/pagination.tpl" pagination=$pagination sort=$sort}

{else}
<p class="text-muted">Статьи не найдены.</p>
{/if}

{/block}
