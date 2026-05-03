{extends file="layouts/main.tpl"}

{block name="content"}

<div class="error-page">
    <div class="error-page__code">404</div>
    <h1 class="error-page__title">Страница не найдена</h1>
    <p class="error-page__message">Запрошенная страница не существует или была удалена.</p>
    <a href="/" class="btn">На главную</a>
</div>

{/block}
