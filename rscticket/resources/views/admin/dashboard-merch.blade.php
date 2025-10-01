@extends('layouts.admin')

@section('title', 'Dashboard Merch')
@section('content')
<main class="container mx-auto px-6 py-6">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Dashboard Transaksi Merchandise</h2>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="p-5 bg-white rounded-xl shadow-lg border border-blue-100">
            <h3 class="text-sm font-semibold text-gray-600 mb-1">Total Uang Masuk</h3>
            <p class="text-2xl font-bold text-blue-800">Rp{{ number_format($totalPaidAmount, 0, ',', '.') }}</p>
        </div>
        <div class="p-5 bg-white rounded-xl shadow-lg border border-green-100">
            <h3 class="text-sm font-semibold text-gray-600 mb-1">Total Paid</h3>
            <p class="text-2xl font-bold text-green-800">{{ $totalPaidCount }}</p>
        </div>
        <div class="p-5 bg-white rounded-xl shadow-lg border border-red-100">
            <h3 class="text-sm font-semibold text-gray-600 mb-1">Total Unpaid</h3>
            <p class="text-2xl font-bold text-red-800">{{ $totalUnpaidCount }}</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white p-5 rounded-xl shadow-md mb-6">
        <form method="GET" action="{{ route('admin.merch.dashboard') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-3 items-end">
            <div>
                <label for="payment_status" class="block text-xs font-medium text-gray-700">Status Pembayaran</label>
                <select id="payment_status" name="payment_status" class="form-select mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>
            <div>
                <label for="start_date" class="block text-xs font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="form-input mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="end_date" class="block text-xs font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="form-input mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="q" class="block text-xs font-medium text-gray-700">Pencarian</label>
                <input type="text" id="q" name="q" placeholder="Cari email/nama" value="{{ request('q') }}" class="form-input mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm"/>
            </div>
            <div class="flex flex-col md:flex-row gap-2 mt-4 md:mt-0">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold text-sm">Filter</button>
                <a href="{{ route('admin.merch.dashboard') }}" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold text-sm">Reset</a>
            </div>
        </form>
    </div>

    {{-- Export --}}
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('admin.merch.dashboard.export.excel', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded-md font-semibold text-sm hover:bg-green-700">Export Excel</a>
        <a href="{{ route('admin.merch.dashboard.export.pdf', request()->query()) }}" class="bg-red-600 text-white px-4 py-2 rounded-md font-semibold text-sm hover:bg-red-700" target="_blank">Export PDF</a>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600 font-semibold uppercase">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">QR Code</th>
                        <th class="px-4 py-3">Waktu Checkout</th>
                        <th class="px-4 py-3">Waktu Bayar</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-gray-50 text-gray-700">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $transaction->email }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $transaction->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">Rp{{ number_format($transaction->total_amount,0,',','.') }}</td>
                            <td class="px-4 py-2">
                                @if($transaction->qr_code)
                                    <a href="{{ route('guests.merch.qr', $transaction->kode_unik) }}" target="_blank">QR</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $transaction->checkout_time }}</td>
                            <td class="px-4 py-2">{{ $transaction->paid_time ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <button onclick="showDetail({{ $transaction->id }})" class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-xs font-medium hover:bg-blue-200 transition">Detail</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-6 text-gray-500">Tidak ada transaksi merch</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

{{-- Modal Detail Transaksi --}}
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100] p-4 transition-all duration-300">
    <div class="bg-white w-full max-w-3xl rounded-3xl shadow-2xl p-8 overflow-y-auto max-h-[90vh] transform transition-all duration-300 scale-95 opacity-0" id="detailModalContent">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Detail Transaksi Merchandise</h3>
            <button type="button" onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="detailContent" class="text-sm text-gray-700 space-y-4"></div>
        <div class="flex justify-end mt-6">
            <button type="button" onclick="closeDetailModal()" 
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 rounded-xl font-medium transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    const transactions = @json($transactions);

    function showDetail(id) {
    const transaction = transactions.find(t => t.id === id);
    if (!transaction) return;

    let html = `<h4 class="font-bold mb-2 text-gray-800 border-b pb-2">Detail Pembelian</h4>`;

    if (transaction.details.length === 0) {
        html += `<p class="text-gray-500">Tidak ada detail</p>`;
    } else {
        transaction.details.forEach(d => {
            html += `
                <div class="mt-4 border border-gray-200 p-4 rounded-xl bg-gray-50">
                    <div class="flex items-center space-x-4 mb-2">
                        ${d.varian?.image ? `<img src="${d.varian.image}" class="h-20 w-20 object-cover rounded-lg shadow-md">` : ''}
                        <div>
                            <p class="font-bold text-gray-800 text-lg">${d.product?.name ?? '-'}</p>
                            <p class="text-sm text-gray-600">${d.varian?.varian ?? '-'} - ${d.ukuran?.ukuran ?? '-'}</p>
                        </div>
                    </div>
                    <p><strong>Pembeli:</strong> ${d.buyer_name} (${d.buyer_phone ?? '-'})</p>
                    <p><strong>Qty:</strong> ${d.quantity}</p>
                    <p><strong>Subtotal:</strong> Rp${new Intl.NumberFormat('id-ID').format(d.subtotal)}</p>
                </div>
            `;
        });
    }

    document.getElementById('detailContent').innerHTML = html;
    document.getElementById('detailModal').classList.remove('hidden');
    document.getElementById('detailModalContent').classList.remove('scale-95', 'opacity-0');
    document.getElementById('detailModalContent').classList.add('scale-100', 'opacity-100');
}


    function closeDetailModal() {
        const wrapper = document.getElementById('detailModalContent');
        wrapper.classList.remove('scale-100','opacity-100');
        wrapper.classList.add('scale-95','opacity-0');
        setTimeout(() => {
            document.getElementById('detailModal').classList.add('hidden');
        }, 300);
    }
</script>
@endsection
