{extends file="layouts/main.tpl"}

{block name="content"}

{foreach $categories as $category}
<section class="home-section">
    <div class="home-section__header">
        <div class="home-section__meta">
            <h2 class="home-section__title">
                <a href="/category/{$category.slug}">{$category.name|escape}</a>
            </h2>
            {if $category.description}
            <p class="home-section__description">{$category.description|escape}</p>
            {/if}
        </div>
        <a href="/category/{$category.slug}" class="btn btn--outline">Все статьи</a>
    </div>

    {if $category.articles}
    <div class="articles-grid">
        {foreach $category.articles as $article}
            {include file="partials/article_card.tpl" article=$article}
        {/foreach}
    </div>
    {else}
    <p class="text-muted">Статьи отсутствуют.</p>
    {/if}
</section>
{foreachelse}
<p class="text-muted">Категории пока не добавлены.</p>
{/foreach}

{/block}
