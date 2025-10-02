<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if popup has been shown in this session
        if (sessionStorage.getItem('popupShown')) {
            setTimeout(() => {
                new FilamentNotification()
                    .title('Made with Love ❤️ For Best Flutter 🌹')
                    .success()
                    .duration(5000)
                    .send();

                sessionStorage.setItem('popupShown', 'true');
            }, 500);
        }
    });
</script>
