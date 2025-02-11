<?php

return [

    /*
    |------------------------------------------------------------------------------------------------------------------------------------------
    | View Storage Paths
    |------------------------------------------------------------------------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'menu' => [[
        'icon' => 'fa fa-dashboard',
        'title' => 'Dashboard',
        'url' => '/dashboard',
        'permission' => 'read-dashboard',
    ], [
        'icon' => 'fa fa-headset',
        'title' => 'Pelayanan',
        'url' => 'javascript:;',
        'caret' => true,
        'permission' => 'read-pelayanan',
        'sub_menu' => [[
            'url' => '/registrasi',
            'title' => 'Registrasi',
            'route-name' => 'registrasi',
            'permission' => 'read-registrasi',
        ], [
            'url' => '/permohonan/faktur',
            'title' => 'Permohononan Faktur',
            'route-name' => 'permohonan-faktur',
            'permission' => 'read-permohonan-faktur',
        ], [
            'url' => '/daftar/usaha',
            'title' => 'Daftar Usaha',
            'route-name' => 'daftar-usaha',
            'permission' => 'read-daftar-usaha',
        ], [
            'url' => '/verifikasi/permohonan',
            'title' => 'Verifikasi Permohonan',
            'route-name' => 'verifikasi-permohonan',
            'permission' => 'read-verifikasi-permohonan',
        ], [
            'url' => '/input/ssrd',
            'title' => 'Input SSRD',
            'route-name' => 'input-ssrd',
            'permission' => 'read-input-ssrd'
        ]]
    ], [
        'icon' => 'fa fa-clipboard-check',
        'title' => 'Penetapan',
        'url' => 'javascript:;',
        'caret' => 'true',
        'permission' => 'read-penetapan',
        'sub_menu' => [[
            'url' => '/penetapan/billing',
            'title' => 'Daftar Penetapan Billing',
            'route-name' => 'penetapan-billing',
            'permission' => 'read-penetapan-billing',
        ]]
    ], [
        'icon' => 'fa fa-dollar-sign',
        'title' => 'Pembayaran',
        'url' => 'javascript:;',
        'caret' => 'true',
        'permission' => 'read-pembayaran',
        'sub_menu' => [[
            'url' => '/pembayaran/billing',
            'title' => 'Pembayaran Billing',
            'route-name' => 'pembayaran-billing',
            'permission' => 'read-pembayaran-billing',
        ]]
    ], [
        'icon' => 'fa fa-book-open',
        'title' => 'Laporan',
        'url' => 'javascript:;',
        'caret' => 'true',
        'permission' => 'read-laporan',
        'sub_menu' => [[
            'url' => '/rekap/setor/struk',
            'title' => 'Rekap Setor Karcis',
            'route-name' => 'rekap-setor-struk',
            'permission' => 'read-rekap-setor-struk',
        ], [
            'url' => '/laporan/penerimaan',
            'title' => 'Laporan Penerimaan',
            'route-name' => 'laporan-penerimaan',
            'permission' => 'read-laporan-penerimaan',
        ], [
            'url' => '/laporan/permohonan',
            'title' => 'Laporan Permohonan',
            'route-name' => 'laporan-permohonan',
            'permission' => 'read-laporan-permohonan',
        ], [
            'url' => '/laporan/stok/struk',
            'title' => 'Laporan Stok Karcis',
            'route-name' => 'laporan-stok-struk',
            'permission' => 'read-laporan-stok-struk',
        ], [
            'url' => '/laporan/pembayaran',
            'title' => 'Laporan Pembayaran Billing',
            'route-name' => 'laporan-pembayaran',
            // 'permission' => 'read-laporan-stok-struk',
            // ], [
            //     'url' => '/laporan/persediaan/struk',
            //     'title' => 'Laporan Persediaan Karcis',
            //     'route-name' => 'laporan-persediaan-struk',
            //     'permission' => 'read-laporan-persediaan-struk',
        ]]
    ], [
        'icon' => 'fa fa-cogs',
        'title' => 'Setting',
        'url' => 'javascript:;',
        'caret' => 'true',
        'permission' => 'read-setting',
        'sub_menu' => [[
            'url' => '/manajemen-user',
            'title' => 'Manajemen User',
            'route-name' => 'manajemen-user',
            'permission' => 'read-manajemen-user',
        ], [
            'url' => '/manajemen-level',
            'title' => 'Manajemen Level',
            'route-name' => 'manajemen-level',
            'permission' => 'read-manajemen-level',
        ], [
            'url' => '/manajemen-berita',
            'title' => 'Manajemen Berita',
            'route-name' => 'manajemen-berita',
            'permission' => 'read-manajemen-berita',
        ]]
    ], [
        'icon' => 'fa fa-sign-out',
        'title' => 'Logout',
        'url' => '/logout',
        'route-name' => 'logout'
    ]]
];
