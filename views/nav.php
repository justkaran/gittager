<li><a href="index.php#home">Home</a></li>
<li><a href="index.php#ideology">How it works</a></li>
<li><a href="index.php#contact">Contact</a></li>
<?php if (isset($_SESSION['userData']['username'])) { ?>
<li><a class="nav-link js-scroll-trigger" href="tags.php">Tags</a></li>
<?php } ?>

<!--<script type="text/javascript">
    mixpanel.track_links("#navbar-nav a", "click nav link", {
        "referrer": document.referrer
    });
</script>-->