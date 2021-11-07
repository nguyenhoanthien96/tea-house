<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>The Tea House</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
            <h5 class="my-0 mr-md-auto font-weight-normal">The Tea House</h5>
        </div>
        <div class="container">
            <!-- Content here -->
            
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="gift_code" class="col-form-label">Mã dự thưởng</label>
                </div>
                <div class="col-auto">
                    <input type="text" id="gift_code" class="form-control" aria-describedby="">
                </div>
                <div class="col-auto">
                    <button id="submit" class="btn btn-primary">Nhận quà</button>
                </div>
                <div class="col-auto ms-auto">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#gift_code_list_modal">Danh sách mã dự thưởng</button>
                </div>
            </div>

            <div id="error-alert" class="alert alert-danger mt-3 d-none" role="alert">
                This is a primary alert—check it out!
            </div>

            <h3 class="mt-4">Danh sách nhân viên trúng thưởng</h3>

            <table id="employee_gift_table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>SĐT Nhân Viên</th>
                        <th>Quà</th>
                        <th>Cửa Hàng</th>
                        <th>Ngày Trúng Thưởng</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div id="received_gift_modal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="received_gift_content">Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="gift_code_list_modal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="gift_code_list_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã Dự Thưởng</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/datatable.js') }}"></script>

    <script type="text/javascript">
        const receivedGiftModal = new bootstrap.Modal(document.getElementById("received_gift_modal"), {});
        const giftCodeListModal = document.getElementById('gift_code_list_modal')
        const receivedGiftContent = document.getElementById('received_gift_content')
        const btnSubmit = document.getElementById('submit')
        const errorAlert = document.getElementById('error-alert')

        const urlGetGift = "{{ route('get_gift') }}"
        const urlGiftCodeListTable = "{{ route('gift_code') }}"
        const urlemployeeGiftTable = "{{ route('employee_gift') }}"

        const employeeGiftTable = $('#employee_gift_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: urlemployeeGiftTable,
            responsive: true,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'employee_phone', name: 'employee_phone'},
                {data: 'gift', name: 'gift'},
                {data: 'store_id', name: 'store_id'},
                {data: 'created_at', name: 'created_at'},
            ],
            "language": {
                "sProcessing":   "Đang xử lý...",
                "sLengthMenu":   "Xem _MENU_ mục",
                "sZeroRecords":  "Không tìm thấy dòng nào phù hợp",
                "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix":  "",
                "sSearch":       "Tìm:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Đầu",
                    "sPrevious": "Trước",
                    "sNext":     "Tiếp",
                    "sLast":     "Cuối"
                }
            }
        })

        const giftCodeListTable = $('#gift_code_list_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: urlGiftCodeListTable,
            responsive: true,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'gift_code', name: 'gift_code'},
            ],
            "language": {
                "sProcessing":   "Đang xử lý...",
                "sLengthMenu":   "Xem _MENU_ mục",
                "sZeroRecords":  "Không tìm thấy dòng nào phù hợp",
                "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix":  "",
                "sSearch":       "Tìm:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Đầu",
                    "sPrevious": "Trước",
                    "sNext":     "Tiếp",
                    "sLast":     "Cuối"
                }
            }
        })

        btnSubmit.addEventListener('click', (e) => {
            e.preventDefault()
            const giftCode = document.getElementById('gift_code').value;

            errorAlert.innerText = ""
            errorAlert.classList.add('d-none')
            axios.post(urlGetGift, {gift_code: giftCode})
                .then(response => {
                    const data = response.data

                    let msg = 'Bạn chưa nhận được phần thưởng. Chúc bạn may mắn lần sau.';
                    if(data.gift) {
                        msg = "Chúc mừng nhân viên <strong>" + response.data.employee_phone + "</strong> nhận được <strong>" + response.data.gift + "</strong>"
                    }

                    employeeGiftTable.ajax.reload()
                    giftCodeListTable.ajax.reload()

                    received_gift_content.innerHTML = msg                     
                    receivedGiftModal.show()
                })
                .catch(e => {
                    const data = e.response.data

                    errorAlert.innerText = data.message
                    errorAlert.classList.remove('d-none')
                })
        })

        giftCodeListModal.addEventListener('show.bs.modal', function (event) {
            //trick to fix width of datatable in modal
            $('#gift_code_list_table').css("width", "")
        })
    </script>
</html>