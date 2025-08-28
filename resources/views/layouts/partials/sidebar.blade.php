<div class="app-sidebar">
     <!-- Sidebar Logo -->
     <div class="logo-box">
          <a href="{{ route('any', 'index') }}" class="logo-dark">
               <img src="/images/logo-sm.png" class="logo-sm" alt="logo sm">
               <img src="/images/logo-dark.png" class="logo-lg" alt="logo dark">
          </a>

          <a href="{{ route('any', 'index') }}" class="logo-light">
               <img src="/images/logo-sm.png" class="logo-sm" alt="logo sm">
               <img src="/images/logo-light.png" class="logo-lg" alt="logo light">
          </a>
     </div>

     <div class="scrollbar" data-simplebar>

          <ul class="navbar-nav" id="navbar-nav">

               <li class="menu-title">Menu...</li>

               <li class="nav-item">
                    <a class="nav-link" href="{{ route('any', 'index') }}
">
                         <span class="nav-icon">
                              <iconify-icon icon="mingcute:home-3-line"></iconify-icon>
                         </span>
                         <span class="nav-text"> Dashboard </span>
                    </a>
               </li>
              <li class="nav-item">
                  <a class="nav-link menu-arrow" href="#nuSmartCard" data-bs-toggle="collapse" role="button"
                     aria-expanded="false" aria-controls="nuSmartCard">
                         <span class="nav-icon">
                              <iconify-icon icon="mingcute:user-3-line"></iconify-icon>
                         </span>
                      <span class="nav-text"> Nu Smart Card </span>
                  </a>
                  <div class="collapse" id="nuSmartCard">
                      <ul class="nav sub-navbar-nav">
                          <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route ('nu-smart-card.index') }}">All List</a>
                          </li>
                          <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('nu-smart-card.all-cards') }}">All ID Cards</a>
                          </li>
                          <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route ('blood-group.index') }}">Blood Group</a>
                          </li>
                          <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('departments.index') }}">Department</a>
                          </li>
                          <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('designations.index') }}">Designation</a>
                          </li>
                          <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('id-card.settings') }}">ID Card Settings</a>
                          </li>
                      </ul>
                  </div>
              </li>
              <li class="nav-item">
                  <a class="nav-link menu-arrow" href="#appearances" data-bs-toggle="collapse" role="button"
                     aria-expanded="false" aria-controls="appearances">
                         <span class="nav-icon">
                              <iconify-icon icon="mingcute:user-3-line"></iconify-icon>
                         </span>
                      <span class="nav-text"> Appearances </span>
                  </a>
                  <div class="collapse" id="appearances">
                      <ul class="nav sub-navbar-nav">
                          <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route ('manage-menus') }}">Menus</a>
                          </li>
                      </ul>
              </div>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('settings.index') }}">
                       <span class="nav-icon">
                            <iconify-icon icon="mingcute:settings-3-line"></iconify-icon>
                       </span>
                       <span class="nav-text"> Settings </span>
                  </a>
              </li>

               <li class="menu-title">UI Kit...</li>

               <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarBaseUI" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="sidebarBaseUI">
                         <span class="nav-icon"><iconify-icon icon="mingcute:leaf-line"></iconify-icon></span>
                         <span class="nav-text"> Base UI </span>
                    </a>
                    <div class="collapse" id="sidebarBaseUI">
                         <ul class="nav sub-navbar-nav">
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','accordion']) }}">Accordion</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','alerts']) }}">Alerts</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','avatar']) }}">Avatar</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','badge']) }}">Badge</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','breadcrumb']) }}">Breadcrumb</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','buttons']) }}">Buttons</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','card']) }}">Card</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','carousel']) }}">Carousel</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','collapse']) }}">Collapse</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','dropdown']) }}">Dropdown</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','list-group']) }}">List Group</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','modal']) }}">Modal</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','tabs']) }}">Tabs</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','offcanvas']) }}">Offcanvas</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','pagination']) }}">Pagination</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','placeholders']) }}">Placeholders</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','popovers']) }}">Popovers</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','progress']) }}">Progress</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','scrollspy']) }}">Scrollspy</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','spinners']) }}">Spinners</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','toasts']) }}">Toasts</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['ui','tooltips']) }}">Tooltips</a>
                              </li>
                         </ul>
                    </div>
               </li>

               <li class="menu-title">Other</li>

               <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarLayouts" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="sidebarLayouts">
                         <span class="nav-icon">
                              <iconify-icon icon="mingcute:layout-line"></iconify-icon>
                         </span>
                         <span class="nav-text"> Layouts </span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                         <ul class="nav sub-navbar-nav">
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['layouts-demo','dark-sidenav']) }}" target="_blank">Dark
                                        Sidenav</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['layouts-demo','dark-topnav']) }}" target="_blank">Dark
                                        Topnav</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['layouts-demo','small-sidenav']) }}" target="_blank">Small
                                        Sidenav</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="{{ route ('second' , ['layouts-demo','hidden-sidenav']) }}" target="_blank">Hidden
                                        Sidenav</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" target="_blank" href="{{ route ('second' , ['layouts-demo','light']) }}">
                                        <span class="nav-text">Light Mode</span>
                                        <span class="badge badge-soft-danger badge-pill text-end">Hot</span>
                                   </a>
                              </li>
                         </ul>
                    </div>
               </li>

               <li class="nav-item">
                    <a class="nav-link disabled" href="javascript:void(0);">
                         <span class="nav-icon">
                              <iconify-icon icon="mingcute:close-circle-line"></iconify-icon>
                         </span>
                         <span class="nav-text"> Disable Item </span>
                    </a>
               </li>
          </ul>
     </div>
</div>


<div class="animated-stars">
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
     <div class="shooting-star"></div>
</div>
