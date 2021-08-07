@extends('layouts.master')
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }
    </style>
@endsection
@section('title')
    معاينه طباعة الفاتورة
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    معاينة طباعة الفاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="my_print">
                <div class="card card-invoice">

                    <div class="card-body">
                        <div class="invoice-header">
                            <div class="billed-from">
                                <h6>Mahmoud Elmenofy, Inc.</h6>
                                <p>Alexandria<br>
                                    Tel No: 01552439651<br>
                                    Email: elmenofym8@gmail.com</p>
                            </div>
                            <!-- billed-from -->
                            <h1 class="invoice-title">فاتورة تحصيل</h1>
                        </div><!-- invoice-header -->
                        <div class="row">
                            <div class="col-md">
                                <label class="tx-gray-600">معلومات الفاتورة</label>
                                <p class="invoice-info-row"><span>رقم الفاتورة</span>
                                    <span>{{ $invoices->invoice_number }}</span></p>
                                <p class="invoice-info-row"><span>تاريخ الاصدار</span>
                                    <span>{{ $invoices->invoice_Date }}</span></p>
                                <p class="invoice-info-row"><span>تاريخ الاستحقاق</span>
                                    <span>{{ $invoices->Due_date }}</span></p>
                                <p class="invoice-info-row"><span>القسم</span>
                                    <span>{{ $invoices->section->section_name }}</span></p>
                            </div>

                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th class="wd-20p">#</th>
                                    <th class="">المنتج</th>
                                    <th class="">مبلغ التحصيل</th>
                                    <th class="">مبلغ العمولة</th>
                                    <th class="">الاجمالي</th>
                                    <th class="">نسبة الضريبه </th>
                                    <th class="">قيمة الخصم</th>
                                    <th class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل الضريبة</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="">1</td>
                                    <td>{{ $invoices->product }}</td>
                                    <td>{{ number_format($invoices->Amount_collection, 2) }}</td>
                                    <td>{{ number_format($invoices->Amount_Commission, 2) }}</td>
                                    @php
                                        $total = $invoices->Amount_collection + $invoices->Amount_Commission ;
                                    @endphp
                                    <td>{{ number_format($total, 2) }}</td>
                                    <td class="">{{ $invoices->Rate_VAT }}</td>
                                    <td> {{ number_format($invoices->Discount, 2) }}</td>
                                    <td>
                                        <h4 class="tx-primary tx-bold">{{ number_format($invoices->Total, 2) }}</h4>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">



                        <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button"> <i
                                class="mdi mdi-printer ml-1"></i>طباعة</button>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- JQuery min js -->
    <script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>


    <script type="text/javascript">
        $('#print_Button').click(function(){
            window.print();
            location.reload()
        });

        // function printDiv() {
        //     var printContents = document.getElementById('print').innerHTML;
        //     var originalContents = document.body.innerHTML;
        //     document.body.innerHTML = printContents;
        //     window.print();
        //     document.body.innerHTML = originalContents;
        //     location.reload();
        // }
    </script>
@endsection
