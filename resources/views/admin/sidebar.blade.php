<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="navbar-brand custom-brand" href="/"><h2>Weapon <em>Store</em></h2></a>
    </div>
    <ul class="nav custom-navigation">

        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{url('showorder')}}">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
                <span class="menu-title">Orders</span>
            </a>
        </li>


        <li class="nav-item menu-items">
            <a class="nav-link" href="{{url('products')}}">
              <span class="menu-icon">
                <i class="mdi mdi-file-document-box"></i>
              </span>
                <span class="menu-title">Add Products</span>
            </a>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" href="{{url('showproducts')}}">
              <span class="menu-icon">
                <i class="mdi mdi-file-document-box"></i>
              </span>
                <span class="menu-title">All Products</span>
            </a>
        </li>
    </ul>
</nav>
