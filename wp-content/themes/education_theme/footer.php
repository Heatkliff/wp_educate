<div class="footer">
    <div id="widgets-footer">

        <div class="footer-links-widget">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-links')) : ?>
            <?php endif; ?>
        </div>
        <div class="footer-follow-widget">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-follow')) : ?>
            <?php endif; ?>
        </div>
    </div>

</div>
</body>

</html>