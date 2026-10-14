
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'My Shop')</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background-color: #405cf5;
            min-height: 100vh;
            color: #212529;
        }

        /* MENU NAVIGASI */
        .navbar {
            background-color: #ffffff;
            border-radius: 22px;
            margin: 20px 0;
            padding: 20px 6%;
            min-height: 150px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-size: 28px;
            font-weight: 700;
            color: #111111 !important;
            white-space: nowrap;
            margin-right: 50px;
        }

        .navbar-nav {
            align-items: center;
            gap: 25px;
        }

        .nav-link {
            font-size: 20px;
            color: #777777;
            padding: 20px 10px !important;
            border-bottom: 4px solid transparent;
            white-space: nowrap;
            transition: 0.2s;
        }

        .nav-link:hover {
            color: #212529;
        }

        .nav-link.active {
            color: #212529;
            border-bottom-color: #818cf8;
        }

        /* PANEL HALAMAN */
        .content-card {
            background-color: #ffffff;
            border-radius: 30px;
            padding: 35px 25px;
            margin-bottom: 30px;
            min-height: 300px;
        }

        /* JUDUL TABEL */
        .table thead th {
            background-color: #212529;
            color: #ffffff;
            padding: 14px 12px;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: top;
            padding: 12px;
        }

        /* GAMBAR PRODUK */
        .product-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            background-color: #cccccc;
        }

        /* TOMBOL */
        .btn {
            border-radius: 7px;
        }

        /* TAMPILAN HP */
        @media (max-width: 991px) {
            .navbar {
                padding: 20px;
                min-height: auto;
            }

            .navbar-brand {
                margin-right: 10px;
                font-size: 24px;
            }

            .navbar-nav {
                align-items: flex-start;
                gap: 0;
                padding-top: 15px;
            }

            .nav-link {
                font-size: 17px;
                padding: 10px !important;
            }

            .content-card {
                padding: 20px 12px;
                border-radius: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid px-3 px-md-4">

        <!-- NAVIGASI UTAMA -->
        <nav class="navbar navbar-expand-lg">
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuNavigasi"
                aria-controls="menuNavigasi"
                aria-expanded="false"
                aria-label="Buka menu navigasi">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse"
                 id="menuNavigasi">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                            href="{{ route('products.index') }}">
                            Produk
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                            href="{{ route('categories.index') }}">
                            Kategori Produk
                        </a>
                    </li>

                </ul>
            </div>

        </nav>

        <!-- PESAN BERHASIL -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        <!-- PESAN ERROR -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- VALIDASI FORM -->
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali data yang dimasukkan:</strong>

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ISI HALAMAN -->
        @yield('content')

    </div>

        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1"
             aria-labelledby="deleteConfirmationTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="deleteConfirmationTitle">
                            Konfirmasi Hapus
                        </h2>
                        <button type="button" class="btn-close"
                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body" id="deleteConfirmationMessage"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger"
                                id="confirmDeleteButton">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JavaScript -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        </script>
        <script>
            const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
            const deleteConfirmation = bootstrap.Modal.getOrCreateInstance(deleteConfirmationModal);
            const deleteConfirmationMessage = document.getElementById('deleteConfirmationMessage');
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');
            let formToDelete = null;

            document.addEventListener('submit', (event) => {
                const form = event.target;

                if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-confirm-delete')) {
                    return;
                }

                if (form.dataset.confirmed === 'true') {
                    delete form.dataset.confirmed;
                    return;
                }

                event.preventDefault();
                formToDelete = form;
                deleteConfirmationMessage.textContent = form.dataset.confirmMessage;
                deleteConfirmation.show();
            });

            confirmDeleteButton.addEventListener('click', () => {
                if (!formToDelete) {
                    return;
                }

                formToDelete.dataset.confirmed = 'true';
                formToDelete.requestSubmit();
                formToDelete = null;
                deleteConfirmation.hide();
            });

            deleteConfirmationModal.addEventListener('hidden.bs.modal', () => {
                formToDelete = null;
            });
        </script>

</body>
</html>
