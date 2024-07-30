<header>
    <div class="container-fluid">
        <div class="header-inr">
            <div class="header-lft d-flex justify-content-start align-items-center">
                <a href="#" class="logo-header logo-vis"><img src="{{asset('public/front_assets/images/logo1.png')}}" alt=""></a>
                <button class="menu-lft" onclick="addBG()"><img src="{{asset('public/front_assets/images/menu.png')}}" alt=""></button>               
            </div>
            <div class="header-r8 d-flex justify-content-between align-items-center">
                <div class="hdr-date">
                    <h3>08 August, 2022</h3>
                    <p>12 : 31 PM</p>
                </div>
                <div class="hdr-iden d-flex justify-content-end align-items-center">
                    <div class="hd-r8-name">
                        @if(Auth::user())<h3>{{ Auth::user()->user_type == 'E' ? Auth::user()->empID : '' }}</h3>@endif
                        <p>{{ Auth::user() ? Auth::user()->name : '' }}</p>
                    </div>
                    <div class="hd-r8-img"><img src="{{asset('public/front_assets/images/hd-r8-img.png')}}" alt=""></div>
                </div>                
            </div>
        </div>
    </div>
</header>