<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('backend/')}}/images/favicon.jpg">
    <style>
        * {
            font-family: "Lucida Console", "Courier New", monospace;
        }
        @media print {
            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
            @page  {
               size:landscape;

            }
            /* print.css */
        }
    </style>
</head>

<body style="margin-bottom: 8px;">
<div class="page" style="padding-top:0px;">
    <div class="subpage">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:16px;font-family:Arial, Helvetica, sans-serif;">
            <tbody width="250px">
            <tr>
                <td colspan="3" style="padding-left:5px; padding-bottom:5px;">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td  style="padding-left:5px; height: 70px; width:115px;  border-right: 3px solid">
                                <img alt="Logo" src="{{ asset('images/logo.jpg')}}" class="logo" style="max-height: 70px;">
                            </td>
                            <td style="padding-left: 10px">
                                <span> <b style="letter-spacing: 3px;">{{ __('MERCHANT :') }}</b> {{ $parcel->merchant->business_name }}</span><br>
                                <span> {{$parcel->merchant->address}}</span><br>
                                <span style="font-size:18px; padding-top: 3px; font-weight:bold;"> {{$parcel->merchant->user->mobile}} </span><br>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 10px; margin-bottom: 10px">
                        <tbody>
                        <tr>
                            <td width="550px" style="padding-left:10px; padding-bottom: 10px; font-size:14px;border-right: 2px solid;border-top:#000000  1px solid;border-bottom:#000000 1px solid;">
                               <div style="padding-top: 10px;padding-bottom: 10px; ">
                                   <span><b style="letter-spacing: 3px;">{{ __('CUSTOMER :') }}</b> {{ $parcel->customer_name }}</span><br>
                                   <span style="font-size:18px;letter-spacing: 3px; font-weight:bold;">{{ $parcel->customer_phone }}</span><br><br>
                                   <span>{{ $parcel->customer_address }}</span>
                               </div>

                            </td>
                            <td  width="350px" style=" padding-left:10px; padding-bottom: 10px;font-size:14px;border-top:#000000  1px solid;border-bottom:#000000 1px solid;">
                                <div style="padding-bottom: 10px;padding-top: 10px; ">
                                <span><b style="letter-spacing: 3px;">AREA</b> : Mirpur-2</span><br><br>
                                <span><b style="letter-spacing: 3px;">HUB</b>  : {{ optional($parcel->hub)->name }}</span><br><br>
                                <span><b style="letter-spacing: 3px;">ZONE</b> : ISD </span><br>
                                </div>

                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:-5px !important; margin-bottom:20px;border-top:#000000 1px solid;border-bottom:#000000 1px solid;">
                        <tbody>
                        <tr>
                            <td style="padding:10px; font-size:12px; text-align:left">
                                <span style="font-weight:bold; font-size: 14px;">INVOICE: {{ $parcel->invoice_no }} </span>
                            </td>
                            <td style="padding:10px; font-size:12px; text-align:center">
                                <span style="font-weight:bold; font-size: 14px;">CASH: {{ $parcel->cash_collection }} </span>
                            </td>
                            <td style="padding:10px; font-size:12px; text-align:left">
                                <span style="font-weight:bold; font-size: 14px;">ROUTE: ISD</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                     <span >
                        <img class="mr-1 img-1" src="{{ $parcel->qrcodeprint }}" alt="{{ settings()->name }}">
                    </span>
                </td>
                <td style="padding-left:30px;">
                    <span>
                        <img src="{{ $parcel->barcodeprint }}" alt="{{ settings()->name }}">

                    </span><br>
                    <span style="padding-left: 240px;font-weight: bold;">{{ $parcel->tracking_id }}</span>

                </td>

            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    window.print();
</script>
</body>
</html>
