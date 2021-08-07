@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('title')
    تفاصيل فاتورة
@stop
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتوره</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">

					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if (session()->has('delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
				<!-- row -->
				<div class="row">


                    <div class="panel panel-primary bg-white col tabs-style-2">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات الفاتوره</a></li>
                                    <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                    <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab4">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header pb-0">

                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped mg-b-0 text-md-nowrap">
                                                        <thead>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">1</th>
                                                            <td>رقم الفاتوره</td>
                                                            <td>{{$invoices->invoice_number}}</td>

                                                            <td>تاريخ الاصدار</td>
                                                            <td>{{$invoices->invoice_Date}}</td>

                                                            <td>تاريخ الاستحقاق</td>
                                                            <td>{{$invoices->Due_date}}</td>

                                                            <td>القسم</td>
                                                            <td>{{$invoices->section->section_name}}</td>

                                                            <td>المنتج</td>
                                                            <td>{{$invoices->product}}</td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row">2</th>
                                                            <td>مبلغ التحصيل</td>
                                                            <td>{{$invoices->Amount_collection}}</td>

                                                            <td>مبلغ العموله</td>
                                                            <td>{{$invoices->Amount_Commission}}</td>

                                                            <td>الخصم</td>
                                                            <td>{{$invoices->Discount}}</td>

                                                            <td>نسبة الضريبه</td>
                                                            <td>{{$invoices->Value_VAT}}</td>

                                                            <td>قيمة الضريبه</td>
                                                            <td>{{$invoices->Rate_VAT}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">3</th>
                                                            <td>الاجمالي مع الضريبه</td>
                                                            <td>{{$invoices->Total}}</td>

                                                            <td>الحاله الحاليه</td>
                                                            <td>
                                                                @if($invoices->Value_Status == 1)
                                                                    <span class="badge badge-success badge-pill">{{$invoices->Status}}</span>
                                                                @elseif($invoices->Value_Status == 2)
                                                                    <span class="badge badge-danger badge-pill">{{$invoices->Status}}</span>
                                                                @else
                                                                    <span class="badge badge-pill badge-warning">{{$invoices->Status}}</span>
                                                                @endif()
                                                            </td>
                                                            <td>الخصم</td>
                                                            <td>{{$invoices->Discount}}</td>

                                                            <td>الملاحظات</td>
                                                            <td>{{$invoices->note}}</td>

{{--                                                            <td>المستخدم</td>--}}
{{--                                                            <td>{{$invoices->Invoices_details->user}}</td>--}}
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div><!-- bd -->
                                            </div><!-- bd -->
                                        </div><!-- bd -->
                                    </div>
                                </div>


{{--                                ################### 2 taaaaaaaaaab ##########################--}}
                                <div class="tab-pane" id="tab5">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header pb-0">

                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped mg-b-0 text-md-nowrap">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>رقم الفاتوره</th>
                                                            <th>نوع المنتج</th>
                                                            <th>القسم</th>
                                                            <th>حالة الدفعه</th>
                                                            <th>تاريخ الدفع</th>
                                                            <th>ملاحظات</th>
                                                            <th>تاريح الاضافه</th>
                                                            <th>المستخدم</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $i = 0; ?>
                                                        @foreach($details as $detail)
                                                            <?php $i++ ?>
                                                            <tr>
                                                            <th scope="row">{{$i}}</th>
                                                                <td>{{$detail->invoice_number}}</td>
                                                                <td>{{$detail->product}}</td>
                                                                <td>{{$invoices->section->section_name}}</td>
                                                                <td>
                                                                    @if($detail->value_status == 1)
                                                                        <span class="badge badge-success badge-pill">{{$detail->status}}</span>
                                                                    @elseif($detail->value_status == 2)
                                                                        <span class="badge badge-danger badge-pill">{{$detail->status}}</span>
                                                                    @else
                                                                        <span class="badge badge-pill badge-warning">{{$detail->status}}</span>
                                                                    @endif()
                                                                </td>
                                                                <td>{{$detail->Payment_Date}}</td>
                                                                <td>{{$detail->note}}</td>
                                                                <td>{{$detail->created_at}}</td>
                                                                <td>{{$detail->user}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

{{--                                ################### 3 taaaaaaaaaab ##########################--}}
                                <div class="tab-pane" id="tab6">
                                    <div class="card mg-b-20">
                                        <div class="card-header pb-0">
                                            <div class="d-flex justify-content-between">
                                                @can('اضافة مرفق')
                                                <div class="card-body">
                                                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                    <h5 class="card-title">اضافة مرفقات</h5>
                                                    <form method="post" action="{{route('invoice_attachments.store')}}"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="" name="file_name" required>
                                                            <input type="hidden" id="" name="invoice_number" value="{{$invoices->invoice_number}}">
                                                            <input type="hidden" id="" name="invoice_id" value="{{$invoices->id}}">
                                                            <label class="custom-file-label" for="customFile">حدد
                                                                المرفق</label>
                                                        </div><br><br>
                                                        <button type="submit" class="btn btn-primary"
                                                                name="uploadedFile">تاكيد</button>
                                                    </form>
                                                </div>
                                                @endcan


                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered mg-b-0 text-md-nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>رقم الفاتوره</th>
                                                        <th>قام بالاضافه</th>
                                                        <th>تاريخ الاضافه</th>
                                                        <th>العمليات</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach($attachments as $attachment)
                                                        <?php $i++ ?>
                                                        <tr>
                                                            <th scope="row">{{$i}}</th>
                                                            <td>{{$attachment->file_name}}</td>
                                                            <td>{{$attachment->created_by}}</td>
                                                            <td>{{$attachment->created_at}}</td>

                                                            <td colspan="2">
                                                                <span>
                                                                    <a href="{{url('view_file')}}/{{$invoices->invoice_number}}/{{$attachment->file_name}}" class="btn btn-outline-primary btn-sm">عرض</a>
                                                                    <a href="{{url('download_file')}}/{{$invoices->invoice_number}}/{{$attachment->file_name}}" class="btn btn-outline-primary btn-sm">تحميل</a>
                                                                    @can('حذف المرفق')
                                                                    <button class="btn ripple btn-outline-danger btn-sm"
                                                                       data-file-name="{{$attachment->file_name}}"
                                                                       data-invoice-number="{{$attachment->invoice_number}}"
                                                                       data-id-file="{{$attachment->id }}"
                                                                       data-target="#delete_file" data-toggle="modal" href="">حذف</button>
                                                                    @endcan
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


{{--                    MODAL                 --}}
                    <div class="modal"  id="delete_file" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h4 class="modal-title">حذف المرفق</h4><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                                </div>
                                <form action="{{url('delete-file')}}" method="post">
                                    @csrf
                                <div class="modal-body">
                                    <h6>هل انت متأكد من حذف المرفق ؟</h6>

                                    <input type="text" value="" name="id_file" id="id_file">
                                    <input type="text" value="" name="file_name" id="file_name">
                                    <input type="text" value="" name="invoice_number" id="invoice_number">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                                    <button type="submit" class="btn btn-danger">تاكيد</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
{{--                    /MODAL                --}}
                </div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection

@section('js')
    <script>
        $('#delete_file').on('show.bs.modal', function (event){
            var button = $(event.relatedTarget)
            var id_file = button.data('id-file')
            var file_name = button.data('file-name')
            var invoice_number = button.data('invoice-number')
            var modal = $(this)

            modal.find('.modal-body #id_file').val(id_file)
            modal.find('.modal-body #file_name').val(file_name)
            modal.find('.modal-body #invoice_number').val(invoice_number)
        })
    </script>
@endsection
