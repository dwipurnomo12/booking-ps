<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailModalLabel">Detail Booking</h5>
            </div>
            <div class="modal-body">
                <div id="snap-container"></div>

                <table class="table">
                    <tr>
                        <td>Booking Id</td>
                        <td>:</td>
                        <td><span id="detail-booking_id"></span></td>
                    </tr>
                    <tr>
                        <td>Jumlah Sesi</td>
                        <td>:</td>
                        <td><span id="detail-session"></span></td>
                    </tr>
                    <tr>
                        <td>Jenis PS</td>
                        <td>:</td>
                        <td><span id="detail-category_ps"></span></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><span id="detail-name"></span></td>
                    </tr>
                    <tr>
                        <td>No HP</td>
                        <td>:</td>
                        <td><span id="detail-no_hp"></span></td>
                    </tr>
                    <tr>
                        <td>Hari/Tanggal</td>
                        <td>:</td>
                        <td><span id="detail-booking_day"></span>, <span id="detail-selected_date"></span></td>
                    </tr>
                    <tr>
                        <td>Total Harga</td>
                        <td>:</td>
                        <td>Rp. <span id="detail-total_price"></span></td>
                    </tr>
                    <tr>
                        <td>Status Pembayaran</td>
                        <td>:</td>
                        <td>
                            <span class="badge badge-danger" id="detail-status">
                            </span>
                        </td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="pay-button" class="btn btn-primary">Bayar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
