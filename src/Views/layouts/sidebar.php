<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="/dashboard"><img src="https://sou.montink.com/wp-content/uploads/2024/04/logo.png" alt="Logo"></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item <?= (end(array_filter(explode('/', $_SERVER['REQUEST_URI']))) == 'dashboard' ? 'active' : '') ?>">
                    <a href="dashboard" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Back Office</li>

                <li class="sidebar-item has-sub <?= (in_array(end(array_filter(explode('/', $_SERVER['REQUEST_URI']))), ['produtos', 'cupons']) ? 'active' : '') ?>">
                    <a href="produtos.php" class="sidebar-link">
                        <i class="bi bi-box-seam"></i>
                        <span>Produtos</span>
                    </a>
                    <ul class="submenu <?= (in_array(end(array_filter(explode('/', $_SERVER['REQUEST_URI']))), ['produtos', 'cupons']) ? 'active' : '') ?>">
                        <li class="submenu-item <?= (end(array_filter(explode('/', $_SERVER['REQUEST_URI']))) == 'produtos' ? 'active' : '')?> " >
                            <a href="/produtos">
                                <i class="bi bi-cart-fill"></i> Comprar
                            </a>
                        </li>
                        <li class="submenu-item <?= (end(array_filter(explode('/', $_SERVER['REQUEST_URI']))) == 'cupons' ? 'active' : '')?> ">
                            <a href="/cupons">
                                <i class="bi bi-tag-fill"></i> Cupons
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item <?= (end(array_filter(explode('/', $_SERVER['REQUEST_URI']))) == 'pedidos' ? 'active' : '')?> ">
                    <a href="/pedidos" class='sidebar-link'>
                        <i class="bi bi-basket-fill"></i>
                        <span>Pedidos</span>
                    </a>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>