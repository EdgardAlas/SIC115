<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">SCI115</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">SCI</a>
        </div>
        <ul class="sidebar-menu">

            <!--boton de cierre-->

            <?php
            $sesion = new Session();
            $login = $sesion->get('login');
            $fecha_inicial = strtotime(date($login['anio']."-m-d",time()));
            $fecha_final = strtotime(date($login['anio']."-m-d",time()));

            //esto es para validar que no aparezca el boton de cierre cuando no sea la fecha inidicada
            if ($fecha_inicial>=$fecha_final && $login['estado']!=='CERRADO') {
                ?>

                <li class="menu-header">Cierre Contable</li>
                <li>
                    <a class="nav-link" href="/cierre-contable"><i class="fas fa-exclamation-circle"></i> <span>Cierre Contable</span></a>
                </li>
                <?php
            } ?>

            <li class="menu-header">Catálogo de Cuentas</li>
            <li>
                <a class="nav-link" href="/cuenta"><i class="fas fa-stream"></i> <span>Catálogo de Cuentas</span></a>
            </li>
            <li class="menu-header">Periodos</li>
            <li>
                <a class="nav-link" href="/periodo"><i class="fas fa-calendar-alt"></i> <span>Periodos</span></a>
            </li>
            <li class="menu-header">Libros Contables</li>
            <li>
                <a class="nav-link" href="/libro-diario"><i class="fas fa-book"></i> <span>Libro Diario</span></a>
            </li>
            <li class="nav-item dropdown">
                <a href="/libro-mayor" class="nav-link"><i class="fas fa-book"></i> <span>Libro Mayor</span></a>
            </li>
            <li class="nav-item dropdown">
                <a href="/balanza-comprobacion" class="nav-link"><i class="fas fa-book"></i> <span>Balanza de
                        Comprobación</span></a>
            </li>

            <li class="menu-header">Estados Financieros</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-file-invoice-dollar"></i> <span>Balance General</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/balance-general/forma/cuenta"><i
                                    class="fas fa-file-invoice-dollar"></i>Forma de cuenta</a></li>
                    <li><a class="nav-link" href="/balance-general/forma/reporte"><i
                                    class="fas fa-file-invoice-dollar"></i>Forma de Reporte</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="estadoresultados" class="nav-link"><i class="fas fa-file-invoice-dollar"></i><span>Estado de
                        Resultados</span></a>
            </li>

            <li class="menu-header">Configuración</li>
            <li>
                <a class="nav-link" href="/configuracion"><i class="fas fa-cogs"></i> <span>Configurar
                        Cuentas</span></a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"></i> <span>Backup</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="restaurar.php"><i class="fas fa-save"></i> Crear Backup</a></li>
                    <li><a class="nav-link" href="bootstrap-badge.html"><i class="fas fa-file-upload"></i> Restaurar</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!--<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fas fa-rocket"></i> Documentation
        </a>
    </div>-->
    </aside>
</div>