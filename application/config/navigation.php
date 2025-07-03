<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['navigation'] = [
    [
        'label' => 'Dashboard',
        'icon' => 'fas fa-notes-medical',
        'url' => 'dashboard',
        'active' => ['dashboard'],
        'role' => ['admin'],
    ],
    [
        'label' => 'Data Gejala',
        'icon' => 'fas fa-stethoscope',
        'url' => 'gejala',
        'active' => ['gejala'],
        'role' => ['admin'],
    ],
    [
        'label' => 'Data Penyakit',
        'icon' => 'fas fa-virus',
        'url' => 'penyakit',
        'active' => ['penyakit'],
        'role' => ['admin'],
    ],
    [
        'label' => 'Hasil Diagnosa',
        'icon' => 'fas fa-history',
        'url' => 'hasil',
        'active' => ['hasil'],
        'role' => ['admin'],
    ],
    [
        'label' => 'Logout',
        'icon' => 'fas fa-sign-out-alt',
        'url' => 'logout',
        'active' => ['logout'],
        'role' => ['admin', 'user'],
    ]
];
