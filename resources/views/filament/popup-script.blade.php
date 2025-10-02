<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if popup has been shown in this session

            setTimeout(() => {
                new FilamentNotification()
                    .title('Made with Love ❤️ Husband Protection Enabled 💂🏻 ')
                    .success()
                    .duration(7000)
                    .send();
                sessionStorage.setItem('popupShown', 'true');
            }, 500);

    });
</script>
