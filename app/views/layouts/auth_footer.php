<?php $flash = flash(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>window.APP_FLASH = <?= json_encode($flash) ?>;</script>
<script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>

