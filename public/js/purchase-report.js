
    document.addEventListener('DOMContentLoaded', function () {
    // Initialize DataTable with Ajax source
    const table = $('#purchaseTable').DataTable({
    processing: true,
    serverMethod: 'GET',
    serverSide: true,
    paging: true,
    searching: true,
    responsive: true,
    ajax: {
    url: "/purchase-report/purchase-history",
    data: function (d) {
    d.type = $('#typeFilter').val();
}
},
    columns: [
{data: 'product_name'},
{data: 'transaction_type'},
{data: 'quantity'},
{data: 'amount'},
{data: 'created_at', name: 'created_at'}
    ],
});

    $('#typeFilter').on('change', function () {
    table.ajax.reload();
});
    $(document).ready(function () {
    $.ajax({
    url: "/purchase-report/trends-data",
    method: 'GET',
    success: function (response) {
    const ctx = document.getElementById('purchaseTrendsChart').getContext('2d');
    new Chart(ctx, {
    type: 'line',
    data: {
    labels: response.labels,
    datasets: [{
    label: 'Purchase Amount',
    data: response.data,
    borderColor: 'rgba(75, 192, 192, 1)',
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    borderWidth: 2,
    tension: 0.4, // Makes the line curve smoothly
}]
},
    options: {
    responsive: true,
    plugins: {
    legend: {
    display: true,
    position: 'top'
},
},
    scales: {
    x: {
    display: true,
    title: {
    display: true,
    text: 'Date'
}
},
    y: {
    display: true,
    title: {
    display: true,
    text: 'Amount'
}
}
}
}
});
}
});
});
});
