<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="user-pro">
                    <a class="has-arrow waves-effect waves-dark d-flex no-block" href="javascript:void(0)" aria-expanded="false">
                        <img src="{{asset('images/users/1.jpg')}}" alt="user-img" class="img-circle">
                        <span class="hide-menu text-truncate ">{{ Auth::user()->name }}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <router-link :to="{name: 'spa'}"><i class="ti-user"></i> Perfil</router-link>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form-menu').submit();">
                                <i class="fa fa-power-off"></i> {{ __('Logout') }}
                            </a>
                            <!-- text-->
                            <form id="logout-form-menu" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                {{-- <div class="dropdown-divider"></div> --}}
                {{-- <li>
                    <router-link class="waves-effect waves-dark" :to="{ name: 'spa.dashboard'}" aria-expanded="false">
                        <i class="icon-speedometer"></i>
                        <span class="hide-menu">Dashboard </span>
                    </router-link>
                </li> --}}
                {{-- @if (in_array(Auth::user()->idrol, Rule::ADMINISTRATORS_ACCESS) && Auth::user()->idcuenta == Rule::SYSTEM_COMPANY_ACCOUNT) --}}
                @if (Auth::user()->idrol == Rule::SYSTEM_ADMIN_ROLE && Auth::user()->idcuenta == Rule::SYSTEM_COMPANY_ACCOUNT)
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="ti-panel"></i>
                        <span class="hide-menu">Sistema</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.rol'}">Rol</router-link></li>
                        <li><router-link :to="{name: 'spa.cuenta'}">Cuenta</router-link></li>
                        <li><router-link :to="{name: 'spa.empresa'}">Empresa</router-link></li>
                        <li><router-link :to="{name: 'spa.tipoAtencion'}">Tipo de atención</router-link></li>
                        <li><router-link :to="{name: 'spa.tipoEvento'}">Tipo de Evento</router-link></li>
                        <li><router-link :to="{name: 'spa.administrarcliente'}">Administrar Cliente</router-link></li>
                        <li><router-link :to="{name: 'spa.logerror'}">Log Error</router-link></li>
                    </ul>
                </li>
                @endif

                @if (in_array(Auth::user()->idrol, Rule::ADMINISTRATORS_ACCESS))
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-user-lock"></i>
                        <span class="hide-menu">Administrador</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.user'}">Usuario</router-link></li>
                        <li><router-link :to="{name: 'spa.campania'}">Campañas</router-link></li>
                        <li><router-link :to="{name: 'spa.evento'}">Eventos</router-link></li>
                        <li><router-link :to="{name: 'spa.alerta'}">Alertas</router-link></li>
                    </ul>
                </li>
                <!-- <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-graduation-cap"></i>
                        <span class="hide-menu">Instituciones</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.instituciones'}">Institución</router-link></li>
                        <li><router-link :to="{name: 'spa.tipoconfirmacion'}">Tipo Confirmacion</router-link></li>
                        <li><router-link :to="{name: 'spa.atencioninstitucion'}">Gestionar</router-link></li>
                        <li><router-link :to="{name: 'spa.invitacion'}">Invitacion</router-link></li>
                    </ul>
                </li> -->

                <li>
                    <router-link class="waves-effect waves-dark" :to="{name: 'spa.import'}" aria-expanded="false">
                        <i class="ti-server"></i>
                        <span class="hide-menu">Importar Registros</span>
                    </router-link>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-user-edit"></i>
                        <span class="hide-menu">Ofertas laborales</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.empleo'}">Empleos</router-link></li>
                        <li><router-link :to="{name: 'spa.cliente'}">Postulantes</router-link></li>
                        <li><router-link :to="{name: 'spa.atencion'}">Gestionar</router-link></li>

                        <!-- <li><router-link :to="{name: 'spa.invitacion'}">Invitacion</router-link></li> -->
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-comment-alt"></i>
                        <span class="hide-menu">Chat</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.conexion'}">Conexión</router-link></li>
                        <li><router-link :to="{name: 'spa.chat'}">Salas</router-link></li>
                        <li><router-link :to="{name: 'spa.moderador'}">Moderador</router-link></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                    <i class="fas fa-chart-pie"></i>
                        <span class="hide-menu">Prospección</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.reporte'}">Informe - reportes</router-link></li>
                    </ul>
                </li>
                @endif
                @if  (in_array(Auth::user()->idrol, Rule::ASESOR_ACCESS))
                <!-- <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-graduation-cap"></i>
                        <span class="hide-menu">Instituciones</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.instituciones'}">Institución</router-link></li>
                        <li><router-link :to="{name: 'spa.atencioninstitucion'}">Gestionar</router-link></li>
                        <li><router-link :to="{name: 'spa.invitacion'}">Invitacion</router-link></li>
                    </ul>

                </li> -->
                <li>
                    <router-link class="waves-effect waves-dark" :to="{name: 'spa.import'}" aria-expanded="false">
                        <i class="ti-server"></i>
                        <span class="hide-menu">Importar Registros</span>
                    </router-link>
                </li>
                @endif

                @if  (in_array(Auth::user()->idrol, Rule::STANDARD_ACCESS))
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-user-edit"></i>
                        <span class="hide-menu">Registros</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.cliente'}">Registros</router-link></li>
                        <!-- <li><router-link :to="{name: 'spa.atencion'}">Gestionar</router-link></li> -->
                    </ul>
                </li>
                <li>
                    <router-link class="waves-effect waves-dark" :to="{name: 'spa.import'}" aria-expanded="false">
                        <i class="ti-server"></i>
                        <span class="hide-menu">Importar Registros</span>
                    </router-link>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-comment-alt"></i>
                        <span class="hide-menu">Chat</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.conexion'}">Conexión</router-link></li>
                        <li><router-link :to="{name: 'spa.chat'}">Salas</router-link></li>
                        <li><router-link :to="{name: 'spa.moderador'}">Moderador</router-link></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                    <i class="fas fa-chart-pie"></i>
                        <span class="hide-menu">Prospección</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.reporte'}">Informe - reportes</router-link></li>
                    </ul>
                </li>
                @endif

                <!-- Empresa -->
                @if (in_array(Auth::user()->idrol, Rule::EMPRESAS_ACESS))
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-user-edit"></i>
                            <span class="hide-menu">Ofertas laborales</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li><router-link :to="{name: 'spa.empleo'}">Empleos</router-link></li>
                            <li><router-link :to="{name: 'spa.cliente'}">Postulantes</router-link></li>
                            <li><router-link :to="{name: 'spa.importempleo'}">Importar Empleo</router-link></li>
                        </ul>
                    </li>
                @endif

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
