<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{ asset('backend/assets/js/dashborad.js') }}"></script>

<script>
    const metricsUrl = "{{ route('admin.dashboard.metrics') }}";
    let revenueChart = null;

    function renderRevenueChart(dailyRevenue) {
        const labels = dailyRevenue.map(i => i.date);
        const data = dailyRevenue.map(i => i.total);

        const options = {
            chart: { type: 'area', height: 300, toolbar: { show: false }, foreColor: '#59595A', },
            series: [{ name: 'Revenue', data }],
            xaxis: { categories: labels, },
            yaxis: { labels: { formatter: val => parseFloat(val).toFixed(2), } },
            dataLabels: { enabled: false },
            tooltip: { y: { formatter: val => `€${parseFloat(val).toFixed(2)}` } }
        };

        if (revenueChart) {
            revenueChart.updateOptions({ xaxis: { categories: labels }, series: [{ data }] });
        } else {
            revenueChart = new ApexCharts(document.querySelector("#revenueChart"), options);
            revenueChart.render();
        }
    }
    function buildTopProductsTable(rows) {
        const $table = $('#topProductsTable').DataTable();
        $table.clear();
        rows.forEach(r => {
            const revenue = parseFloat(r.total_revenue ?? 0) || 0;
            $table.row.add({
                title: r.title,
                total_sold: r.total_sold ?? 0,
                total_revenue: `€${revenue.toFixed(2)}`
            });
        });
        $table.draw();
    }


    function refreshWidgets(range = 30) {
        $('#refreshBtn').prop('disabled', true).text('Refreshing...');
        $.get(metricsUrl, { range })
            .done(function (res) {
                $('#usersCount').text(new Intl.NumberFormat().format(res.counts.users));
                $('#ordersCount').text(new Intl.NumberFormat().format(res.counts.orders));
                $('#productsCount').text(new Intl.NumberFormat().format(res.counts.products));
                $('#salesToday').text(`€${Number(res.counts.sales_today).toFixed(2)}`);
                $('#totalIncome').text(`€${Number(res.sales_summary.total_income ?? 0).toFixed(2)}`);

                renderRevenueChart(res.daily_revenue);
                buildTopProductsTable(res.top_products);

                // trending searches
                // const $list = $('#trendingSearches').empty();
                // res.searches.forEach(s => $list.append(`<li>${s.keyword} <small class="text-muted">(${s.count})</small></li>`));
            })
            .always(function () {
                $('#refreshBtn').prop('disabled', false).text('Refresh');
            });
    }

    $(document).ready(function () {
        // initialize datatables
        $('#topProductsTable').DataTable({
            paging: false,
            searching: false,
            info: false,
            order: [[1, 'desc']],
            columns: [
                { data: 'title' },
                { data: 'total_sold' },
                { data: 'total_revenue' }
            ]
        });

        // initial render
        const initData = @json($daily_revenue);
        renderRevenueChart(initData);

        $('#rangeSelect').change(function () {
            refreshWidgets($(this).val());
        });

        $('#refreshBtn').click(function () {
            refreshWidgets($('#rangeSelect').val());
        });

        // export behaviour (simple CSV export of top products)
        $('#exportBtn').click(function (e) {
            e.preventDefault();

            const table = $('#topProductsTable').DataTable();
            const rows = table.rows().data().toArray();

            if (!rows.length) {
                alert("No data to export!");
                return;
            }

            let csv = "Product,Sold,Revenue\n";

            rows.forEach(r => {
                const title = (r.title ?? '').replace(/,/g, '');
                const sold = r.total_sold ?? 0;
                const revenue = (r.total_revenue ?? '').replace('€', '');
                csv += `${title},${sold},${revenue}\n`;
            });

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'top-products.csv';
            document.body.appendChild(a);
            a.click();
            a.remove();
            URL.revokeObjectURL(url);
        });

    });
</script>