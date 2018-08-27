<footer class="footer">
    <div id="widgets-footer">

        <div id="footer-links">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-links')) : ?>
            <?php endif; ?>
        </div>
        <div id="footer-follow">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-follow')) : ?>
            <?php endif; ?>
        </div>
    </div>

</footer>
</body>

</html>