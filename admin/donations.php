<!DOCTYPE html>
<html>
<head>
    <title>Donations List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .pagination {
            margin-top: 15px;
            text-align: center;
        }
        .pagination button {
            padding: 6px 12px;
            margin: 0 2px;
            cursor: pointer;
        }
        .pagination button:disabled {
            background-color: #eee;
            color: #777;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<h2>Donations Table</h2>

<table id="donations-table">
    <!-- Table rows will be loaded via JS -->
</table>

<div class="pagination">
    <button id="prev-btn">Prev</button>
    <span id="current-page">1</span>
    <button id="next-btn">Next</button>
</div>

<script>
let currentPage = 1;
const limit = 5;
let totalPages = 1; // Will update from server

function loadPage(page) {
    fetch(`fetch_donations.php?page=${page}`)
        .then(response => response.json())
        .then(data => {
            const table = document.getElementById('donations-table');
            table.innerHTML = '';

            // Add table header
            const header = `<tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Razorpay Payment ID</th>
                                <th>Razorpay Order ID</th>
                                <th>Status</th>
                                <th>Donated At</th>
                            </tr>`;
            table.innerHTML = header;

            // Add rows
            data.donations.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.id}</td>
                    <td>${row.name}</td>
                    <td>${row.email}</td>
                    <td>${row.phone}</td>
                    <td>${parseFloat(row.amount).toFixed(2)}</td>
                    <td>${row.razorpay_payment_id}</td>
                    <td>${row.razorpay_order_id}</td>
                    <td>${row.status}</td>
                    <td>${row.donated_at}</td>
                `;
                table.appendChild(tr);
            });

            // Update pagination
            currentPage = page;
            totalPages = data.total_pages;
            document.getElementById('current-page').textContent = currentPage;
            document.getElementById('prev-btn').disabled = currentPage <= 1;
            document.getElementById('next-btn').disabled = currentPage >= totalPages;
        });
}

// Event listeners
document.getElementById('prev-btn').addEventListener('click', () => {
    if (currentPage > 1) loadPage(currentPage - 1);
});

document.getElementById('next-btn').addEventListener('click', () => {
    if (currentPage < totalPages) loadPage(currentPage + 1);
});

// Load first page on start
loadPage(1);
</script>

</body>
</html>
