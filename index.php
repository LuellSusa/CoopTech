<?php 
include "check.php";
require_once "conn.php"; 



// Fetch user info
$stmt = $conn->prepare("SELECT name, profile_image FROM users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['user_name'] = $user['name'] ?? 'Guest';
$_SESSION['user_image'] = $user['profile_image'] ?? 'pictures/default.jpg';
?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<main class="app-main">
  <!-- Page header -->
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Page content -->
  <div class="app-content">
    <div class="container-fluid">

      <!-- Small Box Widgets -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-primary">
            <div class="inner">
              <h3>150</h3>
              <p>New Orders</p>
            </div>
            <a href="#" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-success">
            <div class="inner">
              <h3>53<sup class="fs-5">%</sup></h3>
              <p>Bounce Rate</p>
            </div>
            <a href="#" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-warning">
            <div class="inner">
              <h3>44</h3>
              <p>User Registrations</p>
            </div>
            <a href="#" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-danger">
            <div class="inner">
              <h3>65</h3>
              <p>Unique Visitors</p>
            </div>
            <a href="#" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
          </div>
        </div>
      </div>

      <!-- Example chart card -->
      <div class="row">
        <div class="col-lg-7 connectedSortable">
          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Sales Value</h3></div>
            <div class="card-body"><div id="revenue-chart"></div></div>
          </div>
        </div>
      </div>

    </div>
  </div>
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="./js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"></script>

<!-- Demo chart -->
<script>
const sales_chart_options = {
  series: [
    { name: 'Digital Goods', data: [28, 48, 40, 19, 86, 27, 90] },
    { name: 'Electronics', data: [65, 59, 80, 81, 56, 55, 40] },
  ],
  chart: { height: 300, type: 'area', toolbar: { show: false } },
  stroke: { curve: 'smooth' },
  colors: ['#0d6efd', '#20c997'],
  dataLabels: { enabled: false },
  xaxis: { type: 'datetime', categories: ['2023-01-01','2023-02-01','2023-03-01','2023-04-01','2023-05-01','2023-06-01','2023-07-01'] },
  tooltip: { x: { format: 'MMMM yyyy' } },
};
new ApexCharts(document.querySelector('#revenue-chart'), sales_chart_options).render();
</script>