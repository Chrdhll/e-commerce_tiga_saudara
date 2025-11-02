@php

$alert = null;
if (session('success')) {
    $alert = ['type' => 'success', 'message' => session('success')];
} elseif (session('error') || $errors->any()) { 
    // Tangkap error validasi umum atau error spesifik
    $alert = ['type' => 'danger', 'message' => session('error') ?? 'Data yang Anda masukkan tidak valid.'];
} elseif (session('warning')) {
    $alert = ['type' => 'warning', 'message' => session('warning')];
} elseif (session('info')) {
    $alert = ['type' => 'info', 'message' => session('info')];
}
@endphp

<div 
    class="toast-container position-fixed top-0 end-0 p-3" 
    style="z-index: 1100"
    
    x-data="{
        toast: null,
        type: 'success',
        message: '',
        
        init() {
            this.toast = new bootstrap.Toast(this.$refs.toastEl, {
                delay: 5000 // Toast hilang setelah 5 detik
            });
            
            @if($alert)
                // Jika ada, kita panggil fungsi showToast
                this.showToast(@json($alert['type']), @json($alert['message']));
            @endif
        },
        
        showToast(type, message) {
            this.type = type;
            this.message = message;
            
            // Hapus class warna lama, tambahkan class baru
            this.$refs.toastEl.classList.remove('text-bg-success', 'text-bg-danger', 'text-bg-warning', 'text-bg-info');
            this.$refs.toastEl.classList.add('text-bg-' + this.getBootstrapClass(type));
            
            this.toast.show();
        },

        '@show-toast.window.document': 'showToast($event.detail.type, $event.detail.message)',

        getIconClass(type) {
            switch (type) {
                case 'success': return 'bi-check-circle-fill';
                case 'danger': return 'bi-exclamation-triangle-fill';
                case 'warning': return 'bi-exclamation-triangle-fill';
                case 'info': return 'bi-info-circle-fill';
                default: return 'bi-info-circle-fill';
            }
        },
        getTitle(type) {
            switch (type) {
                case 'success': return 'Sukses';
                case 'danger': return 'Error';
                case 'warning': return 'Peringatan';
                case 'info': return 'Info';
                default: return 'Notifikasi';
            }
        },
        getBootstrapClass(type) {
            switch (type) {
                case 'success': return 'success';
                case 'danger': return 'danger';
                case 'warning': return 'warning';
                case 'info': return 'info';
                default: return 'info';
            }
        }
    }"
>
    <div 
        class="toast" 
        role="alert" 
        aria-live="assertive" 
        aria-atomic="true" 
        x-ref="toastEl"
    >
        <div class="toast-header" :class="'text-bg-' + getBootstrapClass(type)">
            <i class="bi fs-5 me-2" :class="getIconClass(type)"></i>
            <strong class="me-auto" x-text="getTitle(type)"></strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" x-text="message">
            </div>
    </div>
</div>