<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Tax Claims</title>
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

<h2>Donor Tax Claims</h2>

<table id="claims-table">
    <!-- Data will be loaded here -->
</table>

<div class="pagination">
    <button id="prev-btn">Prev</button>
    <span id="current-page">1</span>
    <button id="next-btn">Next</button>
</div>

<script>
let currentPage = 1;
let totalPages = 1;

function loadPage(page) {
    fetch(`fetch_claims.php?p=${page}`)
        .then(res => res.json())
        .then(data => {
            const table = document.getElementById('claims-table');
            table.innerHTML = `
                <tr>
                    <th>ID</th>
                    <th>Payment ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>PAN</th>
                    <th>Address</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Created At</th>
                </tr>
            `;

            data.claims.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.id}</td>
                    <td>${row.payment_id}</td>
                    <td>${row.name}</td>
                    <td>${row.email}</td>
                    <td>${row.pan}</td>
                    <td>${row.address}</td>
                    <td>${parseFloat(row.amount).toFixed(2)}</td>
                    <td>${row.date}</td>
                    <td>${row.created_at}</td>
                `;
                table.appendChild(tr);
            });

            currentPage = page;
            totalPages = data.total_pages;
            document.getElementById('current-page').textContent = currentPage;
            document.getElementById('prev-btn').disabled = currentPage <= 1;
            document.getElementById('next-btn').disabled = currentPage >= totalPages;
        });
}

document.getElementById('prev-btn').addEventListener('click', () => {
    if (currentPage > 1) loadPage(currentPage - 1);
});
document.getElementById('next-btn').addEventListener('click', () => {
    if (currentPage < totalPages) loadPage(currentPage + 1);
});

loadPage(1);
</script>

</body>
</html>
