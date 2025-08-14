<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?php echo files(); ?>/src/images/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">dbTrebol </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo files(); ?>/src/images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $_SESSION['userData']['profileNames'];?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->


                <?php

                if (isset($_SESSION['permissions'][5]['r']) && $_SESSION['permissions'][5]['r'] === 1): ?>
                    <li class="nav-item">
                        <a href="<?php echo router(); ?>dashboard" class="nav-link">
                            <i class="fa-solid fa-chalkboard"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php
                if (isset($_SESSION['permissions'][4]['r']) && $_SESSION['permissions'][4]['r'] === 1): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-users"></i>
                            <p>
                                Usuarios
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <?php
                            if (isset($_SESSION['permissions'][4]['r']) && $_SESSION['permissions'][4]['r'] === 1): ?>
                                <li class="nav-item">
                                    <a href="<?php echo router(); ?>users" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Usuarios</p>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php
                            if (isset($_SESSION['permissions'][3]['r']) && $_SESSION['permissions'][3]['r'] === 1): ?>
                                <li class="nav-item">
                                    <a href="<?php echo router(); ?>roles" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php
                if (isset($_SESSION['permissions'][6]['r']) && $_SESSION['permissions'][6]['r'] === 1): ?>
                    <li class="nav-item">
                        <a href="<?php echo router(); ?>payrolls" class="nav-link">
                            <i class="fa-regular fa-credit-card"></i>
                            <p>
                                Planilla
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php
                if (isset($_SESSION['permissions'][7]['r']) && $_SESSION['permissions'][7]['r'] === 1): ?>
                    <li class="nav-item">
                        <a href="<?php echo router(); ?>attendances" class="nav-link">
                            <i class="fa-solid fa-calendar-check"></i>
                            <p>
                                Asistencias
                            </p>
                        </a>
                    </li>
                <?php endif; ?>


                <?php
                if (isset($_SESSION['permissions'][1]['r']) && $_SESSION['permissions'][1]['r'] === 1): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-user-tie"></i>
                            <p>
                                Empleados
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo router(); ?>employees" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Empleados</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo router(); ?>hours" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Horarios</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo router(); ?>attendances" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Asistencias</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Simple Link
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo router(); ?>logout" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Log Out
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>