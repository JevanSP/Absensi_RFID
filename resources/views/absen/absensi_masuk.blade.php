<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SkaSa++</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Nunito:wght@300;400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Carousel wrapper -->
    <div id="carouselVideoExample" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <div id="absen-result"
            class="d-none position-absolute top-50 start-50 translate-middle p-4 rounded-4 shadow-lg text-center"
            style="z-index: 1000; background: rgba(0, 0, 0, 0.85); color: #fff; font-size: 20px; min-width: 320px; max-width: 90vw;">
            <div id="absen-content" class="mt-3"></div>
        </div>

        <!-- Inner -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <style>
                    video {
                        width: 100vw;
                        height: 100vh;
                        object-fit: cover;
                    }
                </style>
                <video class="img-fluid" autoplay loop muted>
                    <source src="{{ asset('assets/video/smik.mp4') }}" type="video/mp4" />
                </video>
            </div>
        </div>

        <!-- Animasi teks berjalan -->
        <div class="position-absolute bottom-0 start-0 end-0 text-center py-3"
            style="background: rgba(0, 0, 0, 0); z-index: 100; color: white;">
            <marquee behavior="scroll" direction="left" scrollamount="6" style="font-size: 3rem;">
                SELAMAT DATANG DI SISTEM ABSENSI SMIKPA++ SMKN 1 PACITAN – DISIPLIN ADALAH KUNCI KESUKSESAN!
            </marquee>
        </div>

        <!-- Tombol Dashboard -->
        <a href="{{ route('dashboard.admin_guru') }}"
            class="position-absolute top-0 start-0 m-3 btn btn-light rounded-pill shadow" style="z-index: 1000;">
            🏠 Dashboard
        </a>

        <!-- Jam Digital -->
        <div id="clock" class="position-absolute top-0 end-0 m-3 px-4 py-2 rounded-4 shadow"
            style="background-color: rgba(0, 0, 0, 0.75); color: white; font-size: 2rem; z-index: 1000;">
            00:00:00
        </div>

    </div>

    <!-- Form tersembunyi untuk input RFID -->
    <form method="POST" action="{{ route('absen_masuk.rfid') }}"
        style="autocomplete: off; position: absolute; left: -9999999px;">
        @csrf
        <input type="text" class="form-control" name="rfid_tag" autofocus>
    </form>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function () {
            const form = $('form[action="{{ route('absen_masuk.rfid') }}"]');
            const input = form.find('input[name="rfid_tag"]');

            form.on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        const resultBox = $('#absen-result');
                        let warna = '#4caf50';
                        let icon = 'bi-person-check';

                        if (res.message === 'Siswa sudah absen hari ini') {
                            warna = '#ffc107';
                            icon = 'bi-exclamation-circle';
                        }

                        $('#absen-content').html(`
                            <i class="bi ${icon}" style="font-size: 2.5rem; color: ${warna};"></i>
                            <div class="mt-3">
                                <strong>${res.message}</strong><br>
                                <hr class="text-light my-2">
                                <img src="storage/${res.siswa.foto}" alt="Foto Siswa" class="rounded-circle shadow"
                                    style="width: 120px; height: 120px; object-fit: cover; border: 3px solid ${warna};"><br><br>
                                <div class="text-start">
                                    <strong>Nama:</strong> ${res.siswa.nama_siswa}<br>
                                    <strong>NIS:</strong> ${res.siswa.nis}<br>
                                    <strong>Kelas:</strong> ${res.siswa.kelas}<br>
                                    <strong>Jam Masuk:</strong> ${res.siswa.jam_masuk}<br>
                                    <strong>Status:</strong> ${res.siswa.status}<br>
                                </div>
                            </div>
                        `);

                        resultBox.removeClass('d-none').hide().fadeIn(500);

                        let audio = new Audio(
                            res.message === 'Siswa sudah absen hari ini'
                                ? "https://www.myinstants.com/media/sounds/error.mp3"
                                : "https://www.myinstants.com/media/sounds/correct.mp3"
                        );
                        audio.play();

                        setTimeout(() => {
                            resultBox.fadeOut(500);
                        }, 5000);

                        input.val('').focus();
                    }
                });
            });

            input.on('change', function () {
                form.submit();
            });
        });

        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>

    <!-- Vendor JS -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
