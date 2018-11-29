<ul class="navbar-nav ml-auto" id="navbar-nav">
    <?php if (isset($_SESSION['userData']['username'])) { ?>
    <li class="nav-item">
        <a class="nav-link js-scroll-trigger">
            <?php echo (isset($_SESSION['userData']['username'])) ? "Logged in as: ".$_SESSION['userData']['username']." | " : "not logged in | "; ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="index.php">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="profile.php">Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="tags.php">Tags</a>
    </li>
    <?php } ?>
</ul>
<!--<script type="text/javascript">
    mixpanel.track_links("#navbar-nav a", "click nav link", {
        "referrer": document.referrer
    });
</script>-->