@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section ('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <style>
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-gray-100 font-[Inter,sans-serif] min-h-screen text-gray-800">


<main class="container mx-auto px-6 py-6">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Dashboard Transaksi Admin</h2>

    {{-- Ringkasan Paid / Unpaid / Total Uang Masuk --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Total Uang Masuk --}}
        <div class="flex items-center justify-between bg-white rounded-xl shadow-lg p-5 border border-blue-100 transform hover:scale-105 transition duration-300 ease-in-out">
            <div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Total Uang Masuk</h3>
                <p class="text-2xl font-bold text-blue-800">Rp{{ number_format($totalPaidAmount, 0, ',', '.') }}</p>
            </div>
            <div class="bg-blue-600 text-white w-12 h-12 flex items-center justify-center rounded-full text-lg shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.592 1L21 12h-3.82c-.403 0-.795.047-1.18.138L13 16.5m-8 2.5a.5.5 0 11-1 0 .5.5 0 011 0zm0 0V9a2 2 0 012-2h4a2 2 0 012 2v7.5m-4-7.5l-4-3m4 3l4 3m-4 3v4.5zm0 0a.5.5 0 11-1 0 .5.5 0 011 0z" />
                </svg>
            </div>
        </div>
        {{-- Total Paid --}}
        <div class="flex items-center justify-between bg-white rounded-xl shadow-lg p-5 border border-green-100 transform hover:scale-105 transition duration-300 ease-in-out">
            <div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Total Pembayaran Berhasil</h3>
                <p class="text-2xl font-bold text-green-800">{{ $totalPaidCount }}</p>
            </div>
            <div class="bg-green-600 text-white w-12 h-12 flex items-center justify-center rounded-full text-lg shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        {{-- Total Unpaid --}}
        <div class="flex items-center justify-between bg-white rounded-xl shadow-lg p-5 border border-red-100 transform hover:scale-105 transition duration-300 ease-in-out">
            <div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Total Belum Dibayar</h3>
                <p class="text-2xl font-bold text-red-800">{{ $totalUnpaidCount }}</p>
            </div>
            <div class="bg-red-600 text-white w-12 h-12 flex items-center justify-center rounded-full text-lg shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-md mb-6">
    <form method="GET" action="{{ route('admin.dashboard') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-3 items-end">
        {{-- Pilih Event --}}
        <div>
            <label for="event_id" class="block text-xs font-medium text-gray-700">Pilih Event</label>
            <select id="event_id" name="event_id"
                    class="form-select mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm">
                <option value="">-- Semua Event --</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                        {{ $event->title }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal Mulai --}}
        <div>
            <label for="start_date" class="block text-xs font-medium text-gray-700">Tanggal Mulai</label>
            <input type="date" id="start_date" name="start_date"
                   value="{{ request('start_date') }}"
                   class="form-input mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm">
        </div>

        {{-- Tanggal Selesai --}}
        <div>
            <label for="end_date" class="block text-xs font-medium text-gray-700">Tanggal Selesai</label>
            <input type="date" id="end_date" name="end_date"
                   value="{{ request('end_date') }}"
                   class="form-input mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm">
        </div>

        {{-- Status Pembayaran --}}
        <div>
            <label for="payment_status" class="block text-xs font-medium text-gray-700">Status Pembayaran</label>
            <select id="payment_status" name="payment_status"
                    class="form-select mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm">
                <option value="">-- Semua Status --</option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
            </select>
        </div>

        {{-- Urutkan Berdasarkan --}}
        <div>
            <label for="sort_by" class="block text-xs font-medium text-gray-700">Urutkan Berdasarkan</label>
            <select id="sort_by" name="sort_by"
                    class="form-select mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm">
                <option value="">-- Urutkan --</option>
                <option value="event_title" {{ request('sort_by') === 'event_title' ? 'selected' : '' }}>Judul Acara</option>
                <option value="email" {{ request('sort_by') === 'email' ? 'selected' : '' }}>Email</option>
                <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Nama</option>
                <option value="payment_status" {{ request('sort_by') === 'payment_status' ? 'selected' : '' }}>Status</option>
                <option value="checkout_time" {{ request('sort_by') === 'checkout_time' ? 'selected' : '' }}>Waktu Checkout</option>
            </select>
        </div>

        {{-- Pencarian --}}
        <div>
            <label for="q" class="block text-xs font-medium text-gray-700">Pencarian</label>
            <input type="text" id="q" name="q" placeholder="Cari email/nama"
                   value="{{ request('q') }}"
                   class="form-input mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm"/>
        </div>

        {{-- Tombol --}}
        <div class="flex flex-col md:flex-row gap-2 mt-4 md:mt-0">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold text-sm transition-colors shadow-sm">
                Filter
            </button>
            <a href="{{ route('admin.dashboard') }}"
               class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold text-sm transition-colors text-center">
                Reset
            </a>
        </div>
    </form>
</div>


    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('admin.dashboard.export.excel', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded-md font-semibold text-sm hover:bg-green-700 transition-colors shadow-sm">Export Excel (XLSX)</a>
        <a href="{{ route('admin.dashboard.export.pdf', request()->query()) }}" class="bg-red-600 text-white px-4 py-2 rounded-md font-semibold text-sm hover:bg-red-700 transition-colors shadow-sm" target="_blank">Export PDF</a>
     </div>
         <form action="{{ route('admin.transactions.regenerate-qr') }}" method="POST"
          onsubmit="return confirm('Apakah Anda yakin ingin regenerate semua QR Code? Ini akan replace file lama.')">
        @csrf
        <button type="submit"
                class="bg-purple-600 text-white px-4 py-2 rounded-md font-semibold text-sm hover:bg-purple-700 transition-colors shadow-sm">
            Regenerate Semua QR
        </button>
    </form>

    <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600 font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3">No.</th>
                        <th class="px-4 py-3">Judul Acara</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Waktu Checkout</th>
                        <th class="px-4 py-3">Waktu Pembayaran</th>
                        <th class="px-4 py-3">Status Pembayaran</th>
                        <th class="px-4 py-3">Total Jumlah</th>
                        <th class="px-4 py-3">QR Code</th>
                        <th class="px-4 py-3">Jumlah Tiket</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-gray-50 text-gray-700 transition-colors duration-150">
                            <td class="px-4 py-1.5 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-4 py-1.5 whitespace-nowrap">{{ $transaction->event->title ?? '-' }}</td>
                            <td class="px-4 py-1.5 whitespace-nowrap">{{ $transaction->email }}</td>
                            <td class="px-4 py-1.5 whitespace-nowrap">{{ $transaction->checkout_time }}</td>
                            <td class="px-4 py-1.5 whitespace-nowrap">{{ $transaction->paid_time ?? '-' }}</td>
                            <td class="px-4 py-1.5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $transaction->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </td>
                            <td class="px-4 py-1.5 whitespace-nowrap">Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-1.5 whitespace-nowrap">
                                @if($transaction->qr_code)
                                    <a href="{{ route('guests.qr', $transaction->kode_unik) }}" target="_blank"
                                       class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                        </svg>
                                        QR
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-1.5 whitespace-nowrap">{{ $transaction->attendees->count() }}</td>
                            <td class="px-4 py-1.5 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    <button onclick="showDetail({{ $transaction->id }})"
                                            class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Detail</span>
                                    </button>
                                    <form id="regenerate-form-{{ $transaction->id }}"
                                          action="{{ route('admin.transactions.regenerateQR', $transaction->id) }}"
                                          method="POST" class="inline-block">
                                        @csrf
                                        <button type="button"
                                                onclick="openConfirmModal({{ $transaction->id }})"
                                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                            <span>Regenerate QR</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-gray-500 py-6">Tidak ada transaksi yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

{{-- Modal Detail --}}
<div id="detailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-xl max-w-lg w-full transform transition-all duration-300 scale-95 opacity-0" id="modalContentWrapper">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Detail Pembeli Tiket</h3>
        <div id="modalContent" class="max-h-80 overflow-y-auto custom-scrollbar text-sm"></div>
        <button onclick="closeModal()" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold transition-colors">Tutup</button>
    </div>
</div>

{{-- Modal Konfirmasi --}}
<div id="confirmModal"
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96 transform scale-95 transition-transform duration-300">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi</h2>
        <p class="text-gray-600 mb-6">Yakin mau generate ulang QR untuk transaksi ini?</p>
        <div class="flex justify-end gap-2">
            <button onclick="closeConfirmModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                Batal
            </button>
            <button id="confirmButton"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Ya, Generate
            </button>
        </div>
    </div>
</div>

{{-- Popup Notifikasi Sukses / Error --}}
@if(session('success') || session('error'))
    <div id="notificationPopup"
         class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50
                {{ session('success') ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}
                px-6 py-3 rounded-lg shadow-lg opacity-0 transition-opacity duration-500">
        {{ session('success') ?? session('error') }}
    </div>
@endif

<script>
    function showDetail(transactionId) {
        const transactions = @json($transactions);
        const transaction = transactions.find(t => t.id === transactionId);

        if (!transaction) return;

        let html = '';
        if (transaction.attendees.length === 0) {
            html = '<p class="text-gray-500 italic text-center">Tidak ada data pembeli tiket.</p>';
        } else {
            html = `
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-3 py-2 font-semibold text-gray-600 text-left">Nama</th>
                            <th class="px-3 py-2 font-semibold text-gray-600 text-left">Nomor HP</th>
                            <th class="px-3 py-2 font-semibold text-gray-600 text-left">ID Tiket</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        ${transaction.attendees.map(a => `
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-3 py-2">${a.name}</td>
                                <td class="px-3 py-2">${a.phone_number ?? '-'}</td>
                                <td class="px-3 py-2">${a.ticket_id}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
            `;
        }

        document.getElementById('modalContent').innerHTML = html;
        const modal = document.getElementById('detailModal');
        const modalContent = document.getElementById('modalContentWrapper');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 50);
    }

    function closeModal() {
        const modal = document.getElementById('detailModal');
        const modalContent = document.getElementById('modalContentWrapper');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    let selectedFormId = null;
    const confirmModal = document.getElementById("confirmModal");
    const confirmModalContent = confirmModal.querySelector("div");

    function openConfirmModal(transactionId) {
        selectedFormId = "regenerate-form-" + transactionId;
        confirmModal.classList.remove("hidden");
        confirmModal.classList.add("flex");

        setTimeout(() => {
            confirmModal.classList.remove("opacity-0");
            confirmModalContent.classList.remove("scale-95");
            confirmModalContent.classList.add("scale-100");
        }, 10);
    }

    function closeConfirmModal() {
        confirmModal.classList.add("opacity-0");
        confirmModalContent.classList.remove("scale-100");
        confirmModalContent.classList.add("scale-95");

        setTimeout(() => {
            confirmModal.classList.add("hidden");
            confirmModal.classList.remove("flex");
            selectedFormId = null;
        }, 300);
    }

    document.getElementById("confirmButton").addEventListener("click", function () {
        if (selectedFormId) {
            document.getElementById(selectedFormId).submit();
        }
    });

    confirmModal.addEventListener("click", function(e) {
        if (e.target === confirmModal) {
            closeConfirmModal();
        }
    });

    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") {
            closeConfirmModal();
            closeModal();
        }
    });

    // popup notifikasi auto-hide
    window.addEventListener("DOMContentLoaded", () => {
        const notif = document.getElementById("notificationPopup");
        if (notif) {
            setTimeout(() => notif.classList.remove("opacity-0"), 100); // fade-in
            setTimeout(() => notif.classList.add("opacity-0"), 4000);   // fade-out
            setTimeout(() => notif.remove(), 4500); // hapus dari DOM
        }
    });
</script>

</body>
@endsection
</html>