</div>
<?php wp_footer() ?>
<footer>
    <div class="footer-menu">
        <?php wp_nav_menu([
            'menu' => 'footer-menu',
            'menu_class' => 'navbar-nav',
            'theme_location' => 'footer',
        ]); ?>
    </div>
</footer>

</body>

</html>