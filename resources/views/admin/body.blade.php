<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_navbar.html -->

    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card custom-card">
                        <div class="card-body py-0 px-0 px-sm-3">
                            <div class="row align-items-center">
                                <div class="col-4 col-sm-3 col-xl-2">
                                    <img src="admin/assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
                                </div>

                                <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                                    <ul class="navbar-nav w-100">
                                        <li class="nav-item w-100">
                                            <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" method="GET" action="{{route('showorder')}}">
                                                <input type="text" class="form-control" name="query" placeholder="Email">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row ">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Order Status</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check form-check-muted m-0">
                                                <label class="form-check-label">

                                                </label>
                                            </div>
                                        </th>
                                        <th> Client Name </th>
                                        <th> Client Email </th>
                                        <th> Client Phone </th>
                                        <th> Client Address </th>
                                        <th> Product Name </th>
                                        <th> Type </th>
                                        <th> Quantity </th>
                                        <th> Price </th>
                                        <th> Image</th>
                                        <th> Status</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order as $orders)
                                        <tr data-id="{{ $orders->id }}">
                                            <td>
                                                <div class="form-check form-check-muted m-0">
                                                    <label class="form-check-label">
                                                        <input type="checkbox"  class="form-check-input">
                                                    </label>
                                                </div>
                                            </td>
                                            <td><span class="ps-2">{{$orders->name}}</span></td>
                                            <td>{{$orders->email}}</td>
                                            <td>{{$orders->phone}}</td>
                                            <td>{{$orders->address}}</td>
                                            <td>{{$orders->product_name}}</td>
                                            <td>{{$orders->type}}</td>
                                            <td>{{$orders->quantity}}</td>
                                            <td>{{$orders->price}}</td>
                                            <td>
                                                @if(!empty($orders->image))
                                                    @php
                                                        $images = json_decode($orders->image);
                                                        $firstImage = isset($images[0]) ? $images[0] : null;
                                                    @endphp
                                                    @if(!empty($firstImage))
                                                        <img class="custom-img" src="/productimages/{{$firstImage}}">
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <div class="badge">
                                                    @if($orders->status == 'Approved')
                                                        <div class="badge badge-outline-success">{{$orders->status}}</div>
                                                    @elseif($orders->status == 'Disapproved')
                                                        <div class="badge badge-outline-danger">{{$orders->status}}</div>
                                                    @elseif($orders->status == 'Pending')
                                                        <div class="badge badge-outline-warning">{{$orders->status}}</div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                                <!-- Action buttons outside of the table -->
                                <div class="action-buttons">
                                    <button class="btn btn-success btn-approve-all">Approve Selected</button>
                                    <button class="btn btn-warning btn-disapprove-all">Disapprove Selected</button>
                                    <button class="btn btn-danger btn-delete-all">Delete Selected</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <!-- 3 blocks, hidden -->
            <div class="row">
                <div class="col-md-6 col-xl-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between">
                                <h4 class="card-title">Messages</h4>
                                <p class="text-muted mb-1 small">View all</p>
                            </div>
                            <div class="preview-list">
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <img src="admin/assets/images/faces/face6.jpg" alt="image" class="rounded-circle" />
                                    </div>
                                    <div class="preview-item-content d-flex flex-grow">
                                        <div class="flex-grow">
                                            <div class="d-flex d-md-block d-xl-flex justify-content-between">
                                                <h6 class="preview-subject">Leonard</h6>
                                                <p class="text-muted text-small">5 minutes ago</p>
                                            </div>
                                            <p class="text-muted">Well, it seems to be working now.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <img src="admin/assets/images/faces/face8.jpg" alt="image" class="rounded-circle" />
                                    </div>
                                    <div class="preview-item-content d-flex flex-grow">
                                        <div class="flex-grow">
                                            <div class="d-flex d-md-block d-xl-flex justify-content-between">
                                                <h6 class="preview-subject">Luella Mills</h6>
                                                <p class="text-muted text-small">10 Minutes Ago</p>
                                            </div>
                                            <p class="text-muted">Well, it seems to be working now.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <img src="admin/assets/images/faces/face9.jpg" alt="image" class="rounded-circle" />
                                    </div>
                                    <div class="preview-item-content d-flex flex-grow">
                                        <div class="flex-grow">
                                            <div class="d-flex d-md-block d-xl-flex justify-content-between">
                                                <h6 class="preview-subject">Ethel Kelly</h6>
                                                <p class="text-muted text-small">2 Hours Ago</p>
                                            </div>
                                            <p class="text-muted">Please review the tickets</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <img src="admin/assets/images/faces/face11.jpg" alt="image" class="rounded-circle" />
                                    </div>
                                    <div class="preview-item-content d-flex flex-grow">
                                        <div class="flex-grow">
                                            <div class="d-flex d-md-block d-xl-flex justify-content-between">
                                                <h6 class="preview-subject">Herman May</h6>
                                                <p class="text-muted text-small">4 Hours Ago</p>
                                            </div>
                                            <p class="text-muted">Thanks a lot. It was easy to fix it .</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Portfolio Slide</h4>
                            <div class="owl-carousel owl-theme full-width owl-carousel-dash portfolio-carousel" id="owl-carousel-basic">
                                <div class="item">
                                    <img src="admin/assets/images/dashboard/Rectangle.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img src="admin/assets/images/dashboard/Img_5.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img src="admin/assets/images/dashboard/img_6.jpg" alt="">
                                </div>
                            </div>
                            <div class="d-flex py-4">
                                <div class="preview-list w-100">
                                    <div class="preview-item p-0">
                                        <div class="preview-thumbnail">
                                            <img src="admin/assets/images/faces/face12.jpg" class="rounded-circle" alt="">
                                        </div>
                                        <div class="preview-item-content d-flex flex-grow">
                                            <div class="flex-grow">
                                                <div class="d-flex d-md-block d-xl-flex justify-content-between">
                                                    <h6 class="preview-subject">CeeCee Bass</h6>
                                                    <p class="text-muted text-small">4 Hours Ago</p>
                                                </div>
                                                <p class="text-muted">Well, it seems to be working now.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted">Well, it seems to be working now. </p>
                            <div class="progress progress-md portfolio-progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">To do list</h4>
                            <div class="add-items d-flex">
                                <input type="text" class="form-control todo-list-input" placeholder="enter task..">
                                <button class="add btn btn-primary todo-list-add-btn">Add</button>
                            </div>
                            <div class="list-wrapper">
                                <ul class="d-flex flex-column-reverse text-white todo-list todo-list-custom">
                                    <li>
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Create invoice </label>
                                        </div>
                                        <i class="remove mdi mdi-close-box"></i>
                                    </li>
                                    <li>
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Meeting with Alita </label>
                                        </div>
                                        <i class="remove mdi mdi-close-box"></i>
                                    </li>
                                    <li class="completed">
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox" checked> Prepare for presentation </label>
                                        </div>
                                        <i class="remove mdi mdi-close-box"></i>
                                    </li>
                                    <li>
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Plan weekend outing </label>
                                        </div>
                                        <i class="remove mdi mdi-close-box"></i>
                                    </li>
                                    <li>
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Pick up kids from school </label>
                                        </div>
                                        <i class="remove mdi mdi-close-box"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2021</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin template</a> from Bootstrapdash.com</span>
            </div>
        </footer>
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Approve selected rows
        document.querySelector('.btn-approve-all').addEventListener('click', function() {
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(function(checkbox) {
                let row = checkbox.closest('tr');
                let orderId = row.getAttribute('data-id');
                fetch(`/showorder/approve/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        let badgeContainer = row.querySelector('.badge'); // Select the outer badge container
                        if (badgeContainer) {
                            let badge = badgeContainer.querySelector('.badge'); // Select the inner badge div
                            console.log(badge);
                            if (badge) {
                                badge.textContent = 'Approved'; // Update the text content
                                badge.classList.remove('badge-outline-danger', 'badge-outline-warning');
                                badge.classList.add('badge-outline-success');
                            }
                        }
                    });
            });
        });

        // Disapprove selected rows
        document.querySelector('.btn-disapprove-all').addEventListener('click', function() {
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(function(checkbox) {
                let row = checkbox.closest('tr');
                let orderId = row.getAttribute('data-id');
                fetch(`/showorder/disapprove/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        let badgeContainer = row.querySelector('.badge'); // Select the outer badge container
                        if (badgeContainer) {
                            let badge = badgeContainer.querySelector('.badge'); // Select the inner badge div
                            console.log(badge);
                            if (badge) {
                                badge.textContent = 'Disapproved';
                                badge.classList.remove('badge-outline-success', 'badge-outline-warning');
                                badge.classList.add('badge-outline-danger');
                            }
                        }
                    });
            });
        });

        // Delete selected rows
        document.querySelector('.btn-delete-all').addEventListener('click', function() {
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(function(checkbox) {
                let row = checkbox.closest('tr');
                let orderId = row.getAttribute('data-id');
                fetch(`/showorder/delete/${orderId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                        }
                    });
            });
        });
    });


</script>
