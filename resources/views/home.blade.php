@extends('layouts.app')
@section('title')
Jdmea
@endsection
@section('style')
@include('includes.style')
@endsection


@section('header')
@include('includes.header')
@endsection

@section('content')

<section class="first-sec">
  <div class="container-big">
    <div class="sec-header first-hd">
      <h2>Some Caption will be shown here</h2>
      <p>Building an electrified future, today</p>
    </div>
    <div class="first-inr">
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <div class="first-box">
            <div id="carouselExampleInterval" class="carousel slide"  data-bs-ride="carousel"  data-bs-interval="10000">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <div class="first-inbx">
                    <img src="images/first-1.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Tesla Model 3</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first-2.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Audi e-tron GT RS</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first3.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>2022 BMW iX</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first4.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Jaguar I-Pace</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
              </button>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="first-box">
            <div id="carouselExampleInterval2" class="carousel slide"  data-bs-ride="carousel"  data-bs-interval="10000">
              <div class="carousel-inner">
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first-1.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Tesla Model 3</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item active">
                  <div class="first-inbx">
                    <img src="images/first-2.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Audi e-tron GT RS</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first3.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>2022 BMW iX</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first4.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Jaguar I-Pace</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval2" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval2" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
              </button>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="first-box">
            <div id="carouselExampleInterval3" class="carousel slide"  data-bs-ride="carousel"  data-bs-interval="10000">
              <div class="carousel-inner">
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first-1.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Tesla Model 3</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first-2.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Audi e-tron GT RS</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item active">
                  <div class="first-inbx">
                    <img src="images/first3.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>2022 BMW iX</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first4.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Jaguar I-Pace</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval3" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval3" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
              </button>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="first-box">
            <div id="carouselExampleInterval4" class="carousel slide"  data-bs-ride="carousel"  data-bs-interval="10000">
              <div class="carousel-inner">
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first-1.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Tesla Model 3</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first-2.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Audi e-tron GT RS</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="first-inbx">
                    <img src="images/first3.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>2022 BMW iX</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
                <div class="carousel-item active">
                  <div class="first-inbx">
                    <img src="images/first4.png" alt="" class="first-inbx-img">
                    <span class="first-ovrlay"></span>
                    <div class="first-txt">
                      <h3>Jaguar I-Pace</h3>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem</p>
                      <a href="#">View More</a>
                    </div>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval4" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval4" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="other">
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" data-bs-interval="10000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="other-box">
          <img src="images/other-img.png" alt="" class="other-img">
          <span class="other-overlay"></span>
          <div class="container-big">
            <div class="other-txt">
              <h3>See Others</h3>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
              <a href="#">View More <img src="images/btn-arrw.png" alt=""></a>
            </div>
          </div> 
        </div>
      </div>
      <div class="carousel-item">
        <div class="other-box">
          <img src="images/other-img.png" alt="" class="other-img">
          <span class="other-overlay"></span>
          <div class="container-big">
            <div class="other-txt">
              <h3>See Others</h3>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
              <a href="#">View More <img src="images/btn-arrw.png" alt=""></a>
            </div>
          </div> 
        </div>
      </div>
      <div class="carousel-item">
        <div class="other-box">
          <img src="images/other-img.png" alt="" class="other-img">
          <span class="other-overlay"></span>
          <div class="container-big">
            <div class="other-txt">
              <h3>See Others</h3>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
              <a href="#">View More <img src="images/btn-arrw.png" alt=""></a>
            </div>
          </div> 
        </div>
      </div>
    </div>
    <button class="carousel-control-prev other-arrow" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next other-arrow" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
  </div>   
</section>


<section class="video-sec">
  <div class="container">
    <div class="sec-header vid-hd">
      <h2>Some Caption will be shown here</h2>
    </div>
    <div class="vid-sec-inr">
      <div class="vid-box">
        <div class="vid-box-img">
          <iframe src="https://www.youtube.com/embed/q5PPNZiu52w" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        <div class="vid-txt">
          <h4>Video Caption / title will be shown here</h4>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
        </div>
      </div>
      <div class="vid-box">
        <div class="vid-box-img">
          <iframe src="https://www.youtube.com/embed/NDI6VaBqEqc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        <div class="vid-txt">
          <h4>Video Caption / title will be shown here</h4>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection


@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')
@endsection

