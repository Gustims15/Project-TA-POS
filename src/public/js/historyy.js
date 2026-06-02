document.addEventListener('DOMContentLoaded', () => {
  const historyBody = document.querySelector('#historyBody');
  const historyEmpty = document.querySelector('#historyEmpty');

  const historySearch = document.querySelector('#historySearch');
  const historySearchTop = document.querySelector('#historySearchTop');
  const historyStatus = document.querySelector('#historyStatus');
  const historyDateFilter = document.querySelector('#historyDateFilter');
  const historySort = document.querySelector('#historySort');

  const statOrders = document.querySelector('#statOrders');
  const statSales = document.querySelector('#statSales');
  const statDone = document.querySelector('#statDone');
  const statAverage = document.querySelector('#statAverage');

  const exportHistory = document.querySelector('#exportHistory');
  const toast = document.querySelector('#toast');

  let historyOrders = [];
  let searchTimer = null;

  const formatRupiah = value => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      maximumFractionDigits: 0
    }).format(Number(value || 0));
  };

  const formatDateTime = value => {
    if (!value) {
      return '-';
    }

    const date = new Date(String(value).replace(' ', 'T'));

    if (Number.isNaN(date.getTime())) {
      return value;
    }

    return new Intl.DateTimeFormat('id-ID', {
      day: '2-digit',
      month: 'short',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    }).format(date);
  };

  const showToast = message => {
    if (!toast) {
      return;
    }

    toast.textContent = message;
    toast.classList.add('show');

    setTimeout(() => {
      toast.classList.remove('show');
    }, 2200);
  };

  const getStatusClass = status => {
    if (status === 'Selesai') {
      return 'done';
    }

    if (status === 'Diproses') {
      return 'process';
    }

    if (status === 'Dibatalkan') {
      return 'cancel';
    }

    return '';
  };

  const itemText = items => {
    if (!items || items.length === 0) {
      return '-';
    }

    return items.map(item => {
      const size = item.size ? ` (${item.size})` : '';
      return `${item.product_name}${size} x${item.quantity}`;
    }).join(', ');
  };

  const renderSummary = summary => {
    if (statOrders) {
      statOrders.textContent = summary?.total_order ?? 0;
    }

    if (statSales) {
      statSales.textContent = formatRupiah(summary?.total_sales ?? 0);
    }

    if (statDone) {
      statDone.textContent = summary?.done_order ?? 0;
    }

    if (statAverage) {
      statAverage.textContent = formatRupiah(summary?.average_order ?? 0);
    }
  };

  const renderHistory = orders => {
    if (!historyBody || !historyEmpty) {
      return;
    }

    historyBody.innerHTML = '';

    if (!orders || orders.length === 0) {
      historyEmpty.style.display = 'block';
      return;
    }

    historyEmpty.style.display = 'none';

    orders.forEach(order => {
      const row = document.createElement('tr');

      row.innerHTML = `
        <td>
          <strong>${order.order_code}</strong>
        </td>
        <td>${itemText(order.items)}</td>
        <td>${formatDateTime(order.ordered_at)}</td>
        <td>
          <strong>${formatRupiah(order.total_price)}</strong>
        </td>
        <td>
          <span class="status-pill ${getStatusClass(order.status)}">
            ${order.status}
          </span>
        </td>
      `;

      historyBody.appendChild(row);
    });
  };

  const buildHistoryUrl = () => {
    const url = new URL(window.NGUNJUK_ROUTES.historyApi, window.location.origin);

    const topSearch = historySearchTop?.value?.trim() || '';
    const bottomSearch = historySearch?.value?.trim() || '';
    const searchValue = bottomSearch || topSearch;

    const statusValue = historyStatus?.value || 'all';
    const dateFilterValue = historyDateFilter?.value || 'today';
    const sortValue = historySort?.value || 'latest';

    if (searchValue) {
      url.searchParams.set('search', searchValue);
    }

    url.searchParams.set('status', statusValue);
    url.searchParams.set('date_filter', dateFilterValue);
    url.searchParams.set('sort', sortValue);

    // Anti cache supaya browser tidak membaca response lama
    url.searchParams.set('_', Date.now().toString());

    return url.toString();
  };

  const loadHistory = async () => {
    try {
      const url = buildHistoryUrl();

      console.log('History API URL:', url);

      const response = await fetch(url, {
        method: 'GET',
        cache: 'no-store',
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const result = await response.json();

      if (!response.ok || !result.success) {
        throw new Error(result.message || 'Gagal mengambil data history.');
      }

      historyOrders = result.data || [];

      renderSummary(result.summary);
      renderHistory(historyOrders);
    } catch (error) {
      console.error(error);

      renderSummary({
        total_order: 0,
        total_sales: 0,
        done_order: 0,
        average_order: 0
      });

      renderHistory([]);

      showToast('Gagal mengambil data history.');
    }
  };

  const debounceLoadHistory = () => {
    clearTimeout(searchTimer);

    searchTimer = setTimeout(() => {
      const topValue = historySearchTop?.value?.trim() || '';
      const bottomValue = historySearch?.value?.trim() || '';

      if (document.activeElement === historySearchTop && historySearch) {
        historySearch.value = topValue;
      }

      if (document.activeElement === historySearch && historySearchTop) {
        historySearchTop.value = bottomValue;
      }

      loadHistory();
    }, 350);
  };

  historySearch?.addEventListener('input', debounceLoadHistory);
  historySearchTop?.addEventListener('input', debounceLoadHistory);

  historyStatus?.addEventListener('change', () => {
    loadHistory();
  });

  historyDateFilter?.addEventListener('change', () => {
    loadHistory();
  });

  historySort?.addEventListener('change', () => {
    loadHistory();
  });

  exportHistory?.addEventListener('click', () => {
    if (!historyOrders.length) {
      showToast('Tidak ada data history untuk diexport.');
      return;
    }

    const rows = [
      ['ID Order', 'Item', 'Waktu', 'Total', 'Status'],
      ...historyOrders.map(order => [
        order.order_code,
        itemText(order.items),
        formatDateTime(order.ordered_at),
        order.total_price,
        order.status
      ])
    ];

    const csvContent = rows
      .map(row => row.map(value => `"${String(value).replaceAll('"', '""')}"`).join(','))
      .join('\n');

    const blob = new Blob([csvContent], {
      type: 'text/csv;charset=utf-8;'
    });

    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');

    link.href = url;
    link.download = 'history-order-ngunjuk.csv';
    link.click();

    URL.revokeObjectURL(url);

    showToast('Data history berhasil diexport.');
  });

  loadHistory();
});