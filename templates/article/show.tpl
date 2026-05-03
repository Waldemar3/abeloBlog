{extends file="layouts/main.tpl"}

{block name="content"}

<article class="article">

    {if $article.image}
    <img src="{$article.image}" alt="{$article.title|escape}" class="article__cover">
    {/if}

    <div class="article__categories">
        {foreach $article.categories as $cat}
        <a href="/category/{$cat.slug}" class="tag">{$cat.name|escape}</a>
        {/foreach}
    </div>

    <h1 class="article__title">{$article.title|escape}</h1>

    <div class="article__meta">
        <span>{$article.published_at|format_date:'d.m.Y'}</span>
        <span>{$article.views} просмотров</span>
    </div>

    {if $article.description}
    <p class="article__lead">{$article.description|escape}</p>
    {/if}

    <div class="article__content">
        {$article.content|escape|nl2br}
    </div>

</article>

{if $similar}
<section class="similar">
    <h2 class="similar__title">Похожие статьи</h2>
    <div class="articles-grid">
        {foreach $similar as $article}
            {include file="partials/article_card.tpl" article=$article}
        {/foreach}
    </div>
</section>
{/if}

{/block}
