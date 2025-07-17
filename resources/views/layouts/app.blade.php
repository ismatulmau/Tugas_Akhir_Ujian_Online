<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Ujian Online</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
   


    <!-- Fonts and icons -->
    <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ["/assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="/assets/css/kaiadmin.min.css" />
    <!-- CSS for demo purpose -->
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <style>
        /* Sidebar active states */
        .sidebar .nav-item.active>.nav-link {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar .nav-collapse .nav-item.active>.nav-link {
            background-color: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        /* Sub menu item styling */
        .sidebar .nav-collapse .nav-link {
            padding-left: 50px;
            padding-top: 8px;
            padding-bottom: 8px;
        }

        /* Caret rotation */
        .sidebar .nav-link[aria-expanded="true"] .caret {
            transform: rotate(90deg);
        }

        .sidebar .nav-link .caret {
            transition: transform 0.2s ease;
            float: right;
            margin-top: 5px;
        }

        /* Efek hover untuk sub menu */
        .sidebar .nav-collapse .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* Transisi untuk efek halus */
        .sidebar .nav-link {
            transition: all 0.3s ease;
        }

        .sidebar .nav-item.active>.nav-link {
            transition: all 0.3s ease;
        }
        .logo-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
}

.logo {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: white;
}

.logo-text {
    margin-left: 10px;
    line-height: 1.2;
}

.school-name {
    font-weight: 600;
    font-size: 1.1rem;
    margin: 0;
}

.school-location {
    font-size: 0.8rem;
    opacity: 0.8;
    margin: 0;
}
    </style>
</head>

<body>
    <div class="wrapper">

        <!-- Sidebar -->
        @include ('layouts.sidebar')
        <!-- End Sidebar -->

        <!-- Main Panel -->
        <div class="main-panel">
            <!-- Main Header -->
            @include ('layouts.header')
            <!-- End Main Header -->

            <!-- Content -->
            <div class="container">
                <div class="page-inner">
                    @yield('page-header')

                    @yield('content')

                </div>
            </div>
            <!-- End Content -->

            <!-- Footer -->
            @include ('layouts.footer')
            <!-- End Footer -->

        </div>
        <!-- End Main Panel -->

    </div>

    <!-- Core JS Files -->
    <script src="/assets/js/core/jquery.min.js"></script>
    <script src="/assets/js/core/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/kaiadmin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable(); // Ganti #example dengan ID tabel Anda
        });
    </script>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[title]');
        tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tangani klik pada semua link sidebar (termasuk sub menu)
            document.querySelectorAll('.sidebar a').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Hapus semua active class
                    document.querySelectorAll('.sidebar .nav-item').forEach(item => {
                        item.classList.remove('active');
                    });

                    // Tambahkan active class ke parent item
                    let parentItem = this.closest('.nav-item');
                    if (parentItem) {
                        parentItem.classList.add('active');
                    }

                    // Jika ini sub menu item, aktifkan juga parent menu-nya
                    let parentCollapse = this.closest('.collapse');
                    if (parentCollapse) {
                        let parentNavItem = parentCollapse.closest('.nav-item');
                        if (parentNavItem) {
                            parentNavItem.classList.add('active');
                            // Buka collapse parent
                            let toggleLink = parentNavItem.querySelector('[data-bs-toggle="collapse"]');
                            if (toggleLink) {
                                toggleLink.classList.remove('collapsed');
                                toggleLink.setAttribute('aria-expanded', 'true');
                                let collapseId = toggleLink.getAttribute('href');
                                document.querySelector(collapseId).classList.add('show');
                            }
                        }
                    }
                });
            });

            // Set active state berdasarkan URL saat ini
            function setActiveMenu() {
                document.querySelectorAll('.sidebar a').forEach(link => {
                    if (link.href === window.location.href) {
                        link.classList.add('active');
                        let parentItem = link.closest('.nav-item');
                        if (parentItem) parentItem.classList.add('active');

                        // Buka parent collapse jika ada
                        let parentCollapse = link.closest('.collapse');
                        if (parentCollapse) {
                            let parentNavItem = parentCollapse.closest('.nav-item');
                            if (parentNavItem) {
                                parentNavItem.classList.add('active');
                                let toggleLink = parentNavItem.querySelector('[data-bs-toggle="collapse"]');
                                if (toggleLink) {
                                    toggleLink.classList.remove('collapsed');
                                    toggleLink.setAttribute('aria-expanded', 'true');
                                    parentCollapse.classList.add('show');
                                }
                            }
                        }
                    }
                });
            }

            setActiveMenu();
        });
    </script>
</body>

</html>