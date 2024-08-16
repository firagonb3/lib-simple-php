<main>
    <?= $MainHeader ?>
    <iframe id='mainIframe' src="/public/<?= $content ?>" frameborder="0"></iframe>
</main>
<footer style="background-color: red;">dd</footer>

<style>
    #mainIframe {
        width: 100%;
        height: 90vh;
    }
</style>