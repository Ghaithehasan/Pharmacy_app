<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة إدارة الصيدلية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> {{-- مكتبة الرسم البياني --}}

    {{-- CSS داخل الصفحة --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
        }

        /* القائمة الجانبية */
        .sidebar {
            width: 250px;
            background-color: #2D3748;
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 10px;
            cursor: pointer;
            transition: 0.3s;
        }
        .sidebar ul li:hover {
            background-color: #4A5568;
        }

        /* النافبار */
        .navbar {
            width: 100%;
            background-color: #1A202C;
            color: white;
            padding: 15px;
            text-align: center;
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
        }

        /* محتوى الداشبورد */
        .container {
            margin-left: 250px;
            margin-top: 60px;
            padding: 20px;
            width: 100%;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        .box {
            background-color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
            font-size: 18px;
            font-weight: bold;
        }

        .chart-container {
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
        }

        .text-green { color: #22c55e; }
        .text-blue { color: #3b82f6; }
        .text-red { color: #ef4444; }
        .text-gray { color: #6b7280; }
    </style>
</head>
<body>

    {{-- القائمة الجانبية --}}
    <div class="sidebar">
        <h2>📌 لوحة التحكم</h2>
        <ul>
            <li>🏪 <a href="{{ route('show_user') }}">user</a></li>
            <li>📈 المبيعات</li>
            <li>📦 المخزون</li>
            <li>📜 الفواتير</li>
            <li>⚙️ الإعدادات</li>
        </ul>
    </div>

    {{-- النافبار --}}
    <div class="navbar">
        <h2>لوحة إدارة الصيدلية</h2>
    </div>

    {{-- محتوى الداشبورد --}}
    <div class="container">
        <div class="grid">
            <div class="box text-green">إجمالي المبيعات: $12,450</div>
            <div class="box text-blue">إجمالي المشتريات: $9,320</div>
            <div class="box text-red">الفواتير غير المدفوعة: $2,100</div>
            <div class="box text-gray">المصاريف الشهرية: $3,400</div>
        </div>

        {{-- القسم الخاص بالمخطط البياني --}}
        <div class="chart-container">
            <h2>📊 المبيعات خلال آخر 30 يومًا</h2>
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- JavaScript داخل الصفحة --}}
    <script>
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['10/1', '10/5', '10/10', '10/15', '10/20', '10/25', '10/30'],
                datasets: [{
                    label: 'المبيعات',
                    data: [500, 1200, 900, 1500, 1700, 1100, 1300],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            }
        });
    </script>

</body>
</html>
