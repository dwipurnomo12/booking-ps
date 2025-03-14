@extends('layouts.main')

@include('detail-booking')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Booking PS</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Booking Ps</a></div>
            </div>
        </div>

        <div class="section-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4>Pilih Hari / Tanggal</h4>
                            </div>
                            <div class="card-body">
                                <div class="mt-3">
                                    <div id="calendar"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-3">
                                            <label for="session">Tentukan Sesi <span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="session" id="session"
                                                min="1" value="1">
                                            @error('session')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-3">
                                            <label>Pilih Jenis PS <span style="color: red">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="categroy_ps"
                                                    id="ps4" value="ps4" checked>
                                                <label class="form-check-label" for="ps4">PS4 - Rp 30.000 /
                                                    sesi</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="categroy_ps"
                                                    id="ps5" value="ps5">
                                                <label class="form-check-label" for="ps5">PS5 - Rp 40.000 /
                                                    sesi</label>
                                            </div>
                                            @error('category_ps')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p><span style="color: red">*</span> Tambahan Rp 50.000 jika pemesanan dilakukan pada hari
                                    Sabtu atau Minggu.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header bg-primary text-white">
                                <h4>Data Diri & Biaya</h4>
                            </div>
                            <div class="card-body">
                                <div class="mt-3">
                                    <label for="name">Masukkan Nama Anda <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="no_hp">Nomor HP <span style="color: red">*</span></label>
                                    <input type="number" class="form-control" name="no_hp" id="no_hp">
                                    @error('no_hp')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-3">
                                            <label for="booking_day">Hari</label>
                                            <input type="text" name="booking_day" id="booking_day" class="form-control"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-3">
                                            <label for="selected_date">Tanggal Terpilih</label>
                                            <input type="text" name="selected_date" id="selected_date"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="total_price">Total Harga</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                                        </div>
                                        <input type="text" name="total_price" id="total_price" class="form-control"
                                            readonly>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="button" id="clearForm" class="btn btn-danger float-right">Batal</button>
                                <button type="button" id="store" class="btn btn-primary float-right mr-2">Booking
                                    Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Full Calendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                validRange: {
                    start: moment().format('YYYY-MM-DD')
                },
                locale: 'id',
                dateClick: function(info) {
                    $("#selected_date").val(info.dateStr);
                    hitungHarga(info.dateStr);
                }
            });

            calendar.render();

            function hitungHarga(dateStr) {
                let session = parseInt($("#session").val()) || 1;
                let categoryPs = $("input[name='categroy_ps']:checked").val();
                let pricePerSession = (categoryPs === "ps5") ? 40000 : 30000;

                let date = new Date(dateStr);
                let dayNames = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                let day = dayNames[date.getDay()];
                let additionalPrice = (date.getDay() === 6 || date.getDay() === 0) ? 50000 : 0;

                let totalPrice = (pricePerSession + additionalPrice) * session;

                $("#booking_day").val(day);
                $("#total_price").val(totalPrice);
            }

            $("input[name='categroy_ps']").change(function() {
                let dateStr = $("#selected_date").val();
                if (dateStr) hitungHarga(dateStr);
            });

            $("#session").on("input", function() {
                let dateStr = $("#selected_date").val();
                if (dateStr) hitungHarga(dateStr);
            });

            $(document).ready(function() {
                $("#clearForm").click(function() {
                    clearForm();
                });
            });

            function clearForm() {
                $('#sesi').val('');
                $('input[name="jenis_ps"]').prop('checked', false);
                $('#name').val('');
                $('#no_hp').val('');
                $('#booking_day').val('');
                $('#selected_date').val('');
                $('#total_price').val('');
            }

            // Store data booking
            $('#store').click(function(e) {
                e.preventDefault();

                let session = $('#session').val().trim();
                let category_ps = $("input[name='categroy_ps']:checked").val();
                let name = $('#name').val().trim();
                let no_hp = $('#no_hp').val().trim();
                let booking_day = $('#booking_day').val().trim();
                let selected_date = $('#selected_date').val().trim();
                let total_price = $('#total_price').val().trim();
                let token = $("meta[name='csrf-token']").attr("content");

                if (!session || !category_ps || !name || !no_hp || !booking_day || !selected_date || !
                    total_price) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Harap isi semua bidang yang diperlukan!',
                    });
                    return;
                }

                let formData = new FormData();
                formData.append('session', session);
                formData.append('category_ps', category_ps);
                formData.append('name', name);
                formData.append('no_hp', no_hp);
                formData.append('booking_day', booking_day);
                formData.append('selected_date', selected_date);
                formData.append('total_price', total_price);
                formData.append('_token', token);

                $.ajax({
                    url: '/booking',
                    type: "POST",
                    cache: false,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#detail-session').text(session);
                        $('#detail-category_ps').text(category_ps);
                        $('#detail-name').text(name);
                        $('#detail-no_hp').text(no_hp);
                        $('#detail-booking_day').text(booking_day);
                        $('#detail-selected_date').text(selected_date);
                        $('#detail-total_price').text(total_price);
                        $('#detail-status').text(response.status);
                        $('#detail-booking_id').text(response.booking_id);

                        clearForm();
                        $('#detailModal').modal('show');

                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = "Terjadi kesalahan!";

                        if (errors) {
                            errorMessage = Object.values(errors).map(error => error[0]).join(
                                "\n");
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errorMessage,
                        });
                    }
                });
            });
        });

        // Snap token
        $(document).ready(function() {
            $('#pay-button').click(function() {
                let token = $('meta[name="csrf-token"]').attr('content');
                let bookingId = $('#detail-booking_id').text();

                $('#detail-status')
                    .text('unpaid')
                    .removeClass('badge-success')
                    .addClass('badge-danger');

                $.ajax({
                    type: 'POST',
                    url: '/booking/pay',
                    data: {
                        _token: token,
                        booking_id: bookingId
                    },
                    success: function(response) {
                        var snapToken = response.snapToken;
                        window.snap.pay(snapToken, {
                            onSuccess: function(result) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pambayaran Berhasil !',
                                    text: 'Pembayaran Anda Telah Diproses !',
                                }).then((result) => {
                                    $('#pay-button').hide();
                                    $('#detail-status')
                                        .text('paid')
                                        .removeClass('badge-danger')
                                        .addClass('badge-success');
                                });
                            },
                            onPending: function(result) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Pembayaran Tertunda',
                                    text: 'Menunggu pembayaran Anda...',
                                }).then((result) => {
                                    console.log(result);
                                });
                            },
                            onError: function(result) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Pembayaran gagak',
                                    text: 'Ups! Ada yang salah dengan pembayaran Anda',
                                }).then((result) => {
                                    console.log(result);
                                });
                            },
                            onClose: function() {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Pembayaran Dibatalkan',
                                    text: 'Anda menutup popup tanpa menyelesaikan pembayaran',
                                });
                            }
                        });
                    },

                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
