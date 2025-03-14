@extends('layouts.main')

@include('detail-booking')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Riwayat Booking</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Riwayat Booking</a></div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Cari Riwayat Booking</h4>
                        </div>
                        <div class="card-body">
                            <form id="searchForm">
                                <div class="form-group">
                                    <label for="no_hp">Masukkan No HP</label>
                                    <input type="text" id="no_hp" name="no_hp" class="form-control"
                                        placeholder="Contoh: 081234567890" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Hasil Pencarian</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>No HP</th>
                                        <th>Status</th>
                                        <th>Category & Sesi</th>
                                        <th>Tanggal Booking</th>
                                    </tr>
                                </thead>
                                <tbody id="bookingData">
                                    <tr>
                                        <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $("#searchForm").submit(function(e) {
                e.preventDefault();
                var no_hp = $("#no_hp").val();

                $.ajax({
                    url: "/riwayat-booking/search",
                    type: "GET",
                    data: {
                        no_hp: no_hp
                    },
                    success: function(response) {
                        var tableBody = $("#bookingData");
                        tableBody.empty();

                        if (response.success && response.data.length > 0) {
                            $.each(response.data, function(index, booking) {
                                tableBody.append(`
                                    <tr>
                                        <td>${booking.id}</td>
                                        <td>${booking.name}</td>
                                        <td>${booking.no_hp}</td>
                                        <td><span class="badge badge-${booking.status === 'paid' ? 'success' : 'danger'}">${booking.status}</span></td>
                                         <td>${booking.category_ps} / ${booking.session} sesi</td>
                                        <td>${booking.selected_date}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            tableBody.append(
                                `<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>`
                            );
                        }
                    }
                });
            });
        });
    </script>
@endsection
