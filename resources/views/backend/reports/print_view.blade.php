 <table>
     <thead>
         <tr>
             <th colspan="5" style="text-align: center"><b>Merchant Details</b></th>
         </tr>
         <tr>
             <th  style="text-align: center"><b>Name</b></th>
             <th  style="text-align: center"><b>Mobile</b></th>
             <th  style="text-align: center"><b>Address</b></th>
             <th  style="text-align: center"><b>Total Shops</b></th>
             <th  style="text-align: center"><b>Total Parcels</b></th>
         </tr>
     </thead>
    <tr>
        <td>{{ $merchant->business_name }}</td>
        <td>{{ $merchant->user->mobile }}</td>
        <td>{{ $merchant->address }}</td>
        <td>{{ $merchant->merchantShops->count() }}</td>
        <td>{{ $total_parcel }}</td>
    </tr>
</table>


 <table>
    <tr>
        <th>Total Statistics</th>
    </tr>
    <tr>
        <th colspan="2">Parcel Status </th>
        <th>Count </th>
    </tr>
    <tr>
        <td>1</td>
        <td>asdf</td>
        <td>4635546</td>
    </tr>
</table>
