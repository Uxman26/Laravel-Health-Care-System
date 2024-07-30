
<!DOCTYPE html>
<html>
    <head> 
        <title>Jdmea Mail</title>  
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div style="max-width:640px; margin:0 auto;">
            <div style="/*width:620px;*/background:rgb(42 118 54); /*padding: 0px 10px;*/ border:1px solid #dcd7d7;"> 
                <div style="float: none; text-align: center; margin-top: 0px; background:url('{{ URL::to('/') }}') repeat center center;background-color: #c6c9ed;">
                        <img src="{{asset('public/front_assets/images/logo-dark.png')}}" width="240" alt="">
                </div>
            </div>
            <div style="max-width:620px; border:1px solid #f0f0f0; margin:0 0; padding:15px; ">
                <h1 style="font-family:Arial; font-size:16px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">Dear  @if(@$data['type'] == 'admin') Jdmea Admin @else {{@$data['customer_name']}} @endif ,</h1>

                <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;background: #ffffff;">
                    <p style="font-family:Arial; font-size:15px; font-weight:500; text-align:center; color:#000;padding: 4px; background:#ffffff;">
                   
                   <b style="float:left; text-align:left;">Car Make :</b> <span style="padding:0 5px;float:left; text-align:left;"> {{@$data['car_make']}} </span><br>
                   <b style="float:left; text-align:left;">Car Model-Year :</b>  <span style="padding:0 5px;float:left; text-align:left;"> {{@$data['car_model']}} - {{@$data['car_year']}}</span><br>

                   @if(@$data['type'] == 'admin')
                   <b style="float:left; text-align:left;">Customer Name :</b> <span style="padding:0 5px;float:left; text-align:left;"> {{@$data['customer_name']}} </span><br>
                   <b style="float:left; text-align:left;">Customer Email :</b>  <span style="padding:0 5px;float:left; text-align:left;"> {{@$data['customer_email']}}</a></span><br>
                   <b style="float:left; text-align:left;">Shipping Name :</b>  <span style="padding:0 5px;float:left; text-align:left;">{{@$data['shiping_name']}} </span><br>
                   <b style="float:left; text-align:left;">Shipping Email :</b>  <span style="padding:0 5px;float:left; text-align:left;"> {{@$data['shiping_email']}}</a></span><br>
                   <b style="float:left; text-align:left;">Shipping Phone :</b>  <span style="padding:0 5px;float:left; text-align:left;">{{@$data['shiping_phone']}} </span><br>
                   <b style="float:left; text-align:left;">Shipping Address :</b>  <span style="padding:0 5px;float:left; text-align:left;">{{@$data['shiping_address']}} </span><br>
                   @endif

                   <b style="float:left; text-align:left;">Car Price :</b> <span style="padding:0 5px;float:left; text-align:left;"> ${{@$data['car_price']}} </span><br>
                   <b style="float:left; text-align:left;">VAT Amount :</b>  <span style="padding:0 5px;float:left; text-align:left;"> ${{@$data['vat_amount']}}</a></span><br>
                   <b style="float:left; text-align:left;">Total Amount :</b>  <span style="padding:0 5px;float:left; text-align:left;">${{@$data['total']}} </span><br>
                   <b style="float:left; text-align:left;">Advanced Amount :</b>  <span style="padding:0 5px;float:left; text-align:left;"> ${{@$data['advanced']}}</a></span><br>
                   <b style="float:left; text-align:left;">Due Amount :</b>  <span style="padding:0 5px;float:left; text-align:left;">${{@$data['due']}} </span><br>
                    </p>

                </div>
               

                <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
                    <p style="font-family:Arial; font-size:15px; font-weight:500; text-align:center; color:#000;padding: 4px; background:#ffffff;">
                    {{ @$data['msg1'] }}
                    </p>

                </div>

                @if(@$data['link'])
                <div style="display:block;overflow:hidden; width:100%; text-align:center; margin: 0px 0px 10px 0px;">
               
                        <a href="{{ @$data['link'] }}" style="font-family: Arial;
                                                    border-radius: 4px;
                                                    font-size: 17px;
                                                    font-weight: 500;
                                                    color:#FFF;
                                                    display: inline-block;
                                                    padding: 8px 15px; 
                                                    background:#1F80AA; 
                                                    text-decoration: none;">Booking Details</a>
               
                </div>
                @endif
                
                <p style="font-family:Arial; font-size:15px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Thanks and Regard</p>
                <p style="font-family:Arial; font-size:15px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Team Jdmea</p>
            </div>
        </div>
    </body>
</html>
