<article class="article-card">
    {if $article.image}
    <a href="/article/{$article.slug}" class="article-card__image-wrap">
        <img src="{$article.image}" alt="{$article.title|escape}" class="article-card__image" loading="lazy">
    </a>
    {/if}
    <div class="article-card__body">
        <h3 class="article-card__title">
            <a href="/article/{$article.slug}">{$article.title|escape}</a>
        </h3>
        {if $article.description}
        <p class="article-card__description">{$article.description|escape|truncate:120:'...'}</p>
        {/if}
        <div class="article-card__meta">
            <span>{$article.published_at|format_date:'d.m.Y'}</span>
            <span>{$article.views} просм.</span>
        </div>
    </div>
</article>
