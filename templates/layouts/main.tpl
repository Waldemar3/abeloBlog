<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$pageTitle|default:$appName}</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container">
        <a href="/" class="site-logo">{$appName}</a>
    </div>
</header>

<main class="site-main">
    <div class="container">
        {block name="content"}{/block}
    </div>
</main>

<footer class="site-footer">
    <div class="container">
        <p>&copy; {$currentYear} {$appName}. Все права защищены.</p>
    </div>
</footer>

</body>
</html>
