@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-2xl font-bold mb-4">Laporan Transaksi</h2>

    <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            @php
                $user = auth()->user();
                $isAdmin = optional($user)->is_admin ?? (optional($user)->role === 'admin');
            @endphp

            @if($isAdmin)
            <div>
                <label class="block text-sm font-medium text-gray-700">Pilih Kantin</label>
                <select id="filter_kantin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">-- Semua Kantin --</option>
                    @foreach($kantinList as $kantin)
                        <option value="{{ $kantin->kantin_id }}" {{ request('kantin_id') == $kantin->kantin_id ? 'selected' : '' }}>
                            {{ $kantin->nama_kantin }}
                        </option>
                    @endforeach
                </select>
            </div>
            @else
            <input type="hidden" id="filter_kantin" value="{{ $user->kantin_id }}">
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700">Bulan</label>
                <input id="filter_month" type="month" value="{{ request('month') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <p class="text-xs text-gray-500 mt-1">Pilih bulan untuk melihat / mengekspor laporan</p>
            </div>

            <div class="md:col-span-3 flex gap-2 mt-2">
                <button id="exportPdfBtn" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Export PDF (bulan)</button>
                <button id="exportThisMonth" type="button" class="bg-indigo-600 text-white px-3 py-2 rounded-md hover:bg-indigo-700">Export Bulan Ini</button>
            </div>
        </div>
    </div>

    <div id="tableContainer" class="bg-white rounded-lg shadow overflow-hidden p-4">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex items-center justify-between mb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Total: Rp {{ number_format($total ?? 0, 0, ',', '.') }}</h3>
            <div class="text-sm text-gray-600">Menampilkan {{ $transaksi->total() ?? 0 }} transaksi</div>
        </div>

        <table id="lapTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                </tr>
            </thead>
            <tbody id="lapBody" class="bg-white divide-y divide-gray-200">
                @foreach($transaksi as $t)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $t->siswa->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @foreach($t->items as $item)
                            <div>{{ $item->barang->nama_barang ?? ($item->nama ?? '-') }} ({{ $item->qty }}x)</div>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div id="lapPagination" class="px-6 py-4 border-t mt-4">
            {!! $transaksi->appends(request()->query())->links() !!}
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
(function(){
    const kantinEl = document.getElementById('filter_kantin');
    const monthEl = document.getElementById('filter_month');
    const lapBody = document.getElementById('lapBody');
    const lapPagination = document.getElementById('lapPagination');
    const totalEl = document.querySelector('#tableContainer h3');

    function buildQuery(params = {}) {
        const q = new URLSearchParams();
        if (kantinEl && kantinEl.value) q.set('kantin_id', kantinEl.value);
        if (monthEl && monthEl.value) q.set('month', monthEl.value);
        if (params.page) q.set('page', params.page);
        return q.toString();
    }

    async function fetchData(params = {}) {
        const q = buildQuery(params);
        const url = '{{ route("pos.laporan") }}' + (q ? ('?'+q) : '');
        try {
            const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
            if (!res.ok) throw new Error('Network error');
            const json = await res.json();
            renderTable(json);
        } catch (e) {
            console.error(e);
            alert('Gagal memuat data. Cek console.');
        }
    }

    function renderTable(json) {
        // rows
        lapBody.innerHTML = '';
        json.data.forEach(r => {
            const tr = document.createElement('tr');

            const td1 = document.createElement('td');
            td1.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-900';
            td1.textContent = r.created_at;
            tr.appendChild(td1);

            const td2 = document.createElement('td');
            td2.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-900';
            td2.textContent = r.siswa;
            tr.appendChild(td2);

            const td3 = document.createElement('td');
            td3.className = 'px-6 py-4 text-sm text-gray-900';
            td3.innerHTML = r.items.map(i => `<div>${i.line}</div>`).join('');
            tr.appendChild(td3);

            const td4 = document.createElement('td');
            td4.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right';
            td4.textContent = 'Rp ' + r.total;
            tr.appendChild(td4);

            lapBody.appendChild(tr);
        });

        // pagination (simple)
        const meta = json.meta;
        let pagHtml = '';
        if (meta.last_page > 1) {
            if (meta.prev_page_url) pagHtml += `<a href="#" data-page="${meta.current_page-1}" class="page-link mr-2">Prev</a>`;
            pagHtml += ` Halaman ${meta.current_page} dari ${meta.last_page} `;
            if (meta.next_page_url) pagHtml += `<a href="#" data-page="${meta.current_page+1}" class="page-link ml-2">Next</a>`;
        }
        lapPagination.innerHTML = pagHtml;

        // total
        if (totalEl) totalEl.textContent = 'Total: Rp ' + (json.total_sum ?? '0');

        // attach page links
        lapPagination.querySelectorAll('.page-link').forEach(a=>{
            a.addEventListener('click', function(e){
                e.preventDefault();
                const p = this.getAttribute('data-page');
                fetchData({ page: p });
            });
        });
    }

    function generatePdfFromTable(filenamePrefix = 'laporan') {
        const container = document.createElement('div');
        container.style.padding = '20px';
        container.style.fontFamily = 'DejaVu Sans, sans-serif';

        const title = document.createElement('h3');
        title.style.textAlign = 'center';
        title.textContent = 'Laporan Transaksi';
        container.appendChild(title);

        const period = document.createElement('p');
        period.style.textAlign = 'center';
        const monthVal = monthEl && monthEl.value ? monthEl.value : '';
        if (monthVal) {
            const [y,m] = monthVal.split('-');
            const periodText = new Date(y, Number(m)-1, 1).toLocaleString('id-ID', { month: 'long', year: 'numeric' });
            period.textContent = 'Periode: ' + periodText;
        } else {
            period.textContent = 'Periode: Semua';
        }
        container.appendChild(period);

        const tbl = document.createElement('table');
        tbl.style.width = '100%';
        tbl.style.borderCollapse = 'collapse';
        tbl.style.fontSize = '12px';

        const thead = document.createElement('thead');
        thead.innerHTML = `<tr>
            <th style="border:1px solid #ccc;padding:6px">Tanggal</th>
            <th style="border:1px solid #ccc;padding:6px">Siswa</th>
            <th style="border:1px solid #ccc;padding:6px">Items</th>
            <th style="border:1px solid #ccc;padding:6px;text-align:right">Total</th>
        </tr>`;
        tbl.appendChild(thead);

        const tbody = document.createElement('tbody');
        document.querySelectorAll('#lapBody tr').forEach(r => {
            const cols = r.querySelectorAll('td');
            if (cols.length < 4) return;
            const tr = document.createElement('tr');

            const td1 = document.createElement('td'); td1.style.border='1px solid #ccc'; td1.style.padding='6px'; td1.textContent = cols[0].textContent.trim(); tr.appendChild(td1);
            const td2 = document.createElement('td'); td2.style.border='1px solid #ccc'; td2.style.padding='6px'; td2.textContent = cols[1].textContent.trim(); tr.appendChild(td2);
            const td3 = document.createElement('td'); td3.style.border='1px solid #ccc'; td3.style.padding='6px'; td3.textContent = Array.from(cols[2].querySelectorAll('div')).map(d=>d.textContent.trim()).join('\n'); tr.appendChild(td3);
            const td4 = document.createElement('td'); td4.style.border='1px solid #ccc'; td4.style.padding='6px'; td4.style.textAlign='right'; td4.textContent = cols[3].textContent.trim(); tr.appendChild(td4);

            tbody.appendChild(tr);
        });

        tbl.appendChild(tbody);
        container.appendChild(tbl);

        const opt = {
            margin:       [10,10,10,10],
            filename:     `${filenamePrefix}_${monthEl && monthEl.value ? monthEl.value.replace('-','') : (new Date().toISOString().slice(0,10))}.pdf`,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' },
            pagebreak:    { mode: ['css', 'legacy'] }
        };

        html2pdf().set(opt).from(container).save();
    }

    if (kantinEl) kantinEl.addEventListener('change', () => fetchData());
    if (monthEl) monthEl.addEventListener('change', () => fetchData());

    document.getElementById('exportPdfBtn').addEventListener('click', function(){
        generatePdfFromTable('laporan_transaksi');
    });

    document.getElementById('exportThisMonth').addEventListener('click', function(){
        const today = new Date();
        const m = today.toISOString().slice(0,7);
        monthEl.value = m;
        fetchData();
        setTimeout(()=> generatePdfFromTable('laporan_transaksi'), 600);
    });

    // initial: fetch first page only if the server-rendered table should be replaced by AJAX data
    // comment out next line if you prefer server-rendered initial table
    // fetchData();
})();
</script>
@endsection