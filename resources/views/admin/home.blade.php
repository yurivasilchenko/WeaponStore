<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <!-- Required meta tags -->
    @include('admin.css')
</head>
<body>
<div class="container-scroller">

    <!-- partial:partials/_sidebar.html -->
    @include('admin.sidebar')
    <!-- partial -->
    @include('admin.navbar')
    @include('admin.body')
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
    @include('admin.scripts')
</body>
</html>
