@extends('layouts.master')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
@section('title')
    قائمة الفواتير - برنامج الفواتير
@stop
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    @if (session()->has('status_update'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تحديث الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

@section('content')
    @if (session()->has('restore_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم اعادة الفاتورة من الارشفه",
                    type: "success"
                })
            }
        </script>
    @endif
				<!-- row -->
				<div class="row">
                        <!--div-->
                        <div class="col-xl-12">
                            <div class="card mg-b-20">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between">
                                        <div class="col-sm-6 col-md-3">
                                            @can('اضافة فاتورة')
                                            <a href="invoices/create" class="btn btn-primary btn-">أضف فاتوره<i
                                                    class="fas fa-plus mr-2"></i></a>
                                            @endcan
                                            @can('تصدير EXCEL')
                                            <a href="{{url('export_invoices')}}" class="btn btn-success btn-">تصدير اكسيل<i class="fas fa-file-download mr-2"></i></a>
                                                @endcan
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                                            <thead>
                                            <tr>
                                                <th class="border-bottom-0">#</th>
                                                <th class="border-bottom-0">رقم الفاتورة</th>
                                                <th class="border-bottom-0">تاريخ القاتورة</th>
                                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                                <th class="border-bottom-0">المنتج</th>
                                                <th class="border-bottom-0">القسم</th>
                                                <th class="border-bottom-0">الخصم</th>
                                                <th class="border-bottom-0">نسبة الضريبة</th>
                                                <th class="border-bottom-0">قيمة الضريبة</th>
                                                <th class="border-bottom-0">الاجمالي</th>
                                                <th class="border-bottom-0">الحالة</th>
                                                <th class="border-bottom-0">ملاحظات</th>
                                                <th class="border-bottom-0">العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                            $i = 0;
                                            @endphp
                                            @foreach($invoices as $invoice)
                                                @php
                                                    $i++;
                                                @endphp
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$invoice->invoice_number}}</td>
                                                <td>{{$invoice->invoice_Date}}</td>
                                                <td>{{$invoice->Due_date}}</td>
                                                <td>{{$invoice->product}}</td>
                                                <td>
                                                    <a href="{{ url('invoicesDetails') }}/{{ $invoice->id }}">{{$invoice->section->section_name}}</a>
                                                </td>
                                                <td>{{$invoice->Discount}}</td>
                                                <td>{{$invoice->Value_VAT}}</td>
                                                <td>{{$invoice->Rate_VAT}}</td>
                                                <td>{{$invoice->Total}}</td>
                                                <td>
                                                    @if($invoice->Value_Status == 1)
                                                        <span class="badge badge-success badge-pill">{{$invoice->Status}}</span>
                                                    @elseif($invoice->Value_Status == 2)
                                                        <span class="badge badge-danger badge-pill">{{$invoice->Status}}</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning">{{$invoice->Status}}</span>
                                                    @endif()
                                                </td>
                                                <td>{{$invoice->note}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button aria-expanded="false" aria-haspopup="true"
                                                                class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                                type="button">العمليات<i class="fas fa-caret-down mr-1"></i></button>
                                                        <div class="dropdown-menu tx-13">
                                                            @can('تعديل الفاتورة')
                                                                <a class="dropdown-item" href="{{route('invoices.edit',$invoice->id)}}">تعديل الفاتوره</a>
                                                            @endcan
                                                            @can('تفاصيل الفاتوره')
                                                                <a class="dropdown-item" href="{{ url('invoicesDetails',$invoice->id) }}">تفاصيل الفاتوره</a>
                                                                @endcan
                                                                @can('حذف الفاتورة')
                                                                <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                                data-toggle="modal" data-target="#delete_invoice"><i class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف الفاتورة</a>
                                                                @endcan
                                                                @can('تغير حالة الدفع')
                                                                <a class="dropdown-item" href="{{route('status_show',$invoice->id)}}"><i class="text-success fas fa-money-bill-alt ml-1"></i>تغيير حالة الدفع</a>
                                                                @endcan
                                                                @can('ارشفة الفاتورة')
                                                                <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                                data-toggle="modal" data-target="#Transfer_invoice"><i class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي الارشيف</a>
                                                                @endcan
                                                                @can('طباعةالفاتورة')
                                                                <a class="dropdown-item" href="{{ route('print_invoice',$invoice->id) }}"><i
                                                                    class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                                الفاتورة
                                                                </a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/div-->

                    <!-- modal delete -->
                    <div class="modal"  id="delete_invoice" >
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">حذف الفاتوره</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('invoices.destroy', 'test')}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div class="form-group">
                                            هل انت متأكد من عملية الحذف؟
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control"  name="invoice_id" id="invoice_id" value="" readonly>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">تاكيد</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Basic modal -->
                    </div>
                    <!-- /modal delete -->

                    <!-- modal archive -->
                    <div class="modal"  id="Transfer_invoice">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">ارشفة الفاتوره</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('invoices.destroy', 'test')}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div class="form-group">
                                            هل انت متأكد من عملية الارشفه؟
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control"  name="invoice_id" id="invoice_id" value="" readonly>
                                            <input type="hidden" class="form-control"  name="id_page" id="id_page" value="2" readonly>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">تاكيد</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Basic modal -->
                    </div>
                    <!-- /modal archive -->

                </div>
    </div>

                    </div>

@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    <script>
        // delete
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })

        // Archive
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>
@endsection
