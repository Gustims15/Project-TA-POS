document.addEventListener('DOMContentLoaded', () => {
  const historyBody = document.querySelector('#historyBody');
  const historyEmpty = document.querySelector('#historyEmpty');

  const historySearch = document.querySelector('#historySearch');
  const historySearchTop = document.querySelector('#historySearchTop');
  const historyStatus = document.querySelector('#historyStatus');
  const historyDateFilter = document.querySelector('#historyDateFilter');
  const historySort = document.querySelector('#historySort');

  const historyPagination = document.querySelector('#historyPagination');
  const historyPrevPage = document.querySelector('#historyPrevPage');
  const historyNextPage = document.querySelector('#historyNextPage');
  const historyPageInfo = document.querySelector('#historyPageInfo');

  const statProductsSold = document.querySelector('#statProductsSold');
  const statOrders = document.querySelector('#statOrders');
  const statSales = document.querySelector('#statSales');

  const exportHistory = document.querySelector('#exportHistory');
  const toast = document.querySelector('#toast');

  const invoiceModal = document.querySelector('#invoiceModal');
  const invoiceModalBackdrop = document.querySelector('#invoiceModalBackdrop');
  const closeInvoiceModal = document.querySelector('#closeInvoiceModal');
  const closeInvoiceModalBottom = document.querySelector('#closeInvoiceModalBottom');
  const printInvoice = document.querySelector('#printInvoice');

  const invoiceOrderCode = document.querySelector('#invoiceOrderCode');
  const invoiceCode = document.querySelector('#invoiceCode');
  const invoiceDate = document.querySelector('#invoiceDate');
  const invoiceStatus = document.querySelector('#invoiceStatus');
  const invoiceItems = document.querySelector('#invoiceItems');
  const invoiceTotalItem = document.querySelector('#invoiceTotalItem');
  const invoiceTotalPrice = document.querySelector('#invoiceTotalPrice');

  let historyOrders = [];
  let selectedOrder = null;
  let searchTimer = null;

  let currentPage = 1;
  const perPage = 10;

  const getHistoryTableBody = () => {
    return document.querySelector('body.history-page .history-table tbody');
  };

  const updateHistoryPaginationVisibility = () => {
    if (!historyPagination) {
      return;
    }

    const tableBody = getHistoryTableBody();

    if (!tableBody || !historyOrders.length) {
      historyPagination.classList.remove('show-at-bottom');
      return;
    }

    const canScroll = tableBody.scrollHeight > tableBody.clientHeight + 4;
    const isAtBottom = tableBody.scrollTop + tableBody.clientHeight >= tableBody.scrollHeight - 6;

    if (!canScroll || isAtBottom) {
      historyPagination.classList.add('show-at-bottom');
    } else {
      historyPagination.classList.remove('show-at-bottom');
    }
  };

  const resetHistoryTableScroll = () => {
    const tableBody = getHistoryTableBody();

    if (tableBody) {
      tableBody.scrollTop = 0;
    }

    historyPagination?.classList.remove('show-at-bottom');
  };

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

  const escapeHTML = value => {
    return String(value ?? '')
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
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
      const note = item.note ? ` | Catatan: ${item.note}` : '';

      return `${item.product_name}${size} x${item.quantity}${note}`;
    }).join(', ');
  };

  const itemHtml = items => {
    if (!items || items.length === 0) {
      return '<span class="history-item-empty">-</span>';
    }

    const firstItem = items[0];
    const remainingItems = items.slice(1);
    const firstNote = firstItem.note ? escapeHTML(firstItem.note) : '';

    return `
      <div class="history-item-summary">
        <div class="history-item-summary-main">
          <strong>${escapeHTML(firstItem.product_name)}</strong>
          <span>${escapeHTML(firstItem.size || 'Regular')} • x${Number(firstItem.quantity || 0)}</span>
        </div>

        ${firstNote
          ? `
            <div class="history-item-summary-note">
              Catatan: ${firstNote}
            </div>
          `
          : ''
        }

        ${remainingItems.length > 0
          ? `
            <button
              type="button"
              class="history-more-items history-more-toggle"
            >
              +${remainingItems.length} item lainnya
            </button>

            <div class="history-extra-items">
              ${remainingItems.map(item => {
                const note = item.note ? escapeHTML(item.note) : '';

                return `
                  <div class="history-extra-item-card">
                    <div class="history-extra-item-main">
                      <div>
                        <strong>${escapeHTML(item.product_name)}</strong>
                        <span>${escapeHTML(item.size || 'Regular')} • x${Number(item.quantity || 0)}</span>
                      </div>

                      <b>${formatRupiah(item.subtotal || 0)}</b>
                    </div>

                    ${note
                      ? `
                        <div class="history-item-summary-note">
                          Catatan: ${note}
                        </div>
                      `
                      : ''
                    }
                  </div>
                `;
              }).join('')}
            </div>
          `
          : ''
        }
      </div>
    `;
  };

  const renderSummary = summary => {
    if (statProductsSold) {
      statProductsSold.textContent = `${summary?.today_products_sold ?? 0} item`;
    }

    if (statOrders) {
      statOrders.textContent = summary?.today_total_order ?? 0;
    }

    if (statSales) {
      statSales.textContent = formatRupiah(summary?.today_total_sales ?? 0);
    }
  };

  const getPaginatedOrders = orders => {
    const startIndex = (currentPage - 1) * perPage;
    const endIndex = startIndex + perPage;

    return orders.slice(startIndex, endIndex);
  };

  const renderPagination = orders => {
    if (!historyPagination || !historyPrevPage || !historyNextPage || !historyPageInfo) {
      return;
    }

    const totalData = orders.length;
    const totalPage = Math.max(1, Math.ceil(totalData / perPage));

    historyPagination.style.display = totalData > 0 ? 'flex' : 'none';

    historyPageInfo.textContent = `Halaman ${currentPage} dari ${totalPage}`;

    historyPrevPage.disabled = currentPage <= 1;
    historyNextPage.disabled = currentPage >= totalPage;

    historyPagination.classList.remove('show-at-bottom');

    requestAnimationFrame(() => {
      updateHistoryPaginationVisibility();
    });
  };

  const renderHistory = orders => {
    if (!historyBody || !historyEmpty) {
      return;
    }

    historyBody.innerHTML = '';

    if (!orders || orders.length === 0) {
      historyEmpty.style.display = 'block';

      if (historyPagination) {
        historyPagination.style.display = 'none';
        historyPagination.classList.remove('show-at-bottom');
      }

      return;
    }

    historyEmpty.style.display = 'none';

    const paginatedOrders = getPaginatedOrders(orders);

    paginatedOrders.forEach(order => {
      const row = document.createElement('tr');

      row.innerHTML = `
        <td>
          <strong>${escapeHTML(order.order_code)}</strong>
        </td>

        <td>
          ${itemHtml(order.items)}
        </td>

        <td>${formatDateTime(order.ordered_at)}</td>

        <td>
          <strong>${formatRupiah(order.total_price)}</strong>
        </td>

        <td>
          <span class="status-pill ${getStatusClass(order.status)}">
            ${escapeHTML(order.status)}
          </span>
        </td>

        <td>
          <button
            type="button"
            class="history-detail-btn"
            data-order-code="${escapeHTML(order.order_code)}"
          >
            Detail / Struk
          </button>
        </td>
      `;

      historyBody.appendChild(row);
    });

    renderPagination(orders);

    requestAnimationFrame(() => {
      updateHistoryPaginationVisibility();
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

      currentPage = 1;
      resetHistoryTableScroll();

      renderSummary(result.summary);
      renderHistory(historyOrders);
    } catch (error) {
      console.error(error);

      renderSummary({
        today_products_sold: 0,
        today_total_order: 0,
        today_total_sales: 0
      });

      renderHistory([]);

      showToast('Gagal mengambil data history.');
    }
  };

  const renderInvoice = order => {
    if (!order) {
      return;
    }

    const totalItem = Array.isArray(order.items)
      ? order.items.reduce((total, item) => total + Number(item.quantity || 0), 0)
      : 0;

    selectedOrder = order;

    invoiceOrderCode.textContent = order.order_code || '-';
    invoiceCode.textContent = order.order_code || '-';
    invoiceDate.textContent = formatDateTime(order.ordered_at);
    invoiceStatus.textContent = order.status || '-';
    invoiceTotalItem.textContent = `${totalItem} item`;
    invoiceTotalPrice.textContent = formatRupiah(order.total_price || 0);

    invoiceItems.innerHTML = Array.isArray(order.items) && order.items.length
      ? order.items.map(item => {
        const note = item.note ? escapeHTML(item.note) : '';

        return `
          <div class="invoice-item-row">
            <div>
              <strong>${escapeHTML(item.product_name)}</strong>
              <span>${escapeHTML(item.size || 'Regular')} • x${Number(item.quantity || 0)}</span>

              ${note
                ? `
                  <p class="invoice-item-note">
                    Catatan: ${note}
                  </p>
                `
                : ''
              }
            </div>

            <b>${formatRupiah(item.subtotal || 0)}</b>
          </div>
        `;
      }).join('')
      : '<div class="invoice-item-row"><span>Item tidak tersedia.</span></div>';
  };

  const openInvoice = orderCode => {
    const order = historyOrders.find(item => item.order_code === orderCode);

    if (!order) {
      showToast('Detail order tidak ditemukan.');
      return;
    }

    renderInvoice(order);

    invoiceModal?.classList.add('show');
    invoiceModalBackdrop?.classList.add('show');
  };

  const closeInvoice = () => {
    invoiceModal?.classList.remove('show');
    invoiceModalBackdrop?.classList.remove('show');
  };

  const buildPrintHtml = order => {
    const totalItem = Array.isArray(order.items)
      ? order.items.reduce((total, item) => total + Number(item.quantity || 0), 0)
      : 0;

    const itemRows = Array.isArray(order.items)
      ? order.items.map(item => {
        const note = item.note
          ? `<div class="note">Catatan: ${escapeHTML(item.note)}</div>`
          : '';

        return `
          <div class="item">
            <div class="item-title">
              <strong>${escapeHTML(item.product_name)}</strong>
            </div>

            <div class="item-meta">
              <span>${escapeHTML(item.size || 'Regular')} x${Number(item.quantity || 0)}</span>
              <span>${formatRupiah(item.price || 0)}</span>
            </div>

            ${note}

            <div class="item-subtotal">
              <span>Subtotal</span>
              <strong>${formatRupiah(item.subtotal || 0)}</strong>
            </div>
          </div>
        `;
      }).join('')
      : '';

    return `
      <!DOCTYPE html>
      <html lang="id">
      <head>
        <meta charset="UTF-8">
        <title>Struk ${escapeHTML(order.order_code)}</title>
        <style>
          * {
            box-sizing: border-box;
          }

          body {
            margin: 0;
            padding: 18px;
            font-family: Arial, sans-serif;
            color: #1f1f1f;
            background: #ffffff;
          }

          .receipt {
            width: 300px;
            margin: 0 auto;
          }

          .center {
            text-align: center;
          }

          .brand {
            margin-bottom: 4px;
            font-size: 21px;
            font-weight: 800;
            letter-spacing: 1px;
          }

          .brand span {
            color: #e8733d;
          }

          .subtitle {
            font-size: 11px;
            line-height: 1.4;
            color: #666666;
          }

          .line {
            border-top: 1px dashed #999999;
            margin: 12px 0;
          }

          .info {
            display: grid;
            gap: 6px;
            font-size: 12px;
          }

          .info div,
          .total div,
          .item-meta,
          .item-subtotal {
            display: flex;
            justify-content: space-between;
            gap: 10px;
          }

          .info span,
          .total span {
            color: #555555;
          }

          .item {
            padding-bottom: 10px;
            margin-bottom: 10px;
            border-bottom: 1px dashed #dddddd;
            font-size: 12px;
          }

          .item:last-child {
            border-bottom: 0;
            margin-bottom: 0;
            padding-bottom: 0;
          }

          .item-title strong {
            display: block;
            font-size: 13px;
            line-height: 1.35;
          }

          .item-meta {
            margin-top: 4px;
            color: #666666;
          }

          .note {
            margin-top: 6px;
            padding: 6px 7px;
            border-radius: 6px;
            background: #f4f4f4;
            color: #444444;
            font-size: 11px;
            line-height: 1.35;
          }

          .item-subtotal {
            margin-top: 6px;
            font-size: 12px;
          }

          .item-subtotal strong {
            font-size: 12px;
          }

          .total {
            display: grid;
            gap: 7px;
            font-size: 13px;
          }

          .grand {
            padding-top: 7px;
            border-top: 1px dashed #999999;
            font-size: 15px;
            font-weight: 800;
          }

          .thanks {
            margin-top: 14px;
            font-size: 12px;
            line-height: 1.5;
            text-align: center;
          }

          .small {
            margin-top: 4px;
            color: #666666;
            font-size: 10px;
            text-align: center;
          }

          @media print {
            @page {
              size: 80mm auto;
              margin: 4mm;
            }

            body {
              padding: 0;
            }

            .receipt {
              width: 100%;
            }
          }
        </style>
      </head>

      <body>
        <div class="receipt">
          <div class="center">
            <div class="brand"><span>Ngun</span>juk POS</div>
            <div class="subtitle">
              Sistem Informasi Kasir<br>
              UMKM Ngunjuk
            </div>
          </div>

          <div class="line"></div>

          <div class="info">
            <div>
              <span>Order</span>
              <strong>${escapeHTML(order.order_code)}</strong>
            </div>

            <div>
              <span>Waktu</span>
              <strong>${formatDateTime(order.ordered_at)}</strong>
            </div>

            <div>
              <span>Status</span>
              <strong>${escapeHTML(order.status || '-')}</strong>
            </div>
          </div>

          <div class="line"></div>

          ${itemRows}

          <div class="line"></div>

          <div class="total">
            <div>
              <span>Total Item</span>
              <strong>${totalItem} item</strong>
            </div>

            <div class="grand">
              <span>Total</span>
              <strong>${formatRupiah(order.total_price || 0)}</strong>
            </div>
          </div>

          <div class="line"></div>

          <div class="thanks">
            Terima kasih sudah berbelanja.
          </div>

          <div class="small">
            Struk ini dicetak otomatis oleh Ngunjuk POS.
          </div>
        </div>

        <script>
          window.onload = function () {
            window.print();

            setTimeout(function () {
              window.close();
            }, 500);
          };
        <\/script>
      </body>
      </html>
    `;
  };

  const printSelectedInvoice = () => {
    if (!selectedOrder) {
      showToast('Pilih order terlebih dahulu.');
      return;
    }

    const printWindow = window.open('', '_blank', 'width=420,height=680');

    if (!printWindow) {
      showToast('Popup print diblokir browser.');
      return;
    }

    printWindow.document.open();
    printWindow.document.write(buildPrintHtml(selectedOrder));
    printWindow.document.close();
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

  historyBody?.addEventListener('click', event => {
    const moreButton = event.target.closest('.history-more-toggle');

    if (moreButton) {
      const wrapper = moreButton.closest('.history-item-summary');
      const extraItems = wrapper?.querySelector('.history-extra-items');

      if (!wrapper || !extraItems) {
        return;
      }

      wrapper.classList.toggle('show-extra');

      const isOpen = wrapper.classList.contains('show-extra');
      const itemCount = extraItems.querySelectorAll('.history-extra-item-card').length;

      moreButton.textContent = isOpen
        ? 'Tutup item lainnya'
        : `+${itemCount} item lainnya`;

      requestAnimationFrame(() => {
        updateHistoryPaginationVisibility();
      });

      return;
    }

    const detailButton = event.target.closest('.history-detail-btn');

    if (!detailButton) {
      return;
    }

    openInvoice(detailButton.dataset.orderCode);
  });

  closeInvoiceModal?.addEventListener('click', closeInvoice);
  closeInvoiceModalBottom?.addEventListener('click', closeInvoice);
  invoiceModalBackdrop?.addEventListener('click', closeInvoice);
  printInvoice?.addEventListener('click', printSelectedInvoice);

  document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
      closeInvoice();
    }
  });

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

  historyPrevPage?.addEventListener('click', () => {
    if (currentPage <= 1) {
      return;
    }

    currentPage -= 1;
    resetHistoryTableScroll();
    renderHistory(historyOrders);
  });

  historyNextPage?.addEventListener('click', () => {
    const totalPage = Math.max(1, Math.ceil(historyOrders.length / perPage));

    if (currentPage >= totalPage) {
      return;
    }

    currentPage += 1;
    resetHistoryTableScroll();
    renderHistory(historyOrders);
  });

  document.addEventListener(
    'scroll',
    event => {
      if (event.target?.matches?.('body.history-page .history-table tbody')) {
        updateHistoryPaginationVisibility();
      }
    },
    true
  );

  window.addEventListener('resize', () => {
    updateHistoryPaginationVisibility();
  });

  loadHistory();
});