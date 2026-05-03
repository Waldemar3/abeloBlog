{if $pagination.total_pages > 1}
<nav class="pagination" aria-label="Навигация по страницам">

    {if $pagination.has_previous}
    <a href="?page={$pagination.current_page - 1}&sort={$sort}" class="pagination__link">&laquo;</a>
    {/if}

    {for $page = 1 to $pagination.total_pages}
    <a href="?page={$page}&sort={$sort}"
       class="pagination__link{if $page == $pagination.current_page} pagination__link--active{/if}">
        {$page}
    </a>
    {/for}

    {if $pagination.has_next}
    <a href="?page={$pagination.current_page + 1}&sort={$sort}" class="pagination__link">&raquo;</a>
    {/if}

</nav>
{/if}
