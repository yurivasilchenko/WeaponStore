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
                                            <form class="nav-link mt-2 mt-md-0 search" method="GET" action="{{route('showorder')}}">
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
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" disabled>
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
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input">
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
                                                <div class="order-status">
                                                    @if($orders->status == 'Approved')
                                                        <span class="status-approved">{{$orders->status}}</span>
                                                    @elseif($orders->status == 'Disapproved')
                                                        <span class="status-disapproved">{{$orders->status}}</span>
                                                    @elseif($orders->status == 'Pending')
                                                        <span class="status-pending">{{$orders->status}}</span>
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
        function handleAction(button, urlSuffix, successClass, removeClasses) {
            console.log("Button clicked:", button);

            // Get all checked checkboxes
            const checkedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            console.log(checkedCheckboxes);

            // If no checkboxes are checked, exit the function early
            if (checkedCheckboxes.length === 0) {
                console.log("No checkboxes selected.");
                return;
            }

            // Disable the button while requests are being sent
            button.disabled = true;

            // Process each checked checkbox
            checkedCheckboxes.forEach(function(checkbox) {
                let row = checkbox.closest('tr');
                let orderId = row.getAttribute('data-id');
                fetch(`/showorder/${urlSuffix}/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        let statusContainer = row.querySelector('.order-status span');
                        if (statusContainer) {
                            // Update text content
                            statusContainer.textContent = urlSuffix.charAt(0).toUpperCase() + urlSuffix.slice(1) + "d";

                            // Update classes
                            statusContainer.classList.remove(...removeClasses);
                            statusContainer.classList.add(successClass);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            // Re-enable the button after all requests complete
            Promise.all(checkedCheckboxes).finally(() => {
                button.disabled = false;
            });
        }

        // Approve selected rows
        document.querySelector('.btn-approve-all').addEventListener('click', function() {
            handleAction(this, 'approve', 'status-approved', ['status-disapproved', 'status-pending']);
        });

        // Disapprove selected rows
        document.querySelector('.btn-disapprove-all').addEventListener('click', function() {
            handleAction(this, 'disapprove', 'status-disapproved', ['status-approved', 'status-pending']);
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
