
<!DOCTYPE html>
<html>
    <head> 
        <title>Verification Mail</title>  
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
                <h1 style="font-family:Arial; font-size:16px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">Dear Jdmea ,</h1>

                <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;background: #ffffff;">
                    <p style="font-family:Arial; font-size:15px; font-weight:500; text-align:center; color:#000;padding: 4px; background:#ffffff;">
                   
                   <b style="float:left; text-align:left;">Name :</b> <span style="padding:0 5px;float:left; text-align:left;"> {{@$data['name']}} </span><br>
                   <b style="float:left; text-align:left;">Email :</b>  <span style="padding:0 5px;float:left; text-align:left;"> <a href="mailto:{{ @$data['email'] }}">{{@$data['email']}} </a></span><br>
                   <b style="float:left; text-align:left;">Car Model :</b>  <span style="padding:0 5px;float:left; text-align:left;">{{@$data['model']}} </span><br>
                    </p>

                </div>
               

                <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
                    <p style="font-family:Arial; font-size:15px; font-weight:500; text-align:center; color:#000;padding: 4px; background:#ffffff;">
                    {{ @$data['msg1'] }}
                    </p>

                </div>
                
                <p style="font-family:Arial; font-size:15px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Thanks and Regard</p>
                <p style="font-family:Arial; font-size:15px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Team Jdmea</p>
            </div>
        </div>
    </body>
</html>
