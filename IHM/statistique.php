<?php
// Include your database connection
include "../public/template.php";

// Fetch total sales
$totalSales = getTotalSales($link);

// Fetch total number of orders
$totalOrders = getTotalOrders($link);

// Fetch monthly sales data for the chart
$MonthlySales = getMonthlySales($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Statistics</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    
    <main>
        <h1>Statistiques Ventes</h1>

        <!-- Display Total Sales and Total Orders -->
        <div class="statistics">
            <div>
                <h2>Total Ventes</h2>
                <p><?php echo number_format($totalSales, 2); ?> DH</p>
            </div>
            <div>
                <h2>Total Commandes</h2>
                <p><?php echo $totalOrders; ?></p>
            </div>
        </div>

        <!-- Chart for Monthly Sales -->
        <h2>Ventes mensuelles</h2>
        <canvas id="monthlySalesChart"></canvas>                
    </main>

    <script>
        // Chart.js configuration
        const ctx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($MonthlySales['labels']); ?>,
                datasets: [{
                    label: 'Monthly Sales',
                    data: <?php echo json_encode($MonthlySales['data']); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>