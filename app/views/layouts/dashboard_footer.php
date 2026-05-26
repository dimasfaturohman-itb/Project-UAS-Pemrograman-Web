<footer class="mt-5 pt-4 border-top text-muted small d-flex flex-wrap justify-content-between gap-2">
    <span>&copy; <?= date('Y') ?> <?= APP_NAME ?> - Kabupaten Cirebon</span>
    <span>Dikelola untuk layanan pelaporan fasilitas umum</span>
</footer>
        </section>
    </main>
</div>
<?php $flash = flash(); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>window.APP_FLASH = <?= json_encode($flash) ?>;</script>
<script src="<?= asset('js/app.js') ?>"></script>
<?php if (!empty($extraScripts)) echo $extraScripts; ?>
</body>
</html>

