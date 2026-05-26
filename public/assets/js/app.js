document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('[data-sidebar-toggle]');
    const sidebar = document.querySelector('.sidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', () => sidebar.classList.toggle('show'));
    }

    document.querySelectorAll('.datatable').forEach((table) => {
        new DataTable(table, {
            responsive: true,
            pageLength: 10,
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                paginate: { next: 'Berikutnya', previous: 'Sebelumnya' },
                zeroRecords: 'Data tidak ditemukan'
            }
        });
    });

    const flash = window.APP_FLASH;
    if (flash && flash.message) {
        Swal.fire({
            icon: flash.type === 'error' ? 'error' : flash.type,
            title: flash.type === 'success' ? 'Berhasil' : 'Informasi',
            text: flash.message,
            confirmButtonColor: '#0d6efd'
        });
    }
});

function statusBadge(status) {
    const map = {
        'Menunggu Verifikasi': 'bg-warning-subtle text-warning-emphasis',
        'Diproses': 'bg-primary-subtle text-primary-emphasis',
        'Dalam Perbaikan': 'bg-info-subtle text-info-emphasis',
        'Selesai': 'bg-success-subtle text-success-emphasis',
        'Ditolak': 'bg-danger-subtle text-danger-emphasis'
    };
    return map[status] || 'bg-secondary-subtle text-secondary-emphasis';
}

