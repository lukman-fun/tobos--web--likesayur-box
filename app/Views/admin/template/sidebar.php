<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                <svg version="1.1" id="logo" class="navbar-brand-img brand-sm text-base" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                    <g>
                        <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                        <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                        <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                    </g>
                </svg>
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 <?= onActiveMenu('') ?>">
                <a class="nav-link <?= onActiveMenu('') ?>" href="<?= base_url('admin'); ?>">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item w-100 <?= onActiveMenu('users') ?>">
                <a class="nav-link <?= onActiveMenu('users') ?>" href="<?= base_url('admin/users'); ?>">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">Management Users</span>
                </a>
            </li>
            <li class="nav-item w-100 <?= onActiveMenu('slider') ?>">
                <a class="nav-link <?= onActiveMenu('slider') ?>" href="<?= base_url('admin/slider'); ?>">
                    <i class="fe fe-wind fe-16"></i>
                    <span class="ml-3 item-text">Management Slider</span>
                </a>
            </li>
            <li class="nav-item w-100 <?= onActiveMenu('category') ?>">
                <a class="nav-link <?= onActiveMenu('category') ?>" href="<?= base_url('admin/category'); ?>">
                    <i class="fe fe-list fe-16"></i>
                    <span class="ml-3 item-text">Management Category</span>
                </a>
            </li>
            <!-- <li class="nav-item w-100 <?= onActiveMenu('product') ?>">
                <a class="nav-link <?= onActiveMenu('product') ?>" href="<?= base_url('admin/product'); ?>">
                    <i class="fe fe-inbox fe-16"></i>
                    <span class="ml-3 item-text">Management Product</span>
                </a>
            </li> -->
            <li class="nav-item dropdown <?= onActiveMenu('product') ?>">
                <a href="#management-product" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link <?= onActiveMenu('product') ?>">
                    <i class="fe fe-inbox fe-16"></i>
                    <span class="ml-3 item-text">Management Product</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="management-product">
                    <li class="nav-item">
                        <a class="nav-link pl-3 <?= onActiveMenu('product') ?>" href="<?= base_url('admin/product'); ?>"><span class="ml-1 item-text">Product</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?= base_url('admin/supplier'); ?>"><span class="ml-1 item-text">Supplier</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item w-100 <?= onActiveMenu('transaction') ?>">
                <a class="nav-link <?= onActiveMenu('transaction') ?>" href="<?= base_url('admin/transaction'); ?>">
                    <i class="fe fe-shopping-bag fe-16"></i>
                    <span class="ml-3 item-text">Management Transaction</span>
                </a>
            </li>
            <!-- <li class="nav-item w-100 <?= onActiveMenu('content') ?>">
                <a class="nav-link <?= onActiveMenu('content') ?>" href="<?= base_url('admin/content'); ?>">
                    <i class="fe fe-layout fe-16"></i>
                    <span class="ml-3 item-text">Management Content</span>
                </a>
            </li> -->
            <li class="nav-item dropdown <?= onActiveMenu('content') ?> <?= onActiveMenu('content-preview') ?> <?= onActiveMenu('content-items') ?>">
                <a href="#management-content" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link <?= onActiveMenu('content') ?> <?= onActiveMenu('content-preview') ?> <?= onActiveMenu('content-items') ?>">
                    <i class="fe fe-layout fe-16"></i>
                    <span class="ml-3 item-text">Management Content</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="management-content">
                    <li class="nav-item">
                        <a class="nav-link pl-3 <?= onActiveMenu('content') ?> <?= onActiveMenu('content-items') ?>" href="<?= base_url('admin/content'); ?>"><span class="ml-1 item-text">Content</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3 <?= onActiveMenu('content-preview') ?>" href="<?= base_url('admin/content-preview'); ?>"><span class="ml-1 item-text">Content Preview</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown <?= onActiveMenu('pengaturan-kurir') ?> <?= onActiveMenu('pengaturan-profile') ?> <?= onActiveMenu('pengaturan-waktu') ?>">
                <a href="#pengaturan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link <?= onActiveMenu('pengaturan-kurir') ?> <?= onActiveMenu('pengaturan-profile') ?> <?= onActiveMenu('pengaturan-waktu') ?>">
                    <i class="fe fe-settings fe-16"></i>
                    <span class="ml-3 item-text">Pengaturan</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="pengaturan">
                    <li class="nav-item">
                        <a class="nav-link pl-3 <?= onActiveMenu('pengaturan-kurir') ?>" href="<?= base_url('admin/pengaturan-kurir'); ?>"><span class="ml-1 item-text">Kurir</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3 <?= onActiveMenu('pengaturan-waktu') ?>" href="<?= base_url('admin/pengaturan-waktu'); ?>"><span class="ml-1 item-text">Waktu Pengiriman</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3 <?= onActiveMenu('pengaturan-system') ?>" href="<?= base_url('admin/pengaturan-system'); ?>"><span class="ml-1 item-text">System</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3 <?= onActiveMenu('pengaturan-profile') ?>" href="<?= base_url('admin/pengaturan-profile'); ?>"><span class="ml-1 item-text">Profile</span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>