

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="savepdf.php" target="_blank"><i class="fa fa-file fa-fw"></i>Save PDF of final order list</a>
            </li>
            <li style="display: none">
                <a href="#"><i class="fa fa-file-excel-o fa-fw"></i>Export to Excel</a>
            </li>
            <li>
                <a href="email.php"><i class="fa fa-envelope fa-fw"></i>Email final order list</a>
            </li>
            <li>
                <a href="#" onclick="window.print();return false;"><i class="fa fa-print fa-fw"></i>Print final order list</a>
            </li>
            <li>
                <a href="sizes.php<?php if(isset($sdn) && !empty($sdn)) echo '?usid='.$sdn; ?>"><i class="fa fa-table fa-fw"></i>Sizes</a>
            </li>
            <li>
                <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>